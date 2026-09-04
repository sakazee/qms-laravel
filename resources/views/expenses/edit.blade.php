@extends('layouts.app')
@section('title', __('expenses.edit'))
@section('page-title', __('expenses.edit'))
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('expenses.index') }}">{{ __('expenses.expenses') }}</a></li>
    <li class="breadcrumb-item active">{{ __('expenses.edit') }}</li>
@endsection
@section('content')
<div class="row justify-content-center"><div class="col-md-10">
<div class="card">
    <div class="card-header bg-info text-white"><h3 class="card-title mb-0"><i class="fas fa-edit mr-2"></i>{{ __('expenses.edit') }}: {{ $expense->title }}</h3></div>
    <div class="card-body">
        <form action="{{ route('expenses.update', $expense) }}" method="POST">
            @csrf @method('PUT')
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>{{ __('expenses.title') }} <span class="text-danger">*</span></label>
                        <input type="text" name="title" value="{{ old('title', $expense->title) }}" class="form-control" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ __('expenses.amount') }} <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text">৳</span></div>
                            <input type="number" name="amount" id="total_amount" value="{{ old('amount', $expense->amount) }}" class="form-control" min="0.01" step="0.01" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>{{ __('expenses.distribution_type') }} <span class="text-danger">*</span></label>
                        <select name="distribution_type" id="dist_type" class="form-control" required>
                            <option value="flat" {{ old('distribution_type', $expense->distribution_type) === 'flat' ? 'selected' : '' }}>{{ __('expenses.dist.flat') }}</option>
                            <option value="custom_percent" {{ old('distribution_type', $expense->distribution_type) === 'custom_percent' ? 'selected' : '' }}>{{ __('expenses.dist.custom_percent') }}</option>
                            <option value="purchase_percent" {{ old('distribution_type', $expense->distribution_type) === 'purchase_percent' ? 'selected' : '' }}>{{ __('expenses.dist.purchase_percent') }}</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <label>{{ __('expenses.expense_date') }} <span class="text-danger">*</span></label>
                        <input type="date" name="expense_date" value="{{ old('expense_date', $expense->expense_date->format('Y-m-d')) }}" class="form-control" required>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label>{{ __('messages.description') }}</label>
                <textarea name="description" rows="2" class="form-control">{{ old('description', $expense->description) }}</textarea>
            </div>
            @php $existingDist = $expense->distributions->keyBy('animal_id'); @endphp
            <div id="custom_dist_section" class="d-none">
                <hr>
                <h5 class="font-weight-bold mb-3"><i class="fas fa-table mr-2 text-warning"></i>{{ __('expenses.distributions') }} <span id="percent_status" class="ml-3 badge badge-secondary">0% / 100%</span></h5>
                <div class="table-responsive">
                    <table class="table table-bordered" id="dist_table">
                        <thead class="thead-light"><tr><th>{{ __('expenses.animal') }}</th><th>{{ __('animals.purchase_price') }}</th><th>{{ __('expenses.percentage') }}</th><th>{{ __('expenses.calculated_amount') }}</th></tr></thead>
                        <tbody>
                            @foreach($animals as $animal)
                            @php $d = $existingDist->get($animal->id); @endphp
                            <tr>
                                <td>{{ $animal->type_name }} {{ $animal->name ? '— '.$animal->name : '' }}</td>
                                <td>৳{{ number_format($animal->purchase_price, 0) }}</td>
                                <td>
                                    <div class="input-group input-group-sm">
                                        <input type="number" name="distributions[{{ $animal->id }}]" class="form-control dist-percent" min="0" max="100" step="0.01" value="{{ old('distributions.'.$animal->id, $d?->percentage ?? 0) }}">
                                        <div class="input-group-append"><span class="input-group-text">%</span></div>
                                    </div>
                                </td>
                                <td><div class="input-group input-group-sm"><div class="input-group-prepend"><span class="input-group-text">৳</span></div><input type="text" class="form-control dist-amount" readonly></div></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot><tr class="font-weight-bold"><td colspan="2">{{ __('messages.total') }}</td><td><span id="total_percent" class="text-danger">0%</span></td><td><span id="total_dist_amount">৳0</span></td></tr></tfoot>
                    </table>
                </div>
            </div>
            <div id="auto_dist_info" class="alert alert-info"><i class="fas fa-info-circle mr-2"></i><span id="auto_dist_text"></span></div>
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('expenses.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left mr-1"></i>{{ __('messages.back') }}</a>
                <button type="submit" class="btn btn-info"><i class="fas fa-save mr-1"></i>{{ __('messages.save') }}</button>
            </div>
        </form>
    </div>
</div>
</div></div>
@endsection
@push('scripts')
<script>
const autoText = { flat: 'Equal split among all animals.', custom_percent: 'Set percentage per animal (must total 100%).', purchase_percent: 'Distributed by purchase price ratio.' };
function updateDistSection() {
    const type = $('#dist_type').val();
    if (type === 'custom_percent') { $('#custom_dist_section').removeClass('d-none'); $('#auto_dist_info').addClass('d-none'); calcDist(); }
    else { $('#custom_dist_section').addClass('d-none'); $('#auto_dist_info').removeClass('d-none'); $('#auto_dist_text').text(autoText[type] || ''); }
}
function calcDist() {
    const total = parseFloat($('#total_amount').val()) || 0; let tp = 0, ta = 0;
    $('.dist-percent').each(function() { const p = parseFloat($(this).val())||0; const a = total*p/100; tp+=p; ta+=a; $(this).closest('tr').find('.dist-amount').val(a.toFixed(2)); });
    $('#total_percent').text(tp.toFixed(2)+'%').removeClass('text-danger text-success').addClass(Math.abs(tp-100)<0.01?'text-success':'text-danger');
    $('#total_dist_amount').text('৳'+ta.toFixed(2));
    $('#percent_status').text(tp.toFixed(2)+'% / 100%').removeClass('badge-secondary badge-success badge-danger').addClass(Math.abs(tp-100)<0.01?'badge-success':'badge-danger');
}
$('#dist_type').on('change', updateDistSection);
$('#total_amount').on('input', calcDist);
$(document).on('input', '.dist-percent', calcDist);
updateDistSection();
</script>
@endpush
