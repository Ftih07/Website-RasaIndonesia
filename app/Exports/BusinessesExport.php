<?php

namespace App\Exports;

use App\Models\Business;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BusinessesExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function collection()
    {
        return Business::with(['type', 'qrLink', 'galleries', 'products'])->get();
    }

    public function headings(): array
    {
        return [
            'ID', // Row 1
            'Type', // Row 2
            'Business Data Update On', // Row 3
            'Business Unique ID', // Row 4
            'Business QR Code Name', // Row 5
            'Food Categories', // Row 6
            'Business Name', // Row 7
            'Description', // Row 8
            'Logo', // Row 9
            'Address', // Row 10
            'Iframe URL',// Row 11
            'Open Hours',// Row 12
            'Services',// Row 13
            'Menu',// Row 14
            'Media Social',// Row 15
            'Location',// Row 16
            'Contact',// Row 17
            'Latitude',// Row 18
            'Longitude',// Row 19
            'Document',// Row 20
            'Order',// Row 21
            'Reserve',// Row 22
            'Galleries',// Row 23
            'Products',// Row 24
        ];
    }

    public function map($business): array
    {
        return [
            $business->id,
            $business->type->title ?? '',
            $business->updated_at
                ? 'Updated On: ' . \Carbon\Carbon::parse($business->updated_at)->format('D F d, Y \a\t gA')
                : '',
            $business->unique_code,
            $business->qrLink->name ?? '',
            $business->food_categories->pluck('title')->join(', '),
            $business->name,
            $business->description,
            $business->logo,
            $business->address,
            $business->iframe_url,
            json_encode($business->open_hours),
            json_encode($business->services),
            $business->menu,
            json_encode($business->media_social),
            $business->location,
            json_encode($business->contact),
            $business->latitude,
            $business->longitude,
            $business->document,
            json_encode($business->order),
            json_encode($business->reserve),
            $business->galleries->map(function ($gallery) {
                return $gallery->title . ' (' . asset('storage/' . $gallery->image) . ')';
            })->join(', '),
            $business->products->map(function ($product) {
                return $product->name . ' - ' . $product->price;
            })->join(', '),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Bold heading row
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ] + [
            // Header background color
            'A1:Y1' => ['fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['rgb' => '4F81BD']
            ]],
        ];
    }

    public function title(): string
    {
        return 'Businesses Export';
    }
}
