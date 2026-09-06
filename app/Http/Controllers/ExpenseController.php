<?php

namespace App\Http\Controllers;

use App\Http\Requests\Expense\StoreExpenseRequest;
use App\Http\Requests\Expense\UpdateExpenseRequest;
use App\Models\Animal;
use App\Models\Expense;
use App\Models\ExpenseHead;
use App\Services\ExpenseService;

class ExpenseController extends Controller
{
    public function __construct(private readonly ExpenseService $expenseService) {}

    private function getTemplateId(): int
    {
        $id = session('selected_template_id');
        if (!$id) abort(403, __('messages.select_template_first'));
        return $id;
    }

    public function index()
    {
        $templateId = $this->getTemplateId();
        $expenses   = $this->expenseService->getForTemplate($templateId, auth()->id());
        return view('expenses.index', compact('expenses'));
    }

    public function create()
    {
        $templateId = $this->getTemplateId();
        $animals    = Animal::forTemplate($templateId)->forUser(auth()->id())->get();
        $expenseHeads = ExpenseHead::forUser(auth()->id())->get();
        return view('expenses.create', compact('animals', 'expenseHeads'));
    }

    public function store(StoreExpenseRequest $request)
    {
        $templateId = $this->getTemplateId();
        $data       = $request->validated();

        $animals = $this->expenseService->targetAnimals($data, $templateId, auth()->id());
        if (!$this->expenseService->validateAllocationTotal($data, $animals, (float) $data['amount'])) {
            return redirect()->back()->withInput()
                             ->with('error', __('expenses.allocation_mismatch'));
        }

        $this->expenseService->create($data, $templateId, auth()->id());
        return redirect()->route('expenses.index')
                         ->with('success', __('messages.created_successfully'));
    }

    public function edit(Expense $expense)
    {
        $this->authorize('update', $expense);
        $templateId = $this->getTemplateId();
        $animals    = Animal::forTemplate($templateId)->forUser(auth()->id())->get();
        $expenseHeads = ExpenseHead::forUser(auth()->id())->get();
        $expense->load('distributions', 'expenseHead');
        return view('expenses.edit', compact('expense', 'animals', 'expenseHeads'));
    }

    public function update(UpdateExpenseRequest $request, Expense $expense)
    {
        $this->authorize('update', $expense);
        $data = $request->validated();

        $templateId = $expense->template_id;
        $animals    = $this->expenseService->targetAnimals($data, $templateId, $expense->user_id);
        if (!$this->expenseService->validateAllocationTotal($data, $animals, (float) $data['amount'])) {
            return redirect()->back()->withInput()
                             ->with('error', __('expenses.allocation_mismatch'));
        }

        $this->expenseService->update($expense, $data);
        return redirect()->route('expenses.index')
                         ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Expense $expense)
    {
        $this->authorize('delete', $expense);
        $this->expenseService->delete($expense);
        return redirect()->route('expenses.index')
                         ->with('success', __('messages.deleted_successfully'));
    }
}
