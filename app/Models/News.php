<?php

namespace App\Models; // Defines the namespace for the News model, organizing it within the application's models.

use Carbon\Carbon; // Carbon library for advanced date and time manipulation.
use Illuminate\Database\Eloquent\Model; // Base Eloquent Model class.
use Illuminate\Database\Eloquent\SoftDeletes; // Trait to enable soft deletion functionality.
use Illuminate\Support\Str; // Facade for string manipulation, used here for slug generation.

/**
 * Class News
 *
 * This Eloquent Model represents the 'news' table in the database.
 * It provides a structured way to interact with news article records,
 * including defining fillable attributes, handling data types,
 * implementing soft deletion, automatic slug generation (with uniqueness),
 * reading time estimation, and dynamic publication date handling.
 */
class News extends Model
{
    // Use the SoftDeletes trait to enable soft deleting records.
    // This means instead of permanent deletion, records will have their 'deleted_at'
    // timestamp set, allowing for easy restoration and historical data retention.
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * These fields can be safely filled via mass assignment (e.g., `News::create([...])` or `->fill([...])->save()`).
     * It's a security feature in Laravel to prevent unintended attribute modifications.
     * Add any database column that you want to be mass assignable here.
     *
     * @var array
     */
    protected $fillable = [
        'title',          // The title of the news article.
        'image_news',     // Path or URL to the news article's main image.
        'writer',         // The author or writer of the news article.
        'time_read',      // Estimated reading time of the article (optional display field).
        'date_published', // The date and time when the news article was published.
        'desc',           // The main content or description of the news article.
        'meta_keywords',
        'status',         // The publication status of the news article (e.g., 'draft', 'published').
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * This property defines how certain attributes should be converted when they are retrieved from
     * or set on the model. For example, 'datetime' means it will be automatically converted
     * to a Carbon instance, allowing for easy date/time manipulation.
     *
     * @var array
     */
    protected $casts = [
        'date_published' => 'datetime', // Casts 'date_published' to a Carbon datetime object.
    ];

    /**
     * The "boot" method of the model.
     *
     * This method is called once when the model is initialized. It's a good place to
     * register global scopes, event listeners, or other one-time setup tasks for the model.
     * In this case, it's primarily used to automatically generate slugs, estimate reading time,
     * and set the publication date based on the news status.
     */
    protected static function boot(): void
    {
        parent::boot(); // Call the parent boot method to ensure basic model booting.

        // Register an event listener for when a News model is being created (inserted for the first time).
        static::creating(function ($news) {
            // Generate a URL-friendly slug from the news article's title.
            // Slugs are typically used in URLs for better readability and SEO.
            $slug = Str::slug($news->title);
            $originalSlug = $slug; // Store the original slug to append numbers if duplicates are found.
            $count = 1;

            // Check for slug uniqueness in the database.
            // If a duplicate slug exists, append a number (e.g., 'my-article-1', 'my-article-2').
            while (News::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            // Assign the unique slug to the news article.
            $news->slug = $slug;

            // Estimate the reading time for the news article based on its description content.
            // This method calculates the time in minutes based on word count.
            $news->time_read = self::estimateReadingTime($news->desc);
        });

        // Register an event listener for when a News model is being updated.
        static::updating(function ($news) {
            // Regenerate the slug from the news article's title whenever the event is updated.
            // This ensures the slug stays in sync if the title changes.
            // Note: This implementation will change the slug on every update, which might
            // affect existing links if not desired. A more robust solution might check
            // if the title has actually changed before regenerating the slug.
            $news->slug = Str::slug($news->title);

            // Re-estimate the reading time for the news article if its description content might have changed.
            $news->time_read = self::estimateReadingTime($news->desc);
        });

        // Register an event listener that runs both when a model is being created or updated.
        static::saving(function ($news) {
            // Check if the news article's status is 'published' and if 'date_published' is currently empty.
            // This ensures that 'date_published' is automatically set to the current time
            // (in 'Australia/Melbourne' timezone) only when an article is first published.
            if ($news->status === 'published' && empty($news->date_published)) {
                $news->date_published = now()->setTimezone('Australia/Melbourne');
            }
        });
    }

    /**
     * Helper function to estimate the reading time of text.
     *
     * This private static method calculates an approximate reading time in minutes
     * based on the number of words in the provided text. It assumes an average
     * reading speed of 200 words per minute. HTML tags are stripped before counting words.
     *
     * @param string $text The content whose reading time is to be estimated.
     * @return int The estimated reading time in minutes (rounded up).
     */
    protected static function estimateReadingTime(string $text): int
    {
        // Remove HTML tags from the text to get a clean word count.
        $wordCount = str_word_count(strip_tags($text));
        // Calculate reading time by dividing word count by 200 (words per minute) and rounding up.
        // E.g., 500 words / 200 = 2.5, ceil(2.5) = 3 minutes.
        return (int) ceil($wordCount / 200);
    }

    /**
     * Accessor for 'published_display' attribute.
     *
     * This "Accessor" automatically formats and returns a human-readable string
     * representing the news article's publication date and time whenever
     * `$news->published_display` is accessed. It ensures the time is displayed
     * in the 'Australia/Melbourne' timezone.
     *
     * @return string
     */
    public function getPublishedDisplayAttribute(): string
    {
        // Get the publication date and set its timezone to 'Australia/Melbourne'.
        $date = $this->date_published->setTimezone('Australia/Melbourne');

        // Format the date into a readable string including time, timezone, day of week, month, date, and year.
        // E.g., "Published 9:30 AM AEST (Melbourne Time), Mon January 01, 2024"
        return 'Published ' . $date->format('g:i A') . ' ' . $date->format('T') . ' (Melbourne Time), ' . $date->format('D F d, Y');
    }
}
