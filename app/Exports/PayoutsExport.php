<?php

namespace App\Exports;

use App\Models\Payout;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PayoutsExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    ShouldAutoSize,
    WithEvents,
    WithColumnFormatting
{
    private ?string $from;
    private ?string $to;
    /** @var \Illuminate\Support\Collection<int,\App\Models\Payout> */
    private Collection $rows;

    public function __construct(?string $from = null, ?string $to = null)
    {
        $this->from = $from;
        $this->to   = $to;
        $this->rows = collect();
    }

    public function collection()
    {
        $q = Payout::with('business')->orderBy('payout_date');

        if ($this->from) {
            $q->whereDate('payout_date', '>=', $this->from);
        }
        if ($this->to) {
            $q->whereDate('payout_date', '<=', $this->to);
        }

        $this->rows = $q->get();

        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Business',
            'Amount (AUD)',
            'Status',
            'Payout Date',
            'Created At',
        ];
    }

    public function map($payout): array
    {
        return [
            $payout->business?->name ?? '-',
            // biarkan numeric agar bisa diformat Excel
            (float) $payout->amount,
            ucfirst((string) $payout->status),
            $this->toExcelDate($payout->payout_date),
            $this->toExcelDate($payout->created_at),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Header style (row 1)
        $sheet->getStyle('A1:E1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4F81BD']],
        ]);

        return [];
    }

    public function columnFormats(): array
    {
        return [
            'B' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,   // amount
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY,             // payout date
            'E' => NumberFormat::FORMAT_DATE_DATETIME,             // created at
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // Freeze header & AutoFilter
                $sheet->freezePane('A2');
                $sheet->setAutoFilter("A1:E{$highestRow}");

                // Border semua sel
                $sheet->getStyle("A1:E{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['argb' => 'FFDDDDDD'],
                        ],
                    ],
                ]);

                // Warnai kolom Status (kolom C) berdasarkan value
                // Row data mulai dari 2
                foreach ($this->rows as $index => $payout) {
                    $row = $index + 2;
                    $status = strtolower((string) $payout->status);
                    $cell = "C{$row}";

                    if ($status === 'pending') {
                        // kuning lembut
                        $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('FFF3CD');
                    } elseif ($status === 'paid') {
                        // hijau lembut
                        $sheet->getStyle($cell)->getFill()->setFillType(Fill::FILL_SOLID)
                            ->getStartColor()->setRGB('D4EDDA');
                    }

                    // Center text status
                    $sheet->getStyle($cell)->getAlignment()->setHorizontal('center');
                }

                // Alignment kolom angka & tanggal
                $sheet->getStyle("B2:B{$highestRow}")->getAlignment()->setHorizontal('right');
                $sheet->getStyle("D2:E{$highestRow}")->getAlignment()->setHorizontal('center');
            },
        ];
    }

    private function toExcelDate($value): ?float
    {
        if (empty($value)) {
            return null;
        }

        if ($value instanceof \DateTimeInterface) {
            return ExcelDate::dateTimeToExcel($value);
        }

        try {
            return ExcelDate::dateTimeToExcel(Carbon::parse($value));
        } catch (\Throwable $e) {
            return null; // fallback bila parsing gagal
        }
    }
}
