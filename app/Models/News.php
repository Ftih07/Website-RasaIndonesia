<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class News extends Model
{
    //
    protected $fillable = [
        'title',
        'image_news',
        'writer',
        'time_read',        // optional display
        'date_published',
        'desc',
        'status',
    ];

    protected $casts = [
        'date_published' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($news) {
            $slug = Str::slug($news->title);
            $originalSlug = $slug;
            $count = 1;

            while (News::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $news->slug = $slug;

            // Estimasi waktu baca
            $news->time_read = self::estimateReadingTime($news->desc);
        });

        static::updating(function ($news) {
            $news->slug = Str::slug($news->title);

            $news->time_read = self::estimateReadingTime($news->desc);
        });

        static::saving(function ($news) {
            if ($news->status === 'published' && empty($news->date_published)) {
                $news->date_published = now()->setTimezone('Australia/Melbourne');
            }
        });
    }

    // Fungsi bantu
    protected static function estimateReadingTime($text)
    {
        $wordCount = str_word_count(strip_tags($text));
        return ceil($wordCount / 200); // hasilnya 3, 4, dst
    }

    public function getPublishedDisplayAttribute()
    {
        $date = $this->date_published->setTimezone('Australia/Melbourne');

        return 'Published ' . $date->format('g:i A') . ' ' . $date->format('T') . '  (Melbourne Time), ' . $date->format('D F d, Y');
    }
}
