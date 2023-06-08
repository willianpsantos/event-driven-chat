<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function getEventsForHome() {
        $events = Event::canBeShownAtHome()->get();
        $data = $events->toArray();
        return response()->json($data);
    }
}
