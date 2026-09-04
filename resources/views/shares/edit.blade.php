@extends('layouts.app')
@section('title', __('shares.edit'))
@section('page-title', __('shares.edit'))
@section('breadcrumb')
    <span><a href="{{ route('shares.index') }}" class="hover:text-emerald-700">{{ __('shares.shares') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('shares.edit') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-3xl">
    <div class="card">
        <div class="card-header bg-sky-700">
            <h3 class="card-title text-white"><i class="fa-solid fa-pen"></i>{{ __('shares.edit') }}</h3>
        </div>
        <div class="card-body">
            <div class="mb-5 flex flex-wrap gap-x-8 gap-y-1 rounded-lg bg-gray-50 px-4 py-3 text-[13.5px]">
                <span><strong class="font-semibold text-gray-700">{{ __('animals.animal') }}:</strong> {{ $share->animal->type_name }} {{ $share->animal->name ? '— ' . $share->animal->name : '' }}</span>
                <span><strong class="font-semibold text-gray-700">{{ __('partners.partner') }}:</strong> {{ $share->partner->name }}</span>
            </div>

            <form action="{{ route('shares.update', $share) }}" method="POST">
                @csrf @method('PUT')
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <div>
                        <label class="label">{{ __('shares.shares_count') }} <span class="text-rose-600">*</span></label>
                        <input type="number" name="shares" value="{{ old('shares', $share->shares) }}"
                               class="input @error('shares') border-rose-400 @enderror"
                               min="1" max="{{ $share->animal->max_shares }}"
                               {{ !$share->animal->is_large ? 'readonly' : '' }} required>
                        @error('shares')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="label">{{ __('shares.share_amount') }}</label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[13.5px] font-medium text-gray-500">৳</span>
                            <input type="text" class="input pl-8" value="{{ number_format($share->share_amount, 2) }}" readonly>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <label class="label">{{ __('messages.notes') }}</label>
                    <textarea name="notes" rows="2" class="input resize-none">{{ old('notes', $share->notes) }}</textarea>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('shares.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i>{{ __('messages.back') }}
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save"></i>{{ __('messages.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection