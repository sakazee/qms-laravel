<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ModeController extends Controller
{
    public function switchToAdmin()
    {
        abort_unless(auth()->user()->isAdmin(), 403);

        session()->forget('selected_template_id');
        session([
            'mode' => 'admin',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('dashboard')->with('success', __('admin.switched_to_admin'));
    }

    public function switchToUser()
    {
        session([
            'mode' => 'user',
            'user_id' => auth()->id(),
        ]);
        session()->forget(['selected_template_id', 'impersonating']);

        return redirect()->route('dashboard')->with('success', __('admin.switched_to_user'));
    }
}
