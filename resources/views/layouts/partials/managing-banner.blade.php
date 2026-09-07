@if(auth()->check() && auth()->user()->isAdmin() && session('user_id') && (int) session('user_id') !== (int) auth()->id() && session('impersonating'))
@php
    $impersonatedUser = \App\Models\User::withTrashed()->find(session('user_id'));
@endphp
@if($impersonatedUser)
<div class="mb-5 flex flex-wrap items-center justify-between gap-3 rounded-xl border-2 border-amber-400 bg-amber-50 px-5 py-4 shadow-md">
    <div class="flex flex-wrap items-center gap-3">
        <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-amber-400 text-white">
            <i class="fa-solid fa-database"></i>
        </span>
        <div>
            <p class="text-[13px] font-bold uppercase tracking-wide text-amber-700">{{ __('admin.admin_mode') }}</p>
            <p class="text-[15px] font-bold text-amber-900">{{ __('admin.managing_user_data', ['name' => $impersonatedUser->name]) }}</p>
        </div>
    </div>
    <form action="{{ route('admin.impersonate.stop') }}" method="POST" class="m-0">
        @csrf
        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-amber-500 px-4 py-2 text-[13px] font-bold text-white shadow-sm transition-colors hover:bg-amber-600">
            <i class="fa-solid fa-arrow-left"></i> {{ __('admin.switch_back') }}
        </button>
    </form>
</div>
@endif
@endif