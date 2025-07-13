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
    public function collection()
    {
        return ParticipantRegisterProsperityExpo::all([
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
        ]);
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
        ];
    }

    /**
     * Styling the first row as header (bold, white text, blue background)
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Heading row styling
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
