<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Business;
use Illuminate\Support\Str;

class GenerateSlugForBusiness extends Command
{
    protected $signature = 'business:generate-slugs';
    protected $description = 'Generate slugs for businesses that do not have one';

    public function handle()
    {
        $businesses = Business::whereNull('slug')->get();

        foreach ($businesses as $b) {
            $b->slug = Str::slug($b->name . '-' . uniqid());
            $b->save();
            $this->info("Slug generated for: {$b->name}");
        }

        $this->info("✅ Slug generation complete!");
    }
}
