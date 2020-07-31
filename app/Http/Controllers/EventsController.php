<?php


    namespace App\Http\Controllers;


    use App\Jobs\SynchronizeGoogleCalendars;
    use App\Jobs\SynchronizeGoogleEvents;

    class EventsController extends Controller
    {
        public function index()
        {
            $events = auth()->user()->events()
                ->orderBy('started_at', 'desc')
                ->get();

            return view('events', compact('events'));
        }

    }
