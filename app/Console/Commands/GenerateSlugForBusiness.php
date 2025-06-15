<?php

namespace App\Console\Commands; // Defines the namespace for this Artisan command.

use Illuminate\Console\Command; // Imports the base class for Artisan commands.
use App\Models\Business; // Imports the Business Eloquent model.
use Illuminate\Support\Str; // Imports the Str facade for string manipulation, specifically for slug generation.

/**
 * Class GenerateSlugForBusiness
 *
 * This Artisan command is responsible for generating unique slugs for 'Business' records
 * that currently do not have one. It's useful for backfilling data or fixing inconsistencies
 * where slugs might have been missed during creation.
 */
class GenerateSlugForBusiness extends Command
{
    /**
     * The name and signature of the console command.
     * This defines how the command is invoked from the terminal.
     * `business:generate-slugs` is the command name.
     *
     * @var string
     */
    protected $signature = 'business:generate-slugs';

    /**
     * The console command description.
     * This provides a brief explanation of what the command does when listed.
     *
     * @var string
     */
    protected $description = 'Generate slugs for businesses that do not have one';

    /**
     * Execute the console command.
     * This method contains the core logic that runs when the command is executed.
     *
     * @return void
     */
    public function handle(): void
    {
        // Retrieve all Business records where the 'slug' column is null.
        // This targets only those businesses that are missing a slug.
        $businesses = Business::whereNull('slug')->get();

        // Iterate through each business found without a slug.
        foreach ($businesses as $b) {
            // Generate a slug from the business's name.
            // `Str::slug()` converts the string to a URL-friendly format (lowercase, hyphens instead of spaces).
            // `uniqid()` is appended to ensure uniqueness, especially if multiple businesses have the same name,
            // preventing slug collisions.
            $b->slug = Str::slug($b->name . '-' . uniqid());

            // Save the business model, which persists the newly generated slug to the database.
            $b->save();

            // Output an informational message to the console for each business whose slug was generated.
            $this->info("Slug generated for: {$b->name}");
        }

        // Output a final success message to the console once all slugs have been processed.
        $this->info("✅ Slug generation complete!");
    }
}
