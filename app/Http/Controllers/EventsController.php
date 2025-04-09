<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Carbon\Carbon;

use Illuminate\Http\Request;

class EventsController extends Controller
{
    //

    public function show($slug)
    {
        $event = Events::where('slug', $slug)->firstOrFail();
        $events = Events::latest()->get();
    
        return view('events.show', compact('event', 'events'));
    }
}
 