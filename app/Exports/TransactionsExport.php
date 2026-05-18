<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected Collection $transactions;

    public function __construct(Collection $transactions)
    {
        $this->transactions = $transactions;
    }

    public function collection()
    {
        $rows = $this->transactions->map(function($t) {
            return [
                $t->id,
                $t->user?->name ?? 'User '.$t->user_id,
                $t->user?->email ?? '-',
                $t->total_amount,
                ucfirst($t->status),
                $t->payment_method ?? '-',
                $t->created_at->format('d M Y H:i'),
            ];
        });

        $totalRevenue = $this->transactions->where('status', 'completed')->sum('total_amount');
        $rows->push(['', '', '', '', '', '', '']);
        $rows->push(['TOTAL REVENUE (COMPLETED)', '', '', $totalRevenue, '', '', '']);

        return $rows;
    }

    public function headings(): array
    {
        return ['ID', 'User', 'Email', 'Total', 'Status', 'Payment', 'Date'];
    }

    public function styles(Worksheet $sheet)
    {
        $headerRange = 'A1:G1';
        $sheet->getStyle($headerRange)->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4B76C4']],
        ]);

        $lastRow = $sheet->getHighestRow();
        $totalRow = 'A' . $lastRow . ':G' . $lastRow;
        $sheet->getStyle($totalRow)->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => '1E293B']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E2E8F0']],
        ]);
    }
}
