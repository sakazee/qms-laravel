<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Mail\NewUserMail;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::withTrashed()->withCount(['templates', 'partners'])->latest()->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $password = Str::random(12);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'locale' => $request->locale ?? 'bn',
            'role' => $request->role ?? User::ROLE_USER,
            'password' => $password,
        ]);

        try {
            Mail::to($user->email)
                ->locale($user->locale)
                ->send(new NewUserMail($user, $password));
        } catch (\Throwable $e) {
            report($e);
        }

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.user_created'));
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'locale' => $request->locale ?? $user->locale,
            'role' => $request->role ?? $user->role,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.user_updated'));
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', __('admin.cannot_delete_self'));
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.user_deleted'));
    }

    public function restore(User $user)
    {
        $user->restore();

        return redirect()->route('admin.users.index')
            ->with('success', __('admin.user_restored'));
    }
}
