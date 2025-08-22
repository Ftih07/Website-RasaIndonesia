@extends('layouts.app')

@section('content')
@include('dashboard.partials.navbar')

<div class="min-h-screen bg-gray-50 py-6">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <!-- Header Section -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-orange-500 to-yellow-500 px-6 py-4">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h1 class="text-2xl font-bold text-white">Customer Testimonials</h1>
                            <p class="text-orange-100">{{ $business->name }}</p>
                        </div>
                    </div>
                </div>
            </div>

            @if($testimonials->isEmpty())
            <!-- Empty State -->
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <div class="mx-auto flex items-center justify-center h-24 w-24 rounded-full bg-gradient-to-r from-orange-100 to-yellow-100 mb-4">
                    <svg class="h-12 w-12 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">No Testimonials Yet</h3>
                <p class="text-gray-500">Your customers haven't left any testimonials yet. Keep providing great service and they'll come!</p>
            </div>
            @else
            <!-- Testimonials Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                @foreach($testimonials as $testimonial)
                <div class="bg-white rounded-lg shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                    {{-- Product Image --}}
                    @if($testimonial->image_url_product)
                    <div class="relative h-48 overflow-hidden">
                        <img src="{{ $testimonial->image_url_product }}"
                            class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                            alt="Product Image">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                    @endif

                    <div class="p-6">
                        <!-- Customer Info -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="h-10 w-10 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-full flex items-center justify-center">
                                    <span class="text-white font-semibold text-sm">
                                        {{ substr($testimonial->user->username ?? $testimonial->name, 0, 1) }}
                                    </span>
                                </div>
                                <div class="ml-3">
                                    <h5 class="font-semibold text-gray-900">
                                        {{ $testimonial->user->username ?? $testimonial->name }}
                                    </h5>
                                    <p class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($testimonial->publishedAtDate)->format('d M Y, g:i A') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Rating -->
                        <div class="flex items-center mb-3">
                            <div class="flex items-center">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <=$testimonial->rating)
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    @else
                                    <svg class="h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                    @endif
                                    @endfor
                            </div>
                            <span class="ml-2 text-sm font-medium text-gray-700">{{ $testimonial->rating }}/5</span>
                        </div>

                        <!-- Testimonial Text -->
                        <p class="text-gray-700 mb-4 leading-relaxed">{{ $testimonial->description }}</p>

                        {{-- Produk yang direview --}}
                        @if($testimonial->order && $testimonial->order->items->isNotEmpty())
                        <div class="mb-4">
                            <p class="text-sm font-semibold text-gray-700 mb-1">Purchased products:</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($testimonial->order->items as $item)
                                <div class="flex items-center border rounded-lg p-2 max-w-[200px] bg-gray-50">
                                    @if($item->product && $item->product->image)
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                        alt="{{ $item->product->name }}"
                                        class="w-10 h-10 rounded object-cover mr-2">
                                    @endif
                                    <span class="text-sm text-gray-700">{{ $item->product->name ?? 'Produk tidak ditemukan' }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Gambar testimonial (bisa banyak) --}}
                        @if($testimonial->images && $testimonial->images->isNotEmpty())
                        <div class="flex flex-wrap gap-2 mb-4">
                            @foreach($testimonial->images as $img)
                            <img src="{{ asset('storage/' . $img->image_path) }}"
                                alt="Testimonial Image"
                                class="w-24 h-24 object-cover rounded-lg border">
                            @endforeach
                        </div>
                        @endif

                        {{-- Additional Image --}}
                        @if($testimonial->image_url)
                        <div class="mb-4">
                            <img src="{{ $testimonial->image_url }}"
                                alt="Testimonial Image"
                                class="w-full h-32 object-cover rounded-lg border border-gray-200">
                        </div>
                        @endif

                        <!-- Like Button -->
                        <div class="flex items-center justify-between mb-4 pt-4 border-t border-gray-100">
                            @if($testimonial->likes->contains('user_id', auth()->id()))
                            <span class="inline-flex items-center text-green-600 font-medium">
                                <svg class="h-4 w-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 10.5a1.5 1.5 0 113 0v6a1.5 1.5 0 01-3 0v-6zM6 10.333v5.43a2 2 0 001.106 1.79l.05.025A4 4 0 008.943 18h5.416a2 2 0 001.962-1.608l1.2-6A2 2 0 0015.56 8H12V4a2 2 0 00-2-2 1 1 0 00-1 1v.667a4 4 0 01-.8 2.4L6.8 7.933a4 4 0 00-.8 2.4z"></path>
                                </svg>
                                Thank you!
                            </span>
                            @else
                            <form method="POST" action="{{ route('dashboard.testimonial.like', $testimonial) }}">
                                @csrf
                                <button type="submit" class="inline-flex items-center text-gray-600 hover:text-orange-600 font-medium transition-colors duration-200">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path>
                                    </svg>
                                    Was this helpful?
                                </button>
                            </form>
                            @endif

                            <span class="text-sm text-gray-500">
                                {{ $testimonial->likes->count() }} {{ $testimonial->likes->count() === 1 ? 'person found this helpful' : 'people found this helpful' }}
                            </span>
                        </div>

                        <!-- Business Owner Reply Section -->
                        @if(auth()->user()->id === $business->user_id)
                        @if(!$testimonial->reply)
                        <!-- Reply Form -->
                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                            <form action="{{ route('dashboard.testimonial.reply', $testimonial) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="reply_{{ $testimonial->id }}" class="block text-sm font-semibold text-gray-700 mb-2">
                                        <span class="flex items-center">
                                            <svg class="h-4 w-4 text-orange-500 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path>
                                            </svg>
                                            Reply to Testimonial
                                        </span>
                                    </label>
                                    <textarea name="reply"
                                        id="reply_{{ $testimonial->id }}"
                                        class="block w-full px-3 py-2 border border-orange-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 resize-none transition duration-200"
                                        rows="3"
                                        required
                                        placeholder="Thank your customer for their feedback...">{{ old('reply') }}</textarea>
                                </div>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-orange-500 to-yellow-500 text-white text-sm font-medium rounded-lg hover:from-orange-600 hover:to-yellow-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500 transition duration-200">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                    </svg>
                                    Send Reply
                                </button>
                            </form>
                        </div>
                        @else
                        <!-- Existing Reply -->
                        <div class="bg-gradient-to-r from-orange-50 to-yellow-50 rounded-lg p-4 border border-orange-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="h-8 w-8 bg-gradient-to-r from-orange-500 to-yellow-500 rounded-full flex items-center justify-center">
                                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1">
                                    <div class="flex items-center mb-1">
                                        <span class="font-semibold text-gray-900">{{ $testimonial->replier->name ?? 'Business Owner' }}</span>
                                        <span class="ml-2 inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                            <svg class="h-3 w-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Business Owner
                                        </span>
                                        <span class="ml-2 text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($testimonial->replied_at)->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-gray-700">{{ $testimonial->reply }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Additional responsive styles */
    @media (max-width: 640px) {
        .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }

        .grid {
            grid-template-columns: 1fr;
        }
    }

    /* Custom hover effects */
    .testimonial-card:hover .testimonial-image {
        transform: scale(1.05);
    }

    /* Enhanced focus styles for accessibility */
    button:focus,
    textarea:focus {
        box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1);
        outline: none;
    }

    /* Smooth transitions */
    * {
        transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
        transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
        transition-duration: 200ms;
    }

    /* Custom scrollbar for testimonials */
    .testimonial-container::-webkit-scrollbar {
        width: 6px;
    }

    .testimonial-container::-webkit-scrollbar-track {
        background: #f1f5f9;
    }

    .testimonial-container::-webkit-scrollbar-thumb {
        background: linear-gradient(to bottom, #f97316, #eab308);
        border-radius: 3px;
    }

    /* Rating stars animation */
    .rating-star {
        transition: all 0.2s ease-in-out;
    }

    .rating-star:hover {
        transform: scale(1.1);
    }
</style>
@endsection