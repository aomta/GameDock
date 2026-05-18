<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #1a1a1a; padding: 30px; }
        .header { text-align: center; border-bottom: 3px solid #4b76c4; padding-bottom: 15px; margin-bottom: 20px; }
        .header h1 { font-size: 20px; margin: 0; color: #1e293b; }
        .header p { margin: 5px 0 0; color: #666; font-size: 12px; }
        .info { margin-bottom: 20px; font-size: 13px; }
        .info p { margin: 4px 0; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; }
        th, td { padding: 8px 10px; border: 1px solid #ddd; text-align: left; font-size: 12px; }
        th { background: #f1f5f9; font-weight: bold; }
        .total { text-align: right; font-size: 16px; font-weight: bold; margin-top: 15px; }
        .footer { text-align: center; margin-top: 40px; font-size: 11px; color: #888; border-top: 1px solid #ddd; padding-top: 10px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>GameDock — Receipt</h1>
        <p>Digital purchase receipt</p>
    </div>

    <div class="info">
        <p><strong>Transaction No.:</strong> #{{ $transaction->id }}</p>
        <p><strong>Date:</strong> {{ $transaction->created_at->format('d M Y H:i') }}</p>
        <p><strong>Buyer:</strong> {{ $transaction->user->name }}</p>
        <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
    </div>

    <table>
        <thead>
            <tr><th>#</th><th>Game</th><th>Price</th></tr>
        </thead>
        <tbody>
            @foreach($transaction->items as $i => $item)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $item->game?->title ?? 'Game #'.$item->game_id }}</td>
                <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="total">Total: Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>

    <div class="footer">
        <p>Thank you for shopping at GameDock!</p>
        <p>This receipt is automatically generated and valid without a signature.</p>
    </div>
</body>
</html>
