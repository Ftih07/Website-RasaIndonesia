<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;
use App\Models\Business;
use Illuminate\Support\Facades\File;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        $filePath = public_path('testimonial/testimonial.json'); // Pastikan file ada di `public/`

        if (!file_exists($filePath)) {
            $this->command->error("File csvjson.json tidak ditemukan di public!");
            return;
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        foreach ($data as $row) {

            Testimonial::create([
                'business_id' => 14, 
                'testimonial_user_id' => null,
                'name' => $row['author_title'],
                'description' => $row['review_text'] ?? 'No review text',
                'rating' => $row['rating'] ?? 0,
            ]);            
        }

        $this->command->info("Seeder Testimonial successfully running!");
    }
}
