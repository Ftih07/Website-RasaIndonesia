<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Payout;
use Illuminate\Support\Collection;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RevenueReportExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithColumnFormatting
{
    private ?string $from;
    private ?string $until;
    private ?int $businessId;
    private Collection $rows;

    public function __construct(?string $from = null, ?string $until = null, ?int $businessId = null)
    {
        $this->from = $from;
        $this->until = $until;
        $this->businessId = $businessId;
        $this->rows = collect();
    }

    public function collection()
    {
        $query = Order::query()
            ->whereHas('payment', function ($q) {
                $q->whereNotIn('status', ['incomplete', 'failed']);
            })
            ->whereNotIn('delivery_status', ['waiting', 'canceled'])
            ->selectRaw('
                business_id,
                COUNT(*) as total_orders,
                SUM(gross_price) as total_gross,
                SUM(total_price - order_fee) as total_net
            ')
            ->with('business')
            ->groupBy('business_id');

        if ($this->from) {
            $query->whereDate('order_date', '>=', $this->from);
        }
        if ($this->until) {
            $query->whereDate('order_date', '<=', $this->until);
        }
        if ($this->businessId) {
            $query->where('business_id', $this->businessId);
        }

        $this->rows = $query->get();
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Business',
            'Orders',
            'Gross Revenue (AUD)',
            'Net Revenue (AUD)',
            'Total Payouts (AUD)',
            'Balance (AUD)',
        ];
    }

    public function map($record): array
    {
        $paidOut = Payout::where('business_id', $record->business_id)
            ->where('status', 'paid')
            ->sum('amount');

        $balance = ($record->total_net ?? 0) - $paidOut;

        return [
            $record->business?->name ?? '-',
            $record->total_orders,
            (float) $record->total_gross,
            (float) $record->total_net,
            (float) $paidOut,
            (float) $balance,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => 'center'],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD']
            ]
        ]);
        return [];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // Border
                $sheet->getStyle("A1:F{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FFDDDDDD'],
                        ],
                    ],
                ]);

                // Freeze header
                $sheet->freezePane('A2');
                $sheet->setAutoFilter("A1:F{$highestRow}");

                // Balance warna merah kalau minus, hijau kalau positif
                foreach ($this->rows as $i => $record) {
                    $row = $i + 2;
                    $cell = "F{$row}";
                    $balance = ($record->total_net ?? 0) - (
                        \App\Models\Payout::where('business_id', $record->business_id)
                        ->where('status', 'paid')->sum('amount')
                    );

                    if ($balance < 0) {
                        $sheet->getStyle($cell)->getFont()->getColor()->setRGB('FF0000'); // merah
                    } else {
                        $sheet->getStyle($cell)->getFont()->getColor()->setRGB('008000'); // hijau
                    }

                    $sheet->getStyle($cell)->getAlignment()->setHorizontal('right');
                }
            }
        ];
    }
}
