<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnimalShare\StoreAnimalShareRequest;
use App\Http\Requests\AnimalShare\UpdateAnimalShareRequest;
use App\Models\Animal;
use App\Models\AnimalShare;
use App\Models\Partner;
use App\Services\AnimalShareService;

class AnimalShareController extends Controller
{
    public function __construct(private readonly AnimalShareService $shareService) {}

    private function getTemplateId(): int
    {
        $id = session('selected_template_id');
        if (!$id) abort(403, __('messages.select_template_first'));
        return $id;
    }

    public function index()
    {
        $templateId = $this->getTemplateId();
        $shares     = $this->shareService->getForTemplate($templateId, auth()->id());
        $animals    = Animal::forTemplate($templateId)->forUser(auth()->id())->get();
        $partners   = Partner::forTemplate($templateId)->forUser(auth()->id())->get();
        return view('shares.index', compact('shares', 'animals', 'partners'));
    }

    public function create()
    {
        $templateId = $this->getTemplateId();
        $animals    = Animal::forTemplate($templateId)->forUser(auth()->id())->get();
        $partners   = Partner::forTemplate($templateId)->forUser(auth()->id())->get();
        return view('shares.create', compact('animals', 'partners'));
    }

    public function store(StoreAnimalShareRequest $request)
    {
        $templateId = $this->getTemplateId();
        try {
            $this->shareService->assign($request->validated(), $templateId, auth()->id());
            return redirect()->route('shares.index')
                             ->with('success', __('messages.created_successfully'));
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function edit(AnimalShare $share)
    {
        $templateId = $this->getTemplateId();
        $share->load('animal', 'partner');
        $partners = Partner::forTemplate($templateId)->forUser(auth()->id())->get();
        return view('shares.edit', compact('share', 'partners'));
    }

    public function update(UpdateAnimalShareRequest $request, AnimalShare $share)
    {
        try {
            $this->shareService->update($share, $request->validated());
            return redirect()->route('shares.index')
                             ->with('success', __('messages.updated_successfully'));
        } catch (\RuntimeException $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function destroy(AnimalShare $share)
    {
        $this->shareService->delete($share);
        return redirect()->route('shares.index')
                         ->with('success', __('messages.deleted_successfully'));
    }

    // AJAX: Get animal share info
    public function getAnimalInfo(Animal $animal)
    {
        return response()->json([
            'type'             => $animal->type,
            'is_large'         => $animal->is_large,
            'total_shares'     => $animal->total_shares,
            'assigned_shares'  => $animal->assigned_shares,
            'available_shares' => $animal->available_shares,
            'share_price'      => $animal->share_price,
            'purchase_price'   => $animal->purchase_price,
        ]);
    }
}
