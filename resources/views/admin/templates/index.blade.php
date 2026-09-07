@extends('layouts.app')
@section('title', __('admin.all_templates'))
@section('page-title', __('admin.all_templates'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('admin.all_templates') }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-layer-group text-sky-700"></i>{{ __('admin.all_templates') }}</h3>
    </div>
    <div class="table-wrap">
        <table class="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('templates.name') }}</th>
                    <th>{{ __('admin.owner') }}</th>
                    <th>{{ __('templates.year') }}</th>
                    <th>{{ __('templates.status') }}</th>
                    <th>{{ app()->getLocale() === 'bn' ? 'পশু' : 'Animals' }}</th>
                    <th>{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $i => $template)
                <tr class="{{ session('selected_template_id') == $template->id ? 'bg-emerald-50/60' : '' }} {{ $template->user->trashed() ? 'opacity-60' : '' }}">
                    <td>{{ format_amount($i + 1, 0) }}</td>
                    <td>
                        <div class="font-semibold text-gray-900">{{ $template->name }}</div>
                        @if(session('selected_template_id') == $template->id)
                            <span class="badge mt-1 bg-emerald-100 text-emerald-800">
                                <i class="fa-solid fa-check text-[11px]"></i>{{ app()->getLocale() === 'bn' ? 'নির্বাচিত' : 'Selected' }}
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="text-gray-700">{{ $template->user->name }}</span>
                        @if($template->user->trashed())
                            <span class="badge ml-1 bg-rose-100 text-rose-800">{{ __('admin.user_deleted_badge') }}</span>
                        @endif
                    </td>
                    <td class="font-medium">{{ $template->year }}</td>
                    <td>
                        @if($template->trashed())
                        <span class="badge bg-rose-100 text-rose-800">
                            <i class="fa-solid fa-trash-can"></i> {{ __('admin.user_deleted_badge') }}
                        </span>
                        @else
                        <span class="badge {{ $template->status === 'active'
                            ? 'bg-emerald-100 text-emerald-800'
                            : 'bg-gray-100 text-gray-600' }}">
                            <i class="fa-solid fa-circle text-[6px]"></i>
                            {{ $template->status === 'active' ? __('templates.active') : __('templates.inactive') }}
                        </span>
                        @endif
                    </td>
                    <td class="text-center font-semibold">{{ format_amount($template->animals->count(), 0) }}</td>
                    <td>
                        @if($template->trashed())
                        <form action="{{ route('admin.templates.restore', $template) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="action-btn bg-amber-100 text-amber-800 hover:bg-amber-200" title="{{ __('admin.restore') }}">
                                <i class="fa-solid fa-rotate-left"></i>
                            </button>
                        </form>
                        @elseif(session('selected_template_id') !== $template->id)
                        <form action="{{ route('admin.templates.select', $template) }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="action-btn bg-emerald-100 text-emerald-800 hover:bg-emerald-200" title="{{ __('templates.select') }}">
                                <i class="fa-solid fa-check"></i>
                            </button>
                        </form>
                        @else
                        <span class="text-[14.5px] text-emerald-600">
                            <i class="fa-solid fa-check-circle"></i>
                        </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fa-solid fa-folder-open text-3xl text-gray-300"></i>
                            <span class="text-[14.5px]">{{ __('messages.no_data_found') }}</span>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection