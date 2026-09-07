@if(auth()->check() && auth()->user()->isAdmin() && session('user_id') && (int) session('user_id') !== (int) auth()->id())
@php
    $impersonatedUser = \App\Models\User::withTrashed()->find(session('user_id'));
@endphp
@if($impersonatedUser)
<div class="flex flex-wrap items-center justify-center gap-2 border-b border-amber-200 bg-amber-50 px-4 py-2 text-[13.5px] font-semibold text-amber-900">
    <i class="fa-solid fa-user-secret"></i>
    <span>{{ __('admin.impersonating', ['name' => $impersonatedUser->name]) }}</span>
    <form action="{{ route('admin.impersonate.stop') }}" method="POST" class="m-0 inline">
        @csrf
        <button type="submit" class="rounded-full bg-amber-200 px-3 py-0.5 text-[13px] font-bold text-amber-900 transition-colors hover:bg-amber-300">
            <i class="fa-solid fa-arrow-left"></i> {{ __('admin.switch_back') }}
        </button>
    </form>
</div>
@endif
@endif