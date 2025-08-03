<?php

namespace App\Exports;

use App\Models\ParticipantRegisterProsperityExpo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ParticipantRegisterProsperityExpoExport implements FromCollection, WithHeadings, ShouldAutoSize, WithStyles
{
    protected ?array $ids;

    // ✅ Tambahkan constructor untuk menerima selected IDs
    public function __construct(array $ids = null)
    {
        $this->ids = $ids;
    }

    public function collection()
    {
        $query = ParticipantRegisterProsperityExpo::query()
            ->select([
                'id',
                'name',
                'email',
                'company_name',
                'position',
                'contact',
                'participant_type',
                'company_type',
                'product_description',
                'status',
                'created_at',
                'qr_code',
            ]);

        // ✅ Jika ada IDs yang dipilih, filter berdasarkan IDs
        if (!empty($this->ids)) {
            $query->whereIn('id', $this->ids);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Company Name',
            'Position',
            'Contact',
            'Participant Type',
            'Company Type',
            'Product Description',
            'Status',
            'Registered At',
            'QR Code',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '007ACC'],
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
            ],
        ];
    }
}
