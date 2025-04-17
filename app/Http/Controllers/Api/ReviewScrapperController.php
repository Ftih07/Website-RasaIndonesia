<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ReviewScrapper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ReviewScrapperController extends Controller
{
    /**
     * Download a single record as JSON
     */
    public function downloadJson(ReviewScrapper $reviewScrapper)
    {
        $data = [
            'id' => $reviewScrapper->id,
            'name' => $reviewScrapper->name,
            'address' => $reviewScrapper->address,
            'phone' => $reviewScrapper->phone,
            'website' => $reviewScrapper->website,
            'rating' => $reviewScrapper->rating,
            'reviews' => $reviewScrapper->reviews,
            'maps_url' => $reviewScrapper->maps_url,
            'additional_data' => $reviewScrapper->additional_data,
            'created_at' => $reviewScrapper->created_at,
            'updated_at' => $reviewScrapper->updated_at,
        ];

        $filename = \Illuminate\Support\Str::slug($reviewScrapper->name) . '-' . date('Y-m-d') . '.json';

        return Response::make(
            json_encode($data, JSON_PRETTY_PRINT),
            200,
            [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }

    /**
     * Download multiple records as JSON
     */
    public function downloadMultipleJson(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:review_scrappers,id'
        ]);

        $records = ReviewScrapper::whereIn('id', $request->ids)->get();
        $data = [];

        foreach ($records as $record) {
            $data[] = [
                'id' => $record->id,
                'name' => $record->name,
                'address' => $record->address,
                'phone' => $record->phone,
                'website' => $record->website,
                'rating' => $record->rating,
                'reviews' => $record->reviews,
                'maps_url' => $record->maps_url,
                'additional_data' => $record->additional_data,
                'created_at' => $record->created_at,
                'updated_at' => $record->updated_at,
            ];
        }

        $filename = 'review-scrapper-export-' . date('Y-m-d') . '.json';

        return Response::make(
            json_encode($data, JSON_PRETTY_PRINT),
            200,
            [
                'Content-Type' => 'application/json',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]
        );
    }
}
