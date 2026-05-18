<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; padding: 20px; font-size: 12px; }
        h1 { font-size: 16px; color: #1e293b; border-bottom: 2px solid #4b76c4; padding-bottom: 8px; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { padding: 6px 8px; border: 1px solid #ddd; text-align: left; }
        th { background: #f1f5f9; }
        .status { padding: 2px 6px; border-radius: 3px; font-weight: bold; font-size: 10px; }
        .status-paid, .status-completed { background: #dcfce7; color: #166534; }
        .status-pending { background: #fef9c3; color: #854d0e; }
        .status-failed, .status-cancelled { background: #fee2e2; color: #991b1b; }
    </style>
</head>
<body>
    <h1>Transactions Report - {{ now()->format('d M Y') }}</h1>
    <table>
        <thead><tr><th>ID</th><th>User</th><th>Total</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
            @foreach($transactions as $t)
            <tr>
                <td>{{ $t->id }}</td>
                <td>{{ $t->user?->name ?? 'N/A' }}</td>
                <td>Rp {{ number_format($t->total_amount, 0, ',', '.') }}</td>
                <td><span class="status status-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                <td>{{ $t->created_at->format('d M Y H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
