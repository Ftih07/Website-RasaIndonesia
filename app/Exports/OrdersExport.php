<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements
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
    private ?string $paymentStatus;
    private ?string $deliveryStatus;
    private $rows;

    public function __construct(?string $from = null, ?string $until = null, ?int $businessId = null, ?string $paymentStatus = null, ?string $deliveryStatus = null)
    {
        $this->from = $from;
        $this->until = $until;
        $this->businessId = $businessId;
        $this->paymentStatus = $paymentStatus;
        $this->deliveryStatus = $deliveryStatus;
    }

    public function collection()
    {
        $query = Order::query()->with(['business', 'user', 'payment']);

        if ($this->from) {
            $query->whereDate('created_at', '>=', $this->from);
        }
        if ($this->until) {
            $query->whereDate('created_at', '<=', $this->until);
        }
        if ($this->businessId) {
            $query->where('business_id', $this->businessId);
        }
        if ($this->paymentStatus) {
            $query->whereHas('payment', fn($q) => $q->where('status', $this->paymentStatus));
        }
        if ($this->deliveryStatus) {
            $query->where('delivery_status', $this->deliveryStatus);
        }

        $this->rows = $query->get();
        return $this->rows;
    }

    public function headings(): array
    {
        return [
            'Order #',
            'Business',
            'Customer',
            'Payment Status',
            'Delivery Status',
            'Gross Price (AUD) - Customer Pay',
            'Net Payout (AUD) - Partner/Seller',
            'Created At',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->business?->name ?? '-',
            $order->user?->name ?? '-',
            ucfirst($order->payment?->status ?? '-'),
            ucfirst(str_replace('_', ' ', $order->delivery_status)),
            (float) $order->gross_price,
            (float) ($order->total_price - $order->order_fee),
            $order->created_at?->format('Y-m-d H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->applyFromArray([
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
            'F' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
            'G' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $highestRow = $sheet->getHighestRow();

                // border
                $sheet->getStyle("A1:H{$highestRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FFDDDDDD'],
                        ],
                    ],
                ]);

                // freeze
                $sheet->freezePane('A2');
                $sheet->setAutoFilter("A1:H{$highestRow}");

                // coloring payment status
                foreach ($this->rows as $i => $order) {
                    $row = $i + 2;
                    $paymentCell = "D{$row}";
                    $deliveryCell = "E{$row}";

                    // Payment status
                    $status = strtolower($order->payment?->status ?? '');
                    if ($status === 'pending') {
                        $sheet->getStyle($paymentCell)->getFont()->getColor()->setRGB('e6b800'); // kuning
                    } elseif ($status === 'paid') {
                        $sheet->getStyle($paymentCell)->getFont()->getColor()->setRGB('008000'); // hijau
                    } elseif (in_array($status, ['failed', 'incomplete'])) {
                        $sheet->getStyle($paymentCell)->getFont()->getColor()->setRGB('FF0000'); // merah
                    }

                    // Delivery status
                    $dStatus = strtolower($order->delivery_status ?? '');
                    if ($dStatus === 'delivered') {
                        $sheet->getStyle($deliveryCell)->getFont()->getColor()->setRGB('008000'); // hijau
                    } elseif ($dStatus === 'canceled') {
                        $sheet->getStyle($deliveryCell)->getFont()->getColor()->setRGB('FF0000'); // merah
                    } elseif ($dStatus === 'waiting') {
                        $sheet->getStyle($deliveryCell)->getFont()->getColor()->setRGB('e6b800'); // kuning
                    }
                }
            }
        ];
    }
}
