@extends('layouts.app')
@section('title', __('templates.templates'))
@section('page-title', __('templates.templates'))
@section('breadcrumb')
    <span class="text-gray-600">{{ __('templates.templates') }}</span>
@endsection

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title"><i class="fa-solid fa-layer-group text-emerald-700"></i>{{ __('templates.templates') }}</h3>
        <a href="{{ route('templates.create') }}" class="btn btn-primary btn-sm">
            <i class="fa-solid fa-plus"></i> {{ __('templates.create') }}
        </a>
    </div>
    <div class="table-wrap">
        <table class="datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>{{ __('templates.name') }}</th>
                    <th>{{ __('templates.year') }}</th>
                    <th>{{ __('templates.status') }}</th>
                    <th>{{ app()->getLocale() === 'bn' ? 'পশু' : 'Animals' }}</th>
                    <th>{{ app()->getLocale() === 'bn' ? 'অংশীদার' : 'Partners' }}</th>
                    <th>{{ __('messages.action') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $i => $template)
                <tr class="{{ session('selected_template_id') == $template->id ? 'bg-emerald-50/60' : '' }}">
                    <td>{{ format_amount($i + 1, 0) }}</td>
                    <td>
                        <div class="font-semibold text-gray-900">{{ $template->name }}</div>
                        @if(session('selected_template_id') == $template->id)
                            <span class="badge mt-1 bg-emerald-100 text-emerald-800">
                                <i class="fa-solid fa-check text-[10px]"></i>{{ app()->getLocale() === 'bn' ? 'নির্বাচিত' : 'Selected' }}
                            </span>
                        @endif
                        @if($template->description)
                            <div class="mt-0.5 max-w-[220px] truncate text-[12px] text-gray-400">{{ Str::limit($template->description, 40) }}</div>
                        @endif
                    </td>
                    <td class="font-medium">{{ $template->year }}</td>
                    <td>
                        <span class="badge {{ $template->status === 'active'
                            ? 'bg-emerald-100 text-emerald-800'
                            : 'bg-gray-100 text-gray-600' }}">
                            <i class="fa-solid fa-circle text-[6px]"></i>
                            {{ $template->status === 'active' ? __('templates.active') : __('templates.inactive') }}
                        </span>
                    </td>
                    <td class="text-center font-semibold">{{ format_amount($template->animals_count ?? $template->animals()->count(), 0) }}</td>
                    <td class="text-center font-semibold">{{ format_amount($template->partners_count ?? $template->partners()->count(), 0) }}</td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            @if(session('selected_template_id') != $template->id)
                            <a href="{{ route('templates.select', $template) }}"
                               class="action-btn bg-emerald-100 text-emerald-800 hover:bg-emerald-200" title="{{ __('templates.select') }}">
                                <i class="fa-solid fa-check"></i>
                            </a>
                            @endif
                            <a href="{{ route('templates.edit', $template) }}" class="action-btn action-edit" title="{{ __('messages.edit') }}">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('templates.destroy', $template) }}" method="POST" class="form-delete m-0">
                                @csrf @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="{{ __('messages.delete') }}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <i class="fa-solid fa-layer-group text-3xl text-gray-300"></i>
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