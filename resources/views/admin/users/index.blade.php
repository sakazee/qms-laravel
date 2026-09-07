@extends('layouts.app')
@section('title', __('admin.users'))
@section('page-title', __('admin.users'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('admin.users') }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-user-shield text-sky-700"></i>{{ __('admin.users') }}</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i> {{ __('admin.add_user') }}
        </a>
    </div>
    <div class="table-wrap">
        <table class="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('admin.user_name') }}</th>
                    <th>{{ __('admin.user_email') }}</th>
                    <th>{{ __('admin.user_phone') }}</th>
                    <th>{{ __('admin.user_role') }}</th>
                    <th>{{ __('admin.user_templates') }}</th>
                    <th>{{ __('admin.user_animals') }}</th>
                    <th>{{ __('admin.user_partners') }}</th>
                    <th>{{ __('admin.user_expenses') }}</th>
                    <th>{{ __('admin.user_payments') }}</th>
                    <th>{{ __('admin.user_status') }}</th>
                    <th>{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $i => $user)
                <tr class="{{ $user->trashed() ? 'opacity-60' : '' }}">
                    <td>{{ format_amount($i + 1, 0) }}</td>
                    <td>
                        <div class="font-semibold text-gray-900">{{ $user->name }}</div>
                        @if($user->id === auth()->id())
                            <span class="badge mt-1 bg-sky-100 text-sky-800">{{ __('admin.you') }}</span>
                        @endif
                    </td>
                    <td class="text-gray-600">{{ $user->email }}</td>
                    <td class="text-gray-600">{{ $user->phone ?: '—' }}</td>
                    <td>
                        <span class="badge {{ $user->isAdmin()
                            ? 'bg-pine-100 text-pine-800'
                            : 'bg-gray-100 text-gray-600' }}">
                            {{ $user->isAdmin() ? __('admin.role_admin') : __('admin.role_user') }}
                        </span>
                    </td>
                    <td class="text-center font-semibold">{{ format_amount($user->templates_count, 0) }}</td>
                    <td class="text-center">{{ format_amount($user->animals_count, 0) }}</td>
                    <td class="text-center">{{ format_amount($user->partners_count, 0) }}</td>
                    <td class="text-center">{{ format_amount($user->expenses_count, 0) }}</td>
                    <td class="text-center">{{ format_amount($user->payments_count, 0) }}</td>
                    <td>
                        @if($user->trashed())
                        <span class="badge bg-rose-100 text-rose-800">{{ __('admin.user_deleted_badge') }}</span>
                        @else
                        <span class="badge bg-emerald-100 text-emerald-800">{{ __('admin.user_active') }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            @unless($user->trashed())
                            <form action="{{ route('admin.users.manage', $user) }}" method="POST" class="m-0" title="{{ __('admin.manage_data') }}">
                                @csrf
                                <button type="submit" class="action-btn bg-pine-100 text-pine-800 hover:bg-pine-200">
                                    <i class="fa-solid fa-database"></i>
                                </button>
                            </form>
                            <form action="{{ route('admin.impersonate', $user) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="action-btn bg-sky-100 text-sky-800 hover:bg-sky-200"
                                        title="{{ __('admin.login_as') }}">
                                    <i class="fa-solid fa-user-secret"></i>
                                </button>
                            </form>
                            @if($user->id !== auth()->id())
                            <a href="{{ route('admin.users.edit', $user) }}" class="action-btn action-edit" title="{{ __('messages.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="form-delete m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="{{ __('messages.delete') }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @endif
                            @else
                            <form action="{{ route('admin.users.restore', $user) }}" method="POST" class="m-0">
                                @csrf
                                <button type="submit" class="action-btn bg-amber-100 text-amber-800 hover:bg-amber-200" title="{{ __('admin.restore') }}">
                                    <i class="fa-solid fa-rotate-left"></i>
                                </button>
                            </form>
                            @endunless
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="12">
                        <div class="empty-state">
                            <i class="fa-solid fa-user-slash text-3xl text-gray-300"></i>
                            <span class="text-[13.5px]">{{ __('messages.no_data_found') }}</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection