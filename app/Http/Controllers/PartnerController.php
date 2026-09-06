<?php

namespace App\Http\Controllers;

use App\Http\Requests\Partner\StorePartnerRequest;
use App\Http\Requests\Partner\UpdatePartnerRequest;
use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    private function getTemplateId(): int
    {
        $id = session('selected_template_id');
        if (!$id) abort(403, __('messages.select_template_first'));
        return $id;
    }

    public function index()
    {
        $templateId = $this->getTemplateId();
        $partners   = Partner::forTemplate($templateId)
                             ->forUser(auth()->id())
                             ->withCount('animalShares')
                             ->with('payments')
                             ->latest()
                             ->get();
        return view('partners.index', compact('partners'));
    }

    public function create()
    {
        $this->getTemplateId();
        return view('partners.create');
    }

    public function store(StorePartnerRequest $request)
    {
        $templateId = $this->getTemplateId();
        Partner::create(array_merge($request->validated(), [
            'user_id'     => auth()->id(),
            'template_id' => $templateId,
        ]));
        return redirect()->route('partners.index')
                         ->with('success', __('messages.created_successfully'));
    }

    public function show(Partner $partner)
    {
        $this->authorize('view', $partner);
        $partner->load('animalShares.animal', 'payments');
        return view('partners.show', compact('partner'));
    }

    public function edit(Partner $partner)
    {
        $this->authorize('update', $partner);
        return view('partners.edit', compact('partner'));
    }

    public function update(UpdatePartnerRequest $request, Partner $partner)
    {
        $this->authorize('update', $partner);
        $partner->update($request->validated());
        return redirect()->route('partners.index')
                         ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Partner $partner)
    {
        $this->authorize('delete', $partner);
        if ($partner->animalShares()->exists()) {
            return redirect()->back()->with('error', __('partners.cannot_delete_has_shares'));
        }
        $partner->delete();
        return redirect()->route('partners.index')
                         ->with('success', __('messages.deleted_successfully'));
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate([
            'ids'   => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ])['ids'];

        $templateId = $this->getTemplateId();
        $partners   = Partner::forTemplate($templateId)
                             ->forUser(auth()->id())
                             ->whereIn('id', $ids)
                             ->get();

        $deleted = 0;
        $skipped = 0;
        foreach ($partners as $partner) {
            if ($partner->animalShares()->exists()) {
                $skipped++;
                continue;
            }
            $partner->delete();
            $deleted++;
        }

        return redirect()->route('partners.index')
                         ->with('success', __('messages.bulk_deleted', ['count' => format_amount($deleted, 0)]))
                         ->with('warning', $skipped > 0 ? __('messages.bulk_skipped', ['count' => format_amount($skipped, 0)]) : null);
    }
}
