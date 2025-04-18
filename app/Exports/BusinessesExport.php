<?php

namespace App\Exports;

use App\Models\Business;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class BusinessesExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Business::with(['type', 'qrLink'])->get();
    }

    public function headings(): array
    {
        return [
            'id',
            'Type',
            'Business Data Update On',
            'QR Link',
            'Food Categories',
            'Name',
            'Description',
            'Logo',
            'Address',
            'Iframe URL',
            'Open Hours',
            'Services',
            'Menu',
            'Media Social',
            'Location',
            'Contact',
            'Latitude',
            'Longitude',
            'Unique Code',
            'Document',
            'Order',
            'Reserve',
            'Galleries',
            'Products',
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

            // Gallery as string: title + image
            $business->galleries->map(function ($gallery) {
                return $gallery->title . ' (' . asset('storage/' . $gallery->image) . ')';
            })->join(', '),

            // Product as string: name + price + image
            $business->products->map(function ($product) {
                return $product->name . ' - ' . $product->price . ' (' . asset('storage/' . $product->image) . ')';
            })->join(', '),
        ];
    }
}
