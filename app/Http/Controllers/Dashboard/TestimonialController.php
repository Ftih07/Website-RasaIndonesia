<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Helpers\NotificationHelper;
use App\Models\Business;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

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
        $request->validate([
            'reply' => 'required|string|max:1000',
        ]);

        $testimonial->update([
            'reply' => $request->reply,
            'replied_at' => Carbon::now(),
            'replied_by' => auth()->id(),
        ]);

        // Kirim notifikasi ke user yang membuat testimoni
        NotificationHelper::send(
            $testimonial->user_id,
            'Balasan dari pemilik bisnis',
            'Testimoni kamu telah dibalas oleh pemilik bisnis. Klik untuk melihat detailnya.',
            url('/business/' . $testimonial->business->slug) // atau route detail testimoni jika ada
        );

        return back()->with('success', 'Balasan berhasil dikirim dan notifikasi telah dikirim ke pengguna.');
    }

    public function like(Testimonial $testimonial)
    {
        $user = auth()->user();

        $alreadyLiked = $testimonial->likes()->where('user_id', $user->id)->exists();

        if ($alreadyLiked) {
            return back()->with('error', 'Kamu sudah memberi like.');
        }

        $testimonial->likes()->create([
            'user_id' => $user->id,
        ]);

        // Notifikasi ke pemilik testimonial
        if ($testimonial->user_id !== $user->id) {
            NotificationHelper::send(
                $testimonial->user_id,
                'Komentar Anda Disukai',
                $user->name . ' menyukai komentar/testimoni Anda.',
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

        return back()->with('success', 'Testimonial berhasil diperbarui.');
    }

    public function destroy(Testimonial $testimonial)
    {
        $this->authorize('delete', $testimonial); // Opsional pakai policy
        $testimonial->delete();

        return back()->with('success', 'Testimonial berhasil dihapus.');
    }
}
