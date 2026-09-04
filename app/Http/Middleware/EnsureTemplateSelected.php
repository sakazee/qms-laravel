<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTemplateSelected
{
    // Routes that do NOT require a selected template
    protected array $except = [
        'dashboard',
        'templates.*',
        'language.*',
        'logout',
    ];

    public function handle(Request $request, Closure $next): Response
    {
        if (!session('selected_template_id')) {
            foreach ($this->except as $route) {
                if ($request->routeIs($route)) {
                    return $next($request);
                }
            }
            return redirect()->route('templates.index')
                             ->with('warning', __('messages.select_template_first'));
        }

        return $next($request);
    }
}
