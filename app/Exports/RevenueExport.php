<?php
// app/Exports/RevenueExport.php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Events\BeforeSheet;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class RevenueExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithColumnFormatting,
    ShouldAutoSize,
    WithStyles,
    WithEvents,
    WithCustomStartCell
{
    protected int $businessId;
    protected string $from;
    protected string $until;
    protected ?string $businessName;
    protected $rows;

    public function __construct(int $businessId, string $from, string $until, ?string $businessName = null)
    {
        $this->businessId   = $businessId;
        $this->from         = $from;
        $this->until        = $until;
        $this->businessName = $businessName;
    }

    public function startCell(): string
    {
        // Data table mulai di A4 (biar bisa taruh judul di A1–A3)
        return 'A4';
    }

    public function collection()
    {
        $this->rows = Order::valid()
            ->where('business_id', $this->businessId)
            ->whereBetween('order_date', [$this->from, $this->until])
            ->selectRaw('
                MONTH(order_date) as month,
                COUNT(*) as total_orders,
                SUM(total_price) as gross_revenue,
                SUM(order_fee) as total_fee,
                SUM(total_price - order_fee) as net_revenue,
                SUM(CASE WHEN delivery_status = "delivered" THEN 1 ELSE 0 END) as delivered_orders,
                SUM(CASE WHEN delivery_status = "canceled"  THEN 1 ELSE 0 END) as canceled_orders
            ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Month',
            'Total Orders',
            'Gross Revenue (AUD)',
            'Total Fee (AUD)',
            'Net Revenue (AUD)',
            'Delivered Orders',
            'Canceled Orders',
            'Avg Order Value (AUD)',
        ];
    }

    public function map($row): array
    {
        $monthName = Carbon::create()->month($row->month)->format('F');
        $aov = ($row->total_orders ?? 0) > 0 ? ($row->gross_revenue / $row->total_orders) : 0;

        return [
            $monthName,
            (int) $row->total_orders,
            (float) $row->gross_revenue,
            (float) $row->total_fee,
            (float) $row->net_revenue,
            (int) $row->delivered_orders,
            (int) $row->canceled_orders,
            (float) $aov,
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Gross
            'D' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Fee
            'E' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Net
            'H' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // AOV
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style header (row 4 karena startCell A4)
        $sheet->getStyle('A4:H4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD'],
            ],
        ]);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            // Tuliskan judul, business, dan periode sebelum sheet diisi data
            BeforeSheet::class => function (BeforeSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $title  = 'Revenue Report';
                $biz    = $this->businessName ? "Business: {$this->businessName}" : '';
                $period = "Period: {$this->from} to {$this->until}";

                $sheet->setCellValue('A1', $title);
                $sheet->setCellValue('A2', $biz);
                $sheet->setCellValue('A3', $period);

                // Merge A1:H1 supaya judul lebar
                $sheet->mergeCells('A1:H1');
                $sheet->mergeCells('A2:H2');
                $sheet->mergeCells('A3:H3');

                // Styling judul
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 16, 'color' => ['rgb' => '1F2937']],
                ]);
                $sheet->getStyle('A2:A3')->applyFromArray([
                    'font' => ['color' => ['rgb' => '6B7280']],
                ]);
            },

            AfterSheet::class => function (AfterSheet $event) {
                $sheet      = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow(); // termasuk header
                // Data mulai baris 5 (karena header di baris 4)
                $dataStart  = 5;
                $dataEnd    = max($dataStart, $highestRow);

                // Freeze header
                $sheet->freezePane('A5');

                // AutoFilter
                $sheet->setAutoFilter("A4:H{$dataEnd}");

                // Border seluruh tabel (header + data)
                $sheet->getStyle("A4:H{$dataEnd}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['argb' => 'FFDDDDDD'],
                        ],
                    ],
                ]);

                // Totals row
                $totalRow = $dataEnd + 1;
                $sheet->setCellValue("A{$totalRow}", 'TOTAL');
                // SUM untuk Orders, Gross, Fee, Net, Delivered, Canceled
                $sheet->setCellValue("B{$totalRow}", "=SUM(B{$dataStart}:B{$dataEnd})");
                $sheet->setCellValue("C{$totalRow}", "=SUM(C{$dataStart}:C{$dataEnd})");
                $sheet->setCellValue("D{$totalRow}", "=SUM(D{$dataStart}:D{$dataEnd})");
                $sheet->setCellValue("E{$totalRow}", "=SUM(E{$dataStart}:E{$dataEnd})");
                $sheet->setCellValue("F{$totalRow}", "=SUM(F{$dataStart}:F{$dataEnd})");
                $sheet->setCellValue("G{$totalRow}", "=SUM(G{$dataStart}:G{$dataEnd})");
                // AOV total = Gross total / Orders total
                $sheet->setCellValue("H{$totalRow}", "=IF(B{$totalRow}>0,C{$totalRow}/B{$totalRow},0)");

                // Style totals row
                $sheet->getStyle("A{$totalRow}:H{$totalRow}")->applyFromArray([
                    'font' => ['bold' => true],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'E5F3FF'],
                    ],
                    'borders' => [
                        'top' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['argb' => 'FFBBD7F0']],
                    ],
                ]);

                // Rata kanan untuk angka
                $sheet->getStyle("B{$dataStart}:H{$totalRow}")->getAlignment()->setHorizontal('right');
                // Rata kiri kolom bulan
                $sheet->getStyle("A{$dataStart}:A{$totalRow}")->getAlignment()->setHorizontal('left');
            },
        ];
    }
}
