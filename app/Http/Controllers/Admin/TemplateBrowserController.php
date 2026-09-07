<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;

class TemplateBrowserController extends Controller
{
    public function index()
    {
        $templates = Template::withTrashed()
            ->with(['user', 'animals'])
            ->latest()
            ->get();

        return view('admin.templates.index', compact('templates'));
    }

    public function select(Template $template)
    {
        session([
            'mode' => 'admin',
            'user_id' => $template->user_id,
            'impersonating' => true,
            'selected_template_id' => $template->id,
        ]);

        return redirect()->route('dashboard')
            ->with('success', __('admin.template_selected', ['name' => $template->name]));
    }

    public function restore(Template $template)
    {
        $template->restore();

        return redirect()->route('admin.templates.index')
            ->with('success', __('admin.template_restored', ['name' => $template->name]));
    }
}
