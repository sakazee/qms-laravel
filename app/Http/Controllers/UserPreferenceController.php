<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserPreferenceController extends Controller
{
    public function updateSidebarMode(Request $request)
    {
        $data = $request->validate([
            'mode' => ['required', Rule::in([
                User::SIDEBAR_EXPANDED,
                User::SIDEBAR_MINI,
                User::SIDEBAR_HIDDEN,
            ])],
        ]);

        auth()->user()?->update(['sidebar_mode' => $data['mode']]);

        return response()->json(['ok' => true]);
    }
}
