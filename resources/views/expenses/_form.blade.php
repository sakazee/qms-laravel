@php
$expense ??= null;
$existingDist = $expense?->distributions?->keyBy('animal_id');
$checkedAnimals = old('animal_ids');
if ($checkedAnimals === null) {
    $checkedAnimals = ($expense && $existingDist->isNotEmpty())
        ? $existingDist->keys()->toArray()
        : $animals->pluck('id')->all();
}
$checkedAnimals = array_map('intval', (array) $checkedAnimals);
@endphp

<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
    <div class="sm:col-span-2">
        <label class="label">{{ __('expenses.expense_head') }} <span class="text-rose-600">*</span></label>
        <select name="expense_head_id" class="input select2 @error('expense_head_id') border-rose-400 @enderror" required>
            <option value="">-- {{ app()->getLocale() === 'bn' ? 'খরচের খাত নির্বাচন করুন' : 'Select Expense Head' }} --</option>
            @foreach($expenseHeads as $head)
            <option value="{{ $head->id }}" {{ old('expense_head_id', $expense?->expense_head_id) == $head->id ? 'selected' : '' }}>{{ $head->name }}</option>
            @endforeach
        </select>
        @error('expense_head_id')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="sm:col-span-2">
        <label class="label">{{ __('expenses.title') }} <span class="text-rose-600">*</span></label>
        <input type="text" name="title" value="{{ old('title', $expense?->title) }}"
               class="input @error('title') border-rose-400 @enderror" required>
        @error('title')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-1">
        <label class="label">{{ __('expenses.amount') }} <span class="text-rose-600">*</span></label>
        <div class="relative">
            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5 text-[13.5px] font-medium text-gray-500">৳</span>
            <input type="number" name="amount" id="total_amount" value="{{ old('amount', $expense?->amount) }}"
                   class="input pl-8 @error('amount') border-rose-400 @enderror"
                   min="0.01" step="0.01" required>
        </div>
        @error('amount')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>

    <div class="lg:col-span-1">
        <label class="label">{{ __('expenses.expense_date') }} <span class="text-rose-600">*</span></label>
        <input type="date" name="expense_date" value="{{ old('expense_date', $expense?->expense_date?->format('Y-m-d') ?? date('Y-m-d')) }}"
               class="input @error('expense_date') border-rose-400 @enderror" required>
        @error('expense_date')<p class="mt-1 text-[12px] font-medium text-rose-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-5">
    <label class="label">{{ __('messages.description') }}</label>
    <textarea name="description" rows="2" class="input resize-none">{{ old('description', $expense?->description) }}</textarea>
</div>

