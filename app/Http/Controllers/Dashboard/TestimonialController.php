<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Helpers\NotificationHelper;
use App\Models\Activity;
use App\Models\Business;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{

    use AuthorizesRequests;

    public function index()
    {
        $user = auth()->user();
        $business = $user->business;

        if (!$business) {
            return redirect()->route('dashboard')->with('error', 'Business not found.');
        }

        $testimonials = Testimonial::where('business_id', $business->id)->with('user')->latest()->get();

        return view('dashboard.testimonial.index', compact('testimonials', 'business'));
    }

    public function reply(Request $request, Testimonial $testimonial)
    {
        $user = Auth::user();

        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $testimonial->update([
            'reply' => $request->reply,
            'replied_at' => Carbon::now(),
            'replied_by' => auth()->id(),
        ]);

        Activity::create([
            'business_id' => $testimonial->business_id,
            'type'        => 'testimonial',
            'title'       => 'Replied to Testimonial',
            'description' => "{$user->name} replied to {$testimonial->name}'s testimonial.",
        ]);

        // Kirim notifikasi ke user yang membuat testimoni
        NotificationHelper::send(
            $testimonial->user_id,
            'Response from business owner',
            'Your testimonial has been replied to by the business owner. Click to view the details.',
            url('/business/' . $testimonial->business->slug) // atau route detail testimoni jika ada
        );

        return back()->with('success', 'Balasan berhasil dikirim dan notifikasi telah dikirim ke pengguna.');
    }

    public function like(Testimonial $testimonial)
    {
        $user = auth()->user();

        $alreadyLiked = $testimonial->likes()->where('user_id', $user->id)->exists();

        if ($alreadyLiked) {
            return back()->with('error', 'You have already liked it.');
        }

        $testimonial->likes()->create([
            'user_id' => $user->id,
        ]);

        Activity::create([
            'business_id' => $testimonial->business_id,
            'type'        => 'testimonial',
            'title'       => 'Testimonial Liked',
            'description' => "{$user->name} liked testimonial from {$testimonial->name}.",
        ]);

        // Notifikasi ke pemilik testimonial
        if ($testimonial->user_id !== $user->id) {
            NotificationHelper::send(
                $testimonial->user_id,
                'Your comment is liked',
                $user->name . ' likes your comment/testimonial.',
                url('/business/' . $testimonial->business->slug) // atau link detail testimoni
            );
        }

        return back()->with('success', 'Terima kasih atas feedbacknya!');
    }

    // TestimonialController.php (dashboard namespace atau pindah ke general namespace jika untuk frontend user)
    public function store(Request $request, $slug)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'You must login to submit a testimonial.');
        }

        $business = Business::where('slug', $slug)->firstOrFail();

        $request->validate([
            'description' => 'required|string|max:500',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        Activity::create([
            'business_id' => $business->id,
            'type'        => 'testimonial',
            'title'       => 'New Testimonial',
            'description' => "{$request->user()->name} added a testimonial with rating {$request->rating}.",
        ]);

        Testimonial::create([
            'business_id' => $business->id,
            'user_id' => auth()->id(),
            'name' => auth()->user()->name ?? auth()->user()->username,
            'description' => $request->description,
            'rating' => $request->rating,
            'publishedAtDate' => now(),
        ]);

        return redirect()->route('business.show', ['slug' => $slug])
            ->with('success', 'Testimonial added successfully!');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $this->authorize('update', $testimonial); // Opsional pakai policy

        $request->validate([
            'description' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $testimonial->update([
            'description' => $request->description,
            'rating' => $request->rating,
        ]);

        Activity::create([
            'business_id' => $testimonial->business_id,
            'type'        => 'testimonial',
            'title'       => 'Testimonial Updated',
            'description' => "{$testimonial->name} updated their testimonial (rating: {$request->rating}).",
        ]);

        return back()->with('success', 'Testimonial successfully updated.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->authorize('delete', $testimonial); // Opsional pakai policy
        $testimonial->delete();

        Activity::create([
            'business_id' => $testimonial->business_id,
            'type'        => 'testimonial',
            'title'       => 'Testimonial Deleted',
            'description' => "{$testimonial->name}'s testimonial was removed.",
        ]);

        return back()->with('success', 'Testimonial successfully deleted.');
    }
}
