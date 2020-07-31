<?php


    namespace App\Http\Controllers;


    use App\Jobs\SynchronizeGoogleCalendars;
    use App\Jobs\SynchronizeGoogleEvents;
    use App\Models\Event;
    use Carbon\Carbon;

    class EventsController extends Controller
    {
        public function index()
        {
            $events = auth()->user()->events()
                ->orderBy('started_at', 'asc')
                ->where('started_at', '>=', Carbon::now())
                ->get();

            return view('events.index', compact('events'));
        }

    }
