<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; padding: 20px; }
        h1 { font-size: 18px; color: #1e293b; border-bottom: 2px solid #4b76c4; padding-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 8px 12px; border: 1px solid #ddd; text-align: left; font-size: 12px; }
        th { background: #f1f5f9; }
        .status { padding: 3px 8px; border-radius: 4px; font-weight: bold; font-size: 11px; }
        .status-paid, .status-completed { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef9c3; color: #854d0e; }
        .status-failed, .status-cancelled { background: #fee2e2; color: #991b1b; }
        .total { font-size: 16px; font-weight: bold; text-align: right; margin-top: 20px; }
    </style>
</head>
<body>
    <h1>Transaction #{{ $transaction->id }}</h1>
    <p><strong>User:</strong> {{ $transaction->user?->name ?? 'N/A' }}<br>
    <strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}<br>
    <strong>Status:</strong> <span class="status status-{{ $transaction->status }}">{{ ucfirst($transaction->status) }}</span></p>

    <table>
        <thead><tr><th>Game</th><th>Price</th></tr></thead>
        <tbody>
            @foreach($transaction->items as $item)
            <tr><td>{{ $item->game?->title ?? 'Game #'.$item->game_id }}</td><td>Rp {{ number_format($item->price, 0, ',', '.') }}</td></tr>
            @endforeach
        </tbody>
    </table>
    <div class="total">Total: Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
</body>
</html>
