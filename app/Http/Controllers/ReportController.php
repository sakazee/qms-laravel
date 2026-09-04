<?php

namespace App\Http\Controllers;

use App\Services\ReportService;

class ReportController extends Controller
{
    public function __construct(private readonly ReportService $reportService) {}

    private function getTemplateId(): int
    {
        $id = session('selected_template_id');
        if (!$id) abort(403, __('messages.select_template_first'));
        return $id;
    }

    public function templateSummary()
    {
        $templateId = $this->getTemplateId();
        $data       = $this->reportService->getTemplateSummary($templateId, auth()->id());
        return view('reports.template-summary', $data);
    }

    public function templateSummaryPdf()
    {
        $templateId = $this->getTemplateId();
        $data       = $this->reportService->getTemplateSummary($templateId, auth()->id());
        $data['title'] = __('reports.template_summary');
        return $this->reportService->generatePdf('reports.pdf.template-summary', $data, 'template-summary.pdf');
    }

    public function partnerSummary()
    {
        $templateId = $this->getTemplateId();
        $data       = $this->reportService->getPartnerSummary($templateId, auth()->id());
        return view('reports.partner-summary', $data);
    }

    public function partnerSummaryPdf()
    {
        $templateId = $this->getTemplateId();
        $data       = $this->reportService->getPartnerSummary($templateId, auth()->id());
        $data['title'] = __('reports.partner_summary');
        return $this->reportService->generatePdf('reports.pdf.partner-summary', $data, 'partner-summary.pdf');
    }

    public function animalSummary()
    {
        $templateId = $this->getTemplateId();
        $data       = $this->reportService->getTemplateSummary($templateId, auth()->id());
        return view('reports.animal-summary', $data);
    }

    public function animalSummaryPdf()
    {
        $templateId = $this->getTemplateId();
        $data       = $this->reportService->getTemplateSummary($templateId, auth()->id());
        $data['title'] = __('reports.animal_summary');
        return $this->reportService->generatePdf('reports.pdf.animal-summary', $data, 'animal-summary.pdf');
    }
}
