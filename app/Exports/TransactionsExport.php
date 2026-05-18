<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected Collection $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        return $this->transactions->map(function($t) {
            return [
                $t->id,
                $t->user?->name ?? 'User '.$t->user_id,
                $t->user?->email ?? '-',
                'Rp '.number_format($t->total_amount, 0, ',', '.'),
                ucfirst($t->status),
                $t->payment_method ?? '-',
                $t->created_at->format('d M Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return ['ID', 'User', 'Email', 'Total', 'Status', 'Payment', 'Date'];
    }
}
