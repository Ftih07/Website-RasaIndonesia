<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Type;
use App\Models\FoodCategory;
use App\Models\QrLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DashboardBusinessController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        $business = $user->business;

        if (!$business) {
            return redirect()->route('home')->with('error', 'You don\'t have a business yet.');
        }

        $qrLinks = QrLink::all();
        $types = Type::all();
        $foodCategories = FoodCategory::all();
        $selectedCategories = $business->food_categories ? $business->food_categories->pluck('id')->toArray() : [];

        return view('dashboard.business.index', compact(
            'business',
            'types',
            'foodCategories',
            'selectedCategories',
            'qrLinks'
        ));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $business = $user->business;

        if (!$business) {
            return redirect()->back()->with('error', 'Business not found.');
        }

        // Tangani open_hours manual dari dua array: open_hours_keys dan open_hours_values
        $open_hours = [];
        $keys = $request->input('open_hours_keys', []);
        $values = $request->input('open_hours_values', []);

        foreach ($keys as $i => $key) {
            if (!empty($key)) {
                $open_hours[$key] = $values[$i] ?? '';
            }
        }

        $existingGalleryIds = $business->galleries()->pluck('id')->toArray();
        $submittedGalleryIds = [];

        foreach ($request->input('gallery_data', []) as $index => $data) {
            $galleryImage = $request->file("gallery_data.$index.image");

            if (!empty($data['id'])) {
                // Update
                $gallery = $business->galleries()->where('id', $data['id'])->first();
                if ($gallery) {
                    $gallery->title = $data['title'];

                    if ($galleryImage) {
                        Storage::disk('public')->delete($gallery->image);
                        $gallery->image = $galleryImage->store('gallery-images', 'public');
                    }

                    $gallery->save();
                    $submittedGalleryIds[] = $gallery->id;
                }
            } else {
                // Create baru
                if ($galleryImage) {
                    $path = $galleryImage->store('gallery-images', 'public');
                    $newGallery = $business->galleries()->create([
                        'title' => $data['title'],
                        'image' => $path,
                    ]);
                    $submittedGalleryIds[] = $newGallery->id;
                }
            }
        }

        // Hapus galeri yang tidak disubmit lagi (berarti dihapus dari form)
        $idsToDelete = array_diff($existingGalleryIds, $submittedGalleryIds);
        $business->galleries()->whereIn('id', $idsToDelete)->get()->each(function ($gallery) {
            Storage::disk('public')->delete($gallery->image);
            $gallery->delete();
        });

        // Validasi input
        $validated = $request->validate([
            'type_id' => 'required|exists:types,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'food_categories' => 'nullable|array',
            'food_categories.*' => 'exists:food_categories,id',
            'logo' => 'nullable|image|max:5120',

            'country' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'address' => 'required|string',
            'location' => 'required|url',
            'iframe_url' => 'nullable|string|max:2048',
            'latitude' => 'nullable|string|max:255',
            'longitude' => 'nullable|string|max:255',

            // Validasi repeater contact
            'contact' => 'nullable|array',
            'contact.*.type' => 'required|string|in:email,wa,telp,telegram',
            'contact.*.details' => 'required|string|max:255',

            'services' => 'nullable|array',
            'services.*' => 'string',

            'menu' => 'nullable|file|max:10240|mimes:pdf,jpeg,png,jpg,webp',

            'open_hours_keys' => 'nullable|array',
            'open_hours_keys.*' => 'nullable|string|max:100',
            'open_hours_values' => 'nullable|array',
            'open_hours_values.*' => 'nullable|string|max:100',

            'order' => 'nullable|array',
            'order.*.platform' => 'required|string',
            'order.*.link' => 'nullable|url',
            'order.*.name' => 'nullable|string',

            'reserve' => 'nullable|array',
            'reserve.*.platform' => 'required|string',
            'reserve.*.link' => 'nullable|url',
            'reserve.*.name' => 'nullable|string',

            'media_social' => 'nullable|array',
            'media_social.*.platform' => 'required|string',
            'media_social.*.link' => 'required|url',


        ]);

        // Update kolom biasa
        $business->update([
            'type_id' => $validated['type_id'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'country' => $validated['country'] ?? null,
            'city' => $validated['city'] ?? null,
            'address' => $validated['address'],
            'location' => $validated['location'],
            'iframe_url' => $validated['iframe_url'] ?? null,
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'contact' => $validated['contact'] ?? [], // simpan contact JSON array

            'open_hours' => $open_hours,
            'services' => $request->input('services', []),

            'order' => $validated['order'] ?? [],
            'reserve' => $validated['reserve'] ?? [],
            'media_social' => $validated['media_social'] ?? [],
        ]);

        // Sinkronisasi kategori makanan
        $business->food_categories()->sync($validated['food_categories'] ?? []);

        // Upload logo
        if ($request->hasFile('logo')) {
            if ($business->logo) {
                Storage::disk('public')->delete($business->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $business->update(['logo' => $path]);
        }

        // Upload menu
        if ($request->hasFile('menu')) {
            if ($business->menu) {
                Storage::disk('public')->delete($business->menu);
            }
            $menuPath = $request->file('menu')->store('menu', 'public');
            $business->update(['menu' => $menuPath]);
        }

        return redirect()->route('dashboard.business')->with('success', 'Business updated successfully.');
    }
}
