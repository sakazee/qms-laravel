<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Models\Partner;
use App\Models\Payment;
use App\Services\ReportService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(private readonly ReportService $reportService) {}

    private function getTemplateId(): int
    {
        $id = session('selected_template_id');
        if (! $id) {
            abort(403, __('messages.select_template_first'));
        }

        return $id;
    }

    private function partnerDueMap(int $templateId): array
    {
        $summary = $this->reportService->getPartnerDueSummary($templateId, effective_user_id());

        $map = [];
        foreach ($summary['partners'] as $row) {
            $map[$row['partner']->id] = max(0, round($row['balance'], 2));
        }

        return $map;
    }

    public function index()
    {
        $templateId = $this->getTemplateId();
        $payments = Payment::with('partner')
            ->forTemplate($templateId)
            ->where('user_id', effective_user_id())
            ->latest('payment_date')
            ->get();
        $partners = Partner::forTemplate($templateId)->forUser(effective_user_id())->get();

        return view('payments.index', compact('payments', 'partners'));
    }

    public function create()
    {
        $templateId = $this->getTemplateId();
        $partners = Partner::forTemplate($templateId)->forUser(effective_user_id())->get();
        $partnerDueMap = $this->partnerDueMap($templateId);

        return view('payments.create', compact('partners', 'partnerDueMap'));
    }

    public function store(StorePaymentRequest $request)
    {
        $templateId = $this->getTemplateId();
        Payment::create(array_merge($request->validated(), [
            'user_id' => effective_user_id(),
            'template_id' => $templateId,
        ]));

        return redirect()->route('payments.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function edit(Payment $payment)
    {
        $this->authorize('update', $payment);
        $templateId = $this->getTemplateId();
        $partners = Partner::forTemplate($templateId)->forUser(effective_user_id())->get();
        $partnerDueMap = $this->partnerDueMap($templateId);

        return view('payments.edit', compact('payment', 'partners', 'partnerDueMap'));
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $this->authorize('update', $payment);
        $payment->update($request->validated());

        return redirect()->route('payments.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Payment $payment)
    {
        $this->authorize('delete', $payment);
        $payment->delete();

        return redirect()->route('payments.index')
            ->with('success', __('messages.deleted_successfully'));
    }

    public function bulkDestroy(Request $request)
    {
        $ids = $request->validate([
            'ids' => ['required', 'array', 'min:1'],
            'ids.*' => ['integer'],
        ])['ids'];

        $templateId = $this->getTemplateId();
        $deleted = Payment::forTemplate($templateId)
            ->where('user_id', effective_user_id())
            ->whereIn('id', $ids)
            ->delete();

        return redirect()->route('payments.index')
            ->with('success', __('messages.bulk_deleted', ['count' => format_amount($deleted, 0)]));
    }
}
