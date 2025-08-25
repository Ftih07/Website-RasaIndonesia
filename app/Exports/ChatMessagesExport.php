<?php

namespace App\Exports;

use App\Models\Message;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ChatMessagesExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithEvents
{
    use Exportable;

    protected $businessId;
    protected $startDate;
    protected $endDate;
    protected $messages;

    public function __construct($businessId = null, $startDate = null, $endDate = null)
    {
        $this->businessId = $businessId;
        $this->startDate  = $startDate;
        $this->endDate    = $endDate;
    }

    public function query()
    {
        $query = Message::query()
            ->with(['chat.business', 'sender']);

        if ($this->businessId) {
            $query->whereHas('chat', function ($q) {
                $q->where('business_id', $this->businessId);
            });
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        $this->messages = $query->get();

        return $query;
    }

    public function headings(): array
    {
        return [
            'Business',
            'Chat ID',
            'Sender',
            'Message',
            'Created At',
            'Image Link',
        ];
    }

    public function map($message): array
    {
        // generate full URL (pastikan sudah php artisan storage:link)
        $url = $message->image_path ? asset('storage/' . $message->image_path) : '';

        return [
            $message->chat->business->name ?? '-',
            $message->chat_id,
            $message->sender->name ?? '-',
            $message->message,
            $message->created_at->format('Y-m-d H:i:s'),
            $url, // cell isi link
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => 'solid', 'color' => ['rgb' => '4F81BD']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ]);

        $sheet->getStyle('A:F')->getAlignment()->setVertical('top');
        $sheet->getStyle('D:D')->getAlignment()->setWrapText(true);

        return [];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                foreach ($this->messages as $index => $msg) {
                    if (!empty($msg->image_path)) {
                        $url = asset('storage/' . $msg->image_path);
                        $cell = 'F' . ($index + 2);

                        // set cell jadi hyperlink
                        $event->sheet->getDelegate()->getCell($cell)->getHyperlink()->setUrl($url);

                        // styling supaya keliatan kaya link
                        $event->sheet->getDelegate()->getStyle($cell)->getFont()->getColor()->setRGB('0000FF');
                        $event->sheet->getDelegate()->getStyle($cell)->getFont()->setUnderline(true);
                    }
                }
            },
        ];
    }
}
