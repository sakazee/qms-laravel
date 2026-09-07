<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    @font-face { font-family: ShonarBangla; src: url('{{ public_path("fonts/bengali/ShonarBangla-N.ttf") }}'); }
    @font-face { font-family: ShonarBangla; src: url('{{ public_path("fonts/bengali/ShonarBangla-N.ttf") }}'); }

    body { font-family: SolaimanLipi, ShonarBangla, sans-serif; font-size: 12px; color: #1a1a1a; }
    h1 { font-size:18px; color:#1a6b3a; text-align:center; }
    .subtitle { text-align:center; color:#666; font-size:11px; margin-bottom:20px; }
    table { width:100%; border-collapse:collapse; }
    th { background:#1a6b3a; color:#fff; padding:7px 8px; font-size:11px; }
    td { padding:6px 8px; border-bottom:1px solid #eee; font-size:11px; }
    tr:nth-child(even) td { background:#f9faf9; }
    .num { text-align:right; }
    .tfoot td { background:#e8f5e9; font-weight:bold; }
    .due { color:#c0392b; font-weight:bold; }
</style>
</head>
<body>
<h1>{{ __('messages.app_name') }}</h1>
<div class="subtitle">{{ $title }} — {{ bd_date(now()->format('d M Y')) }}</div>
<table>
    <thead>
        <tr>
            <th>#</th>
            <th>{{ __('partners.name') }}</th>
            <th class="num">{{ __('reports.total_shares') }}</th>
            <th class="num">{{ __('reports.total_due') }}</th>
            <th class="num">{{ __('reports.total_paid') }}</th>
            <th class="num">{{ __('reports.balance') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach($partners as $i => $row)
        <tr>
            <td>{{ format_amount($i+1, 0) }}</td>
            <td>{{ $row['partner']->name }}</td>
            <td class="num">{{ format_amount($row['total_shares'], 0) }}</td>
            <td class="num">৳{{ format_amount($row['total_due'],0) }}</td>
            <td class="num">৳{{ format_amount($row['total_paid'],0) }}</td>
            <td class="num {{ $row['balance']>0?'due':'' }}">৳{{ format_amount($row['balance'],0) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr class="tfoot">
            <td colspan="2">{{ __('messages.total') }}</td>
            <td class="num">{{ format_amount($partners->sum('total_shares'),0) }}</td>
            <td class="num">৳{{ format_amount($partners->sum('total_due'),0) }}</td>
            <td class="num">৳{{ format_amount($partners->sum('total_paid'),0) }}</td>
            <td class="num">৳{{ format_amount($partners->sum('balance'),0) }}</td>
        </tr>
    </tfoot>
</table>
</body>
</html>