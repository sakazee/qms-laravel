<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<style>
    @font-face { font-family: SolaimanLipi; src: url('{{ public_path("fonts/bengali/SolaimanLipi.ttf") }}'); }
    body { font-family: SolaimanLipi, sans-serif; font-size: 12px; }
    h1 { font-size:18px; color:#1a6b3a; text-align:center; }
    .subtitle { text-align:center; color:#666; font-size:11px; margin-bottom:20px; }
    table { width:100%; border-collapse:collapse; }
    th { background:#1a6b3a; color:#fff; padding:7px 8px; font-size:11px; }
    td { padding:6px 8px; border-bottom:1px solid #eee; font-size:11px; }
    tr:nth-child(even) td { background:#f9faf9; }
    .tfoot td { background:#e8f5e9; font-weight:bold; }
    .due { color:#c0392b; font-weight:bold; }
</style>
</head>
<body>
<h1>{{ __('messages.app_name') }}</h1>
<div class="subtitle">{{ $title }} — {{ now()->format('d M Y') }}</div>
<table>
    <thead>
        <tr><th>#</th><th>{{ __('partners.name') }}</th><th>{{ __('partners.phone') }}</th><th>{{ __('partners.total_share') }}</th><th>{{ __('partners.total_paid') }}</th><th>{{ __('partners.due') }}</th><th>{{ __('partners.advance') }}</th></tr>
    </thead>
    <tbody>
        @foreach($partners as $i => $row)
        <tr>
            <td>{{ $i+1 }}</td><td>{{ $row['partner']->name }}</td><td>{{ $row['partner']->phone ?: '—' }}</td>
            <td>৳{{ number_format($row['total_share'],0) }}</td>
            <td>৳{{ number_format($row['total_paid'],0) }}</td>
            <td class="{{ $row['due']>0?'due':'' }}">৳{{ number_format($row['due'],0) }}</td>
            <td>৳{{ number_format($row['advance'],0) }}</td>
        </tr>
        @endforeach
    </tbody>
    <tfoot><tr class="tfoot"><td colspan="3">{{ __('messages.total') }}</td><td>৳{{ number_format($partners->sum('total_share'),0) }}</td><td>৳{{ number_format($partners->sum('total_paid'),0) }}</td><td>৳{{ number_format($partners->sum('due'),0) }}</td><td>৳{{ number_format($partners->sum('advance'),0) }}</td></tr></tfoot>
</table>
</body>
</html>
