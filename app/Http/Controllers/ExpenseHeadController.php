<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExpenseHead\StoreExpenseHeadRequest;
use App\Http\Requests\ExpenseHead\UpdateExpenseHeadRequest;
use App\Models\ExpenseHead;
use App\Services\ExpenseHeadService;

class ExpenseHeadController extends Controller
{
    public function __construct(private readonly ExpenseHeadService $expenseHeadService) {}

    public function index()
    {
        $expenseHeads = $this->expenseHeadService->getAllForUser(auth()->id());
        return view('expense-heads.index', compact('expenseHeads'));
    }

    public function create()
    {
        return view('expense-heads.create');
    }

    public function store(StoreExpenseHeadRequest $request)
    {
        $this->expenseHeadService->create($request->validated(), auth()->id());
        return redirect()->route('expense-heads.index')
                         ->with('success', __('messages.created_successfully'));
    }

    public function edit(ExpenseHead $expenseHead)
    {
        $this->authorize('update', $expenseHead);
        return view('expense-heads.edit', compact('expenseHead'));
    }

    public function update(UpdateExpenseHeadRequest $request, ExpenseHead $expenseHead)
    {
        $this->authorize('update', $expenseHead);
        $this->expenseHeadService->update($expenseHead, $request->validated());
        return redirect()->route('expense-heads.index')
                         ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(ExpenseHead $expenseHead)
    {
        $this->authorize('delete', $expenseHead);
        $this->expenseHeadService->delete($expenseHead);
        return redirect()->route('expense-heads.index')
                         ->with('success', __('messages.deleted_successfully'));
    }
}