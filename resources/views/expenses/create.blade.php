@extends('layouts.app')
@section('title', __('expenses.create'))
@section('page-title', __('expenses.create'))
@section('breadcrumb')
    <span><a href="{{ route('expenses.index') }}" class="hover:text-emerald-700">{{ __('expenses.expenses') }}</a></span>
    <i class="fa-solid fa-chevron-right text-[10px] text-gray-400"></i>
    <span class="text-gray-600">{{ __('expenses.create') }}</span>
@endsection

@section('content')
<div class="mx-auto max-w-5xl">
    <div class="card">
        <div class="card-header bg-emerald-800">
            <h3 class="card-title text-white"><i class="fa-solid fa-file-invoice-dollar"></i>{{ __('expenses.create') }}</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('expenses.store') }}" method="POST" id="expense_form">
                @csrf
                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label class="label">{{ __('expenses.title') }} <span class="text-rose-600">*</span></label>
                        <input type="text" name="title" value="{{ old('title') }}"
                               class="input @error('title') border-rose-400 @enderror" required>
                        @error('title')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="lg:col-span-1">
                        <label class="label">{{ __('expenses.amount') }} <span class="text-rose-600">*</span></label>
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[13.5px] font-medium text-gray-500">৳</span>
                            <input type="number" name="amount" id="total_amount" value="{{ old('amount') }}"
                                   class="input pl-8 @error('amount') border-rose-400 @enderror"
                                   min="0.01" step="0.01" required>
                        </div>
                        @error('amount')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="lg:col-span-1">
                        <label class="label">{{ __('expenses.distribution_type') }} <span class="text-rose-600">*</span></label>
                        <select name="distribution_type" id="dist_type"
                                class="input @error('distribution_type') border-rose-400 @enderror" required>
                            <option value="flat" {{ old('distribution_type') === 'flat' ? 'selected' : '' }}>{{ __('expenses.dist.flat') }}</option>
                            <option value="custom_percent" {{ old('distribution_type') === 'custom_percent' ? 'selected' : '' }}>{{ __('expenses.dist.custom_percent') }}</option>
                            <option value="purchase_percent" {{ old('distribution_type') === 'purchase_percent' ? 'selected' : '' }}>{{ __('expenses.dist.purchase_percent') }}</option>
                        </select>
                        @error('distribution_type')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="lg:col-span-1">
                        <label class="label">{{ __('expenses.expense_date') }} <span class="text-rose-600">*</span></label>
                        <input type="date" name="expense_date" value="{{ old('expense_date', date('Y-m-d')) }}"
                               class="input @error('expense_date') border-rose-400 @enderror" required>
                        @error('expense_date')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-5">
                    <label class="label">{{ __('messages.description') }}</label>
                    <textarea name="description" rows="2" class="input resize-none">{{ old('description') }}</textarea>
                </div>

                {{-- Distribution Table (shown only for custom_percent) --}}
                <div id="custom_dist_section" class="d-none mt-6">
                    <div class="mt-6 rounded-xl border border-gray-200">
                        <div class="flex items-center justify-between rounded-t-xl border-b border-gray-100 px-5 py-4">
                            <h5 class="flex items-center gap-2 font-serif text-[15px] font-semibold text-amber-700">
                                <i class="fa-solid fa-table"></i>{{ __('expenses.distributions') }}
                            </h5>
                            <span id="percent_status" class="badge bg-gray-100 text-gray-600">0% / 100%</span>
                        </div>
                        <div class="table-wrap">
                            <table class="w-full text-[13px]" id="dist_table">
                                <thead>
                                    <tr class="border-b border-gray-200 bg-paper-100 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">
                                        <th class="px-4 py-3">{{ __('expenses.animal') }}</th>
                                        <th class="px-4 py-3">{{ __('animals.purchase_price') }}</th>
                                        <th class="px-4 py-3" style="width:180px">{{ __('expenses.percentage') }}</th>
                                        <th class="px-4 py-3" style="width:180px">{{ __('expenses.calculated_amount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($animals as $animal)
                                    <tr class="border-b border-gray-100">
                                        <td class="px-4 py-3 font-medium text-gray-900">{{ $animal->type_name }} {{ $animal->name ? '— '.$animal->name : '' }}</td>
                                        <td class="px-4 py-3">৳{{ format_amount($animal->purchase_price, 0) }}</td>
                                        <td class="px-4 py-3">
                                            <div class="flex items-center">
                                                <input type="number" name="distributions[{{ $animal->id }}]"
                                                       class="input !rounded-r-none !py-1.5 dist-percent"
                                                       data-price="{{ $animal->purchase_price }}"
                                                       min="0" max="100" step="0.01"
                                                       value="{{ old('distributions.' . $animal->id, 0) }}">
                                                <span class="inline-flex items-center rounded-r-lg border border-l-0 border-gray-300 bg-gray-50 px-3 text-[12.5px] font-medium text-gray-600">%</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="relative">
                                                <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-[13px] font-medium text-gray-500">৳</span>
                                                <input type="text" class="input !py-1.5 pl-7 dist-amount" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-emerald-50/50 font-bold text-gray-900">
                                        <td class="px-4 py-3" colspan="2">{{ __('messages.total') }}</td>
                                        <td class="px-4 py-3"><span id="total_percent" class="text-rose-600">0%</span></td>
                                        <td class="px-4 py-3"><span id="total_dist_amount">৳0</span></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Info for other types --}}
                <div id="auto_dist_info" class="alert alert-info mt-6">
                    <i class="fa-solid fa-circle-info"></i>
                    <span id="auto_dist_text"></span>
                </div>

                <div class="mt-6 flex items-center justify-between">
                    <a href="{{ route('expenses.index') }}" class="btn btn-secondary">
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

@push('scripts')
<script>
const locale = '{{ app()->getLocale() }}';
const autoText = {
    flat: locale === 'bn' ? 'সমান ভাগ: সকল পশুর মধ্যে সমানভাবে বিতরণ হবে।' : 'Equal Split: Amount will be divided equally among all animals.',
    custom_percent: locale === 'bn' ? 'কাস্টম %: নিচের টেবিলে প্রতিটি পশুর শতাংশ নির্ধারণ করুন (মোট ১০০% হতে হবে)।' : 'Custom %: Enter percentage for each animal below (must total 100%).',
    purchase_percent: locale === 'bn' ? 'ক্রয়মূল্য অনুযায়ী: ক্রয়মূল্যের অনুপাতে স্বয়ংক্রিয়ভাবে বিতরণ হবে।' : 'By Purchase Price: Automatically distributed proportional to each animal\'s purchase price.',
};

function updateDistSection() {
    const type = $('#dist_type').val();
    if (type === 'custom_percent') {
        $('#custom_dist_section').removeClass('d-none');
        $('#auto_dist_info').addClass('d-none');
        calcDist();
    } else {
        $('#custom_dist_section').addClass('d-none');
        $('#auto_dist_info').removeClass('d-none');
        $('#auto_dist_text').text(autoText[type] || '');
    }
}

function calcDist() {
    const total = parseFloat($('#total_amount').val()) || 0;
    let totalPct = 0, totalAmt = 0;
    $('.dist-percent').each(function() {
        const pct = parseFloat($(this).val()) || 0;
        const amt = (total * pct / 100);
        totalPct += pct;
        totalAmt += amt;
        $(this).closest('tr').find('.dist-amount').val(amt.toFixed(2));
    });
    $('#total_percent').text(window.qmsFmt(totalPct.toFixed(2) + '%'))
        .removeClass('text-danger text-success')
        .addClass(Math.abs(totalPct - 100) < 0.01 ? 'text-success' : 'text-danger');
    $('#total_dist_amount').text(window.qmsFmt('৳' + totalAmt.toFixed(2)));
    const remaining = (100 - totalPct).toFixed(2);
    $('#percent_status').text(window.qmsFmt(totalPct.toFixed(2) + '% / 100%'))
        .removeClass('badge-secondary badge-success badge-danger')
        .addClass(Math.abs(totalPct - 100) < 0.01 ? 'badge-success' : 'badge-danger');
}

$('#dist_type').on('change', updateDistSection);
$('#total_amount').on('input', calcDist);
$(document).on('input', '.dist-percent', calcDist);
updateDistSection();
</script>
@endpush