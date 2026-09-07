<?php

namespace App\Http\Controllers;

use App\Http\Requests\Animal\StoreAnimalRequest;
use App\Http\Requests\Animal\UpdateAnimalRequest;
use App\Models\Animal;
use App\Services\AnimalService;
use Illuminate\Http\Request;

class AnimalController extends Controller
{
    public function __construct(private readonly AnimalService $animalService) {}

    private function getTemplateId(): int
    {
        $id = session('selected_template_id');
        if (! $id) {
            abort(403, __('messages.select_template_first'));
        }

        return $id;
    }

    public function index()
    {
        $templateId = $this->getTemplateId();
        $animals = $this->animalService->getAllForTemplate($templateId, effective_user_id());

        return view('animals.index', compact('animals'));
    }

    public function create()
    {
        $this->getTemplateId();

        return view('animals.create');
    }

    public function store(StoreAnimalRequest $request)
    {
        $templateId = $this->getTemplateId();
        $this->animalService->create($request->validated(), $templateId, effective_user_id());

        return redirect()->route('animals.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function show(Animal $animal)
    {
        $animal->load('animalShares.partner');

        return view('animals.show', compact('animal'));
    }

    public function edit(Animal $animal)
    {
        $this->authorize('update', $animal);

        return view('animals.edit', compact('animal'));
    }

    public function update(UpdateAnimalRequest $request, Animal $animal)
    {
        $this->authorize('update', $animal);
        $this->animalService->update($animal, $request->validated());

        return redirect()->route('animals.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Animal $animal)
    {
        $this->authorize('delete', $animal);
        try {
            $this->animalService->delete($animal);

            return redirect()->route('animals.index')
                ->with('success', __('messages.deleted_successfully'));
        } catch (\RuntimeException $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function toggleStatus(Animal $animal)
    {
        $this->authorize('update', $animal);
        $animal = $this->animalService->cycleStatus($animal);

        return redirect()->route('animals.index')
            ->with('success', __('animals.status_updated', ['status' => __('animals.status.'.$animal->status)]));
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ])['ids'];

        $templateId = $this->getTemplateId();
        $animals = Animal::forTemplate($templateId)
            ->forUser(effective_user_id())
            ->whereIn('id', $ids)
            ->get();

        [$deleted, $skipped] = $this->animalService->bulkDelete($animals);

        return redirect()->route('animals.index')
            ->with('success', __('messages.bulk_deleted', ['count' => format_amount($deleted, 0)]))
            ->with('warning', $skipped > 0 ? __('messages.bulk_skipped', ['count' => format_amount($skipped, 0)]) : null);
    }
}
