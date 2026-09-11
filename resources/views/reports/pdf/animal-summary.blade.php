<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    @font-face { font-family: SolaimanLipi; src: url('{{ public_path("fonts/bengali/SolaimanLipi.ttf") }}'); }
    @font-face { font-family: ShonarBangla; src: url('{{ public_path("fonts/bengali/ShonarBangla-N.ttf") }}'); }

    body { font-family: SolaimanLipi, ShonarBangla, sans-serif; font-size: 12px; color: #1a1a1a; }
    h1 { font-size: 18px; color: #1a6b3a; text-align: center; margin-bottom: 4px; }
    .subtitle { text-align: center; color: #666; font-size: 11px; margin-bottom: 20px; }
    table { width: 100%; border-collapse: collapse; margin-bottom: 16px; }
    th { background: #1a6b3a; color: #fff; padding: 7px 10px; text-align: left; font-size: 11px; }
    td { padding: 6px 10px; border-bottom: 1px solid #eee; }
    tr:nth-child(even) td { background: #f9faf9; }
    .tfoot td { background: #e8f5e9; font-weight: bold; }
    .stats { width: 100%; margin-bottom: 20px; }
    .stat-box { display: inline-block; width: 22%; margin: 1%; padding: 10px; background: #f0f4f1; border-radius: 6px; text-align: center; }
    .stat-val { font-size: 16px; font-weight: bold; color: #1a6b3a; }
    .stat-lbl { font-size: 10px; color: #666; }
    .badge-success { color: #1a6b3a; }
    .badge-danger { color: #c0392b; }
</style>
</head>
<body>
<h1>{{ __('messages.app_name') }}</h1>
<div class="subtitle">{{ $title }} — {{ $template->name }} ({{ $template->year }}) — {{ bd_date(now()->format('d M Y')) }}</div>

<table>
    <tr>
        <th width="40%">{{ app()->getLocale() === 'bn' ? 'বিবরণ' : 'Description' }}</th>
        <th>{{ app()->getLocale() === 'bn' ? 'মান' : 'Value' }}</th>
    </tr>
    <tr><td>{{ __('reports.total_animals') }}</td><td>{{ format_count($stats['total_animals'],__('reports.animal_count_prefix')) }}</td></tr>
    <tr><td>{{ __('reports.total_partners') }}</td><td>{{ format_count($stats['total_partners'],__('reports.partners_count_prefix')) }}</td></tr>
    <tr><td>{{ __('reports.total_animal_cost') }}</td><td>৳{{ format_amount($stats['total_animal_cost'],0) }}</td></tr>
    <tr><td>{{ __('reports.total_expenses') }}</td><td>৳{{ format_amount($stats['total_expenses'],0) }}</td></tr>
    <tr><td>{{ __('reports.total_cost') }}</td><td>৳{{ format_amount($stats['total_cost'],0) }}</td></tr>
    <tr><td>{{ __('reports.total_collection') }}</td><td>৳{{ format_amount($stats['total_collection'],0) }}</td></tr>
    <tr><td>{{ __('reports.due') }}</td><td class="{{ $stats['due']>0?'badge-danger':'' }}">৳{{ format_amount($stats['due'],0) }}</td></tr>
    <tr><td>{{ __('reports.advance') }}</td><td class="badge-success">৳{{ format_amount($stats['advance'],0) }}</td></tr>
</table>

<h3 style="color:#1a6b3a">{{ __('animals.animals') }}</h3>
<table>
    <thead>
        <tr><th>#</th><th>{{ __('animals.type.label') }}</th><th>{{ __('animals.name') }}</th><th>{{ __('animals.purchase_price') }}</th><th>{{ __('expenses.expenses') }}</th><th>{{ __('animals.total_shares') }}</th><th>{{ app()->getLocale() === 'bn' ? 'অংশীদারগণ' : 'Partners' }}</th><th>{{ __('animals.status.label') }}</th></tr>
    </thead>
    <tbody>
        @foreach($template->animals as $i => $a)
        @php
            $partnerShares = $a->animalShares->map(fn ($s) => trim($s->partner->name) . ' (' . format_amount($s->shares, 0) . ')')->implode(', ');
        @endphp
        <tr><td>{{ format_amount($i+1, 0) }}</td><td>{{ $a->type_name }}</td><td>{{ $a->name ?: '—' }}</td><td>৳{{ format_amount($a->purchase_price,0) }}</td><td>৳{{ format_amount($animal_expenses[$a->id] ?? 0,0) }}</td><td>{{ format_amount($a->total_shares,0) }}</td><td>{{ $partnerShares ?: '—' }}</td><td>{{ __('animals.status.'.$a->status) }}</td></tr>
        @endforeach
    </tbody>
    <tfoot><tr class="tfoot"><td colspan="3">{{ __('messages.total') }}</td><td>৳{{ format_amount($template->animals->sum('purchase_price'),0) }}</td><td>৳{{ format_amount($animal_expenses->sum(),0) }}</td><td>{{ format_amount($template->animals->sum('total_shares'),0) }}</td><td colspan="2"></td></tr></tfoot>
</table>
</body>
</html>
