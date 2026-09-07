<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class ImpersonateController extends Controller
{
    public function start(User $user)
    {
        abort_if($user->trashed(), 404);

        session()->forget('selected_template_id');
        session([
            'mode' => 'admin',
            'user_id' => $user->id,
            'impersonating' => true,
        ]);

        return redirect()->route('dashboard')
            ->with('success', __('admin.impersonating', ['name' => $user->name]));
    }

    public function stop()
    {
        session([
            'user_id' => auth()->id(),
        ]);
        session()->forget(['selected_template_id', 'impersonating']);

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.impersonation_stopped'));
    }
}