{{-- Distribution --}}
<input type="hidden" name="split_type" id="split_type" value="{{ old('split_type', $expense?->split_type ?? 'manual') }}">
<div id="distribution_section" class="d-none mt-6 rounded-xl border border-gray-200">
    <div class="flex items-center justify-between rounded-t-xl border-b border-gray-100 px-5 py-4">
        <h5 class="flex items-center gap-2 font-serif text-[15px] font-semibold text-amber-700">
            <i class="fa-solid fa-table"></i>{{ __('expenses.distributions') }}
        </h5>
        <span id="allocation_status" class="badge bg-gray-100 text-gray-600">
            <span id="allocated_val">৳0</span> / <span id="allocated_total">৳0</span>
            <span class="ml-2 opacity-80">({{ __('expenses.remaining') }}: <span id="remaining_val">৳0</span>)</span>
        </span>
    </div>

    <div class="border-b border-gray-100 px-5 py-4">
        <label class="label">{{ __('expenses.select_animals') }}</label>
        <div id="animal_picker" class="rounded-xl border border-gray-200 bg-white">
            <label class="flex cursor-pointer items-center gap-2.5 border-b border-gray-100 px-4 py-2.5 select-none hover:bg-emerald-50/60">
                <input type="checkbox" id="animal_select_all" class="h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                <span class="text-[13px] font-semibold text-gray-800 ml-2">{{ __('expenses.select_all_animals') }}</span>
                <span id="animal_picker_count" class="ml-auto text-[12px] font-semibold text-emerald-700"></span>
            </label>
            <div class="max-h-48 overflow-y-auto py-1">
                @foreach($animals as $animal)
                <label class="flex cursor-pointer items-center gap-2.5 px-4 py-1.5 select-none hover:bg-emerald-50/60">
                    <input type="checkbox" name="animal_ids[]" value="{{ $animal->id }}" class="animal-check h-4 w-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500"
                           {{ in_array($animal->id, $checkedAnimals, true) ? 'checked' : '' }}>
                    <span class="text-[13px] text-gray-700 ml-2">{{ $animal->type_name }}{{ $animal->name ? ' — '.$animal->name : '' }} (৳{{ format_amount($animal->purchase_price, 0) }})</span>
                </label>
                @endforeach
            </div>
        </div>
        <p class="mt-1.5 text-[12px] text-gray-500"><i class="fa-solid fa-circle-info mr-1"></i>{{ __('expenses.all_animals_hint') }}</p>

        <div class="mt-3 flex flex-wrap items-center gap-2">
            <button type="button" id="btn_equal" class="btn btn-sm btn-split" aria-pressed="false">
                <i class="fa-solid fa-equals"></i>{{ __('expenses.split_equal') }}
            </button>
            <button type="button" id="btn_purchase" class="btn btn-sm btn-split" aria-pressed="false">
                <i class="fa-solid fa-percent"></i>{{ __('expenses.split_purchase') }}
            </button>
            <button type="button" id="btn_manual" class="btn btn-sm btn-split" aria-pressed="false">
                <i class="fa-solid fa-pen"></i>{{ __('expenses.split_manual') }}
            </button>
        </div>
    </div>

    <div class="table-wrap">
        <table class="w-full text-[13px]" id="dist_table">
            <thead>
                <tr class="border-b border-gray-200 bg-paper-100 text-left text-[12px] font-bold uppercase tracking-wide text-gray-600">
                    <th class="px-4 py-3">#</th>
                    <th class="px-4 py-3">{{ __('expenses.animal') }}</th>
                    <th class="px-4 py-3">{{ __('animals.purchase_price') }}</th>
                    <th class="px-4 py-3" style="width:170px">{{ __('expenses.percentage') }}</th>
                    <th class="px-4 py-3" style="width:170px">{{ __('expenses.fixed_amount') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($animals as $i => $animal)
                @php $d = $existingDist?->get($animal->id); @endphp
                <tr class="dist-row border-b border-gray-100" data-id="{{ $animal->id }}" data-price="{{ $animal->purchase_price }}">
                    <td class="px-4 py-3 text-gray-500">{{ format_amount($i + 1, 0) }}</td>
                    <td class="px-4 py-3 font-medium text-gray-900">{{ $animal->type_name }}{{ $animal->name ? ' — '.$animal->name : '' }}</td>
                    <td class="px-4 py-3">৳{{ format_amount($animal->purchase_price, 0) }}</td>
                    <td class="px-4 py-3">
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-end pr-1.5 text-[12.5px] font-medium text-gray-500">%</span>
                            <input type="number" name="distributions[{{ $animal->id }}][percent]"
                                   class="input !py-1.5 pl-9 dist-percent" placeholder="—"
                                   min="0" step="0.01"
                                   value="{{ old('distributions.'.$animal->id.'.percent', $d?->percentage) }}">
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="relative">
                            <span class="pointer-events-none absolute inset-y-0 left-0 flex w-9 items-center justify-end pr-1.5 text-[12.5px] font-medium text-gray-500">৳</span>
                            <input type="number" name="distributions[{{ $animal->id }}][amount]"
                                   class="input !py-1.5 pl-9 dist-amount" placeholder="—"
                                   min="0" step="0.01"
                                   value="{{ old('distributions.'.$animal->id.'.amount', $d?->amount) }}">
                        </div>
                    </td>
                </tr>
                @endforeach
                @if($animals->isEmpty())
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-[13px] text-gray-500">{{ __('messages.no_data_found') }}</td>
                </tr>
                @endif
            </tbody>
            <tfoot>
                <tr class="bg-emerald-50/50 font-bold text-gray-900">
                    <td class="px-4 py-3" colspan="3">{{ __('messages.total') }}</td>
                    <td class="px-4 py-3"><span id="total_percent">—</span></td>
                    <td class="px-4 py-3"><span id="allocated_val_foot">৳0</span></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

@push('scripts')
<script>
window.qmsOnReady(function ($) {
(function () {
    const locale = '{{ app()->getLocale() }}';
    const mismatchMsg = locale === 'bn'
        ? 'বরাদ্দকৃত পরিমাণের যোগফল খরচের পরিমাণের সমান নয়। বাকি টাকা আরেকটি পশুতে বরাদ্দ করুন বা % / নির্দিষ্ট পরিমাণ ঠিক করুন।'
        : 'Allocated amounts must add up to the expense total. Adjust the % or fixed amounts to cover the remaining amount.';

    function totalAmount() {
        return parseFloat($('#total_amount').val()) || 0;
    }

    function updateTotalFromAmounts() {
        if ($('#split_type').val() !== 'manual') return;
        const sum = visibleRows().get().reduce(function (s, tr) {
            return s + (parseFloat($(tr).find('.dist-amount').val()) || 0);
        }, 0);
        $('#total_amount').val(sum ? sum.toFixed(2) : '');
    }

    function updateVisibility() {
        const show = totalAmount() > 0;
        $('#distribution_section').toggleClass('d-none', !show);
        if (show) {
            showHideRows();
            recomputeTotals();
        }
    }

    function selectedIds() {
        return $('.animal-check:checked').map(function () {
            return $(this).val();
        }).get();
    }

    function syncSelectAll() {
        const $all = $('.animal-check');
        const checked = $all.filter(':checked');
        const $btn = $('#animal_select_all');
        $btn.prop('checked', checked.length > 0 && checked.length === $all.length);
        $btn.prop('indeterminate', checked.length > 0 && checked.length < $all.length);
        $('#animal_picker_count').text($all.length ? checked.length + '/' + $all.length : '');
    }

    function visibleRows() {
        const set = new Set(selectedIds().map(String));
        return $('.dist-row').filter(function () {
            return set.has(String($(this).data('id')));
        });
    }

    function showHideRows() {
        const set = new Set(selectedIds().map(String));
        $('.dist-row').each(function () {
            $(this).toggleClass('d-none', !set.has(String($(this).data('id'))));
        });
    }

    function rowSrc(tr) {
        const s = $(tr).data('src');
        if (s === 'percent' || s === 'amount') return s;
        const hasP = String($(tr).find('.dist-percent').val()).trim() !== '';
        const hasA = String($(tr).find('.dist-amount').val()).trim() !== '';
        return hasP ? 'percent' : (hasA ? 'amount' : null);
    }

    function recomputeTotals() {
        const total = totalAmount();
        const totalCents = Math.round(total * 100);
        if (visibleRows().length === 0) {
            $('#allocation_status').removeClass('badge-success badge-danger');
            $('#remaining_val').removeClass('text-emerald-600 text-rose-600');
            return true;
        }
        const pctRows = [], amtRows = [];

        visibleRows().each(function () {
            const src = rowSrc(this);
            if (src === 'percent') {
                pctRows.push({
                    tr: this,
                    pct: Math.round((parseFloat($(this).find('.dist-percent').val()) || 0) * 100) / 100,
                });
            } else if (src === 'amount') {
                amtRows.push({
                    tr: this,
                    amt: Math.round((parseFloat($(this).find('.dist-amount').val()) || 0) * 100) / 100,
                });
            }
        });

        const usedCents = amtRows.reduce((s, r) => s + Math.round(r.amt * 100), 0);
        let floorCents = 0;
        const defs = pctRows.map((r) => {
            const ideal = totalCents * r.pct / 100;
            const cents = Math.floor(ideal + 1e-9);
            const frac  = ideal - cents;
            floorCents += cents;
            return { tr: r.tr, cents, frac };
        });

        const n = pctRows.length;
        let remainder = totalCents - usedCents - floorCents;
        if (remainder > 0 && remainder < n) {
            defs.sort((a, b) => b.frac - a.frac);
            for (let i = 0; i < remainder; i++) defs[i].cents++;
        } else if (remainder < 0 && -remainder <= n) {
            defs.sort((a, b) => a.frac - b.frac);
            for (let i = 0; i < -remainder; i++) defs[i].cents--;
        } else if (remainder !== 0) {
            defs.forEach((d, i) => { d.cents = Math.round(totalCents * pctRows[i].pct / 100); });
        }
        defs.forEach((d) => { $(d.tr).find('.dist-amount').val((d.cents / 100).toFixed(2)); });

        amtRows.forEach((r) => {
            $(r.tr).find('.dist-amount').val(r.amt.toFixed(2));
            const pct = totalCents > 0 ? Math.min(Math.round(r.amt / total * 10000) / 100, 999.99) : 0;
            $(r.tr).find('.dist-percent').val(pct ? pct.toFixed(2) : null);
        });

        let allocated = 0, pctSum = 0;
        visibleRows().each(function () {
            allocated += parseFloat($(this).find('.dist-amount').val()) || 0;
            pctSum     += parseFloat($(this).find('.dist-percent').val()) || 0;
        });
        const remaining = total - allocated;
        const ok = Math.abs(remaining) < 0.01;
        const fmt = window.qmsFmt || ((s) => s);

        $('#allocated_val').text(fmt('৳' + allocated.toFixed(2)));
        $('#allocated_total').text(fmt('৳' + total.toFixed(2)));
        $('#remaining_val').text(fmt('৳' + remaining.toFixed(2)))
            .toggleClass('text-emerald-600', ok)
            .toggleClass('text-rose-600', !ok);
        $('#allocated_val_foot').text(fmt('৳' + allocated.toFixed(2)));
        $('#total_percent').text(fmt(pctSum.toFixed(2) + '%'));
        $('#allocation_status')
            .removeClass('badge-success badge-danger')
            .addClass(ok ? 'badge-success' : 'badge-danger');
        return ok;
    }

    function split(by) {
        const rows = visibleRows();
        const count = rows.length;
        if (count === 0) return;
        const total = totalAmount();
        const prices = [];
        rows.each(function () {
            prices.push(parseFloat($(this).data('price')) || 0);
            $(this).data('src', 'percent');
        });
        const sum = prices.reduce((a, b) => a + b, 0);
        const vendor = [];
        let units = 0;
        rows.each(function (i) {
            const raw = by === 'equal'
                ? 100 / count
                : (sum > 0 ? (prices[i] / sum) * 100 : 100 / count);
            const u = raw * 100;
            const floor = Math.floor(u + 1e-9);
            vendor.push({ el: this, floor, frac: u - floor });
            units += floor;
        });
        const left = 10000 - units;
        vendor.sort((a, b) => b.frac - a.frac);
        for (let i = 0; i < left; i++) vendor[i].floor++;
        rows.each(function (i) {
            const pct = vendor[i].floor / 100;
            $(this).find('.dist-percent').val(pct.toFixed(2));
            $(this).find('.dist-amount').val(null);
        });
        recomputeTotals();
    }

    $(document).on('input', '.dist-percent', function () {
        const tr = $(this).closest('.dist-row');
        tr.data('src', 'percent');
        clearSplit();
        recomputeTotals();
    });

    $(document).on('input', '.dist-amount', function () {
        const tr = $(this).closest('.dist-row');
        tr.data('src', 'amount');
        clearSplit();
        updateTotalFromAmounts();
        recomputeTotals();
    });

    $(document).on('change', '.animal-check', function () {
        syncSelectAll();
        showHideRows();
        updateTotalFromAmounts();
        recomputeTotals();
    });

    $('#animal_select_all').on('change', function () {
        const checkedTo = $(this).is(':checked');
        $('.animal-check').prop('checked', checkedTo);
        syncSelectAll();
        showHideRows();
        updateTotalFromAmounts();
        recomputeTotals();
    });
    $('#total_amount').on('input', updateVisibility);

    function activateSplit(btn, type) {
        $('#btn_equal, #btn_purchase, #btn_manual').removeClass('is-active').attr('aria-pressed', 'false');
        $(btn).addClass('is-active').attr('aria-pressed', 'true');
        $('#split_type').val(type);
    }

    function clearSplit() {
        $('#split_type').val('manual');
        $('#btn_equal, #btn_purchase, #btn_manual').removeClass('is-active').attr('aria-pressed', 'false');
    }

    $('#btn_equal').on('click', function () { activateSplit(this, 'equal'); split('equal'); });
    $('#btn_purchase').on('click', function () { activateSplit(this, 'purchase'); split('purchase'); });
    $('#btn_manual').on('click', function () {
        activateSplit(this, 'manual');
        visibleRows().each(function () {
            $(this).data('src', 'amount');
            $(this).find('.dist-percent').val('');
        });
        updateTotalFromAmounts();
        recomputeTotals();
    });

    $('#expense_form').on('submit', function (e) {
        if ($('.dist-row').length === 0 || selectedIds().length === 0) return true;
        visibleRows().each(function () {
            const src = rowSrc(this);
            if (src === 'percent') $(this).find('.dist-amount').val('');
            else if (src === 'amount') $(this).find('.dist-percent').val('');
        });
        if (!recomputeTotals() && $('#split_type').val() !== 'manual') {
            e.preventDefault();
            e.stopPropagation();
            alert(mismatchMsg);
        }
    });

    $(function () {
        const stored = $('#split_type').val();
        if (stored === 'equal' || stored === 'purchase' || stored === 'manual') {
            activateSplit(stored === 'equal' ? '#btn_equal' : stored === 'purchase' ? '#btn_purchase' : '#btn_manual', stored);
        }
        syncSelectAll();
        updateVisibility();
    });
})();
});
</script>
@endpush