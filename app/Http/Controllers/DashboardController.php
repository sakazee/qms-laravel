<?php

namespace App\Http\Controllers;

use App\Services\TemplateService;

class DashboardController extends Controller
{
    public function __construct(private readonly TemplateService $templateService) {}

    public function index()
    {
        $templateId = session('selected_template_id');
        $stats = [];

        if ($templateId) {
            try {
                $stats = $this->templateService->getDashboardStats($templateId, effective_user_id());
            } catch (\Exception $e) {
                session()->forget('selected_template_id');
            }
        }

        return view('dashboard.index', compact('stats'));
    }
}
