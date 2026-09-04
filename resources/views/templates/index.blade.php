@extends('layouts.app')
@section('title', __('templates.templates'))
@section('page-title', __('templates.templates'))
@section('breadcrumb')
    <li class="breadcrumb-item active">{{ __('templates.templates') }}</li>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="card-title mb-0">
                    <i class="fas fa-layer-group text-success mr-2"></i>{{ __('templates.templates') }}
                </h3>
                <a href="{{ route('templates.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus mr-1"></i> {{ __('templates.create') }}
                </a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover datatable mb-0">
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
                            <tr class="{{ session('selected_template_id') == $template->id ? 'table-success' : '' }}">
                                <td>{{ $i + 1 }}</td>
                                <td>
                                    <strong>{{ $template->name }}</strong>
                                    @if(session('selected_template_id') == $template->id)
                                        <span class="badge badge-success ml-2">
                                            <i class="fas fa-check mr-1"></i>{{ app()->getLocale() === 'bn' ? 'নির্বাচিত' : 'Selected' }}
                                        </span>
                                    @endif
                                    @if($template->description)
                                        <br><small class="text-muted">{{ Str::limit($template->description, 60) }}</small>
                                    @endif
                                </td>
                                <td>{{ $template->year }}</td>
                                <td>
                                    <span class="badge badge-{{ $template->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ $template->status === 'active' ? __('templates.active') : __('templates.inactive') }}
                                    </span>
                                </td>
                                <td>{{ $template->animals_count ?? $template->animals()->count() }}</td>
                                <td>{{ $template->partners_count ?? $template->partners()->count() }}</td>
                                <td>
                                    <div class="btn-group btn-group-sm">
                                        @if(session('selected_template_id') != $template->id)
                                        <a href="{{ route('templates.select', $template) }}"
                                           class="btn btn-success" title="{{ __('templates.select') }}">
                                            <i class="fas fa-check-circle"></i>
                                        </a>
                                        @endif
                                        <a href="{{ route('templates.edit', $template) }}" class="btn btn-info" title="{{ __('messages.edit') }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('templates.destroy', $template) }}" method="POST" class="form-delete d-inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="{{ __('messages.delete') }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">
                                    <i class="fas fa-layer-group fa-2x mb-2 d-block"></i>
                                    {{ __('messages.no_data_found') }}
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
