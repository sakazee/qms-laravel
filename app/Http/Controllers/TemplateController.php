<?php

namespace App\Http\Controllers;

use App\Http\Requests\Template\StoreTemplateRequest;
use App\Http\Requests\Template\UpdateTemplateRequest;
use App\Models\Template;
use App\Services\TemplateService;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function __construct(private readonly TemplateService $templateService) {}

    public function index()
    {
        $templates = $this->templateService->getAllForUser(effective_user_id());

        return view('templates.index', compact('templates'));
    }

    public function create()
    {
        return view('templates.create');
    }

    public function store(StoreTemplateRequest $request)
    {
        $this->templateService->create($request->validated(), effective_user_id());

        return redirect()->route('templates.index')
            ->with('success', __('messages.created_successfully'));
    }

    public function edit(Template $template)
    {
        $this->authorize('update', $template);

        return view('templates.edit', compact('template'));
    }

    public function update(UpdateTemplateRequest $request, Template $template)
    {
        $this->authorize('update', $template);
        $this->templateService->update($template, $request->validated());

        return redirect()->route('templates.index')
            ->with('success', __('messages.updated_successfully'));
    }

    public function destroy(Template $template)
    {
        $this->authorize('delete', $template);
        $this->templateService->delete($template);

        return redirect()->route('templates.index')
            ->with('success', __('messages.deleted_successfully'));
    }

    public function select(Request $request, Template $template)
    {
        $this->authorize('view', $template);
        session(['selected_template_id' => $template->id]);

        return redirect()->route('dashboard')->with('success', __('templates.selected', ['name' => $template->name]));
    }

    public function deselect()
    {
        session()->forget('selected_template_id');

        return redirect()->route('dashboard')->with('success', __('templates.deselected'));
    }
}
