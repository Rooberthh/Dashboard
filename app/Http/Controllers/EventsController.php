<?php


    namespace App\Http\Controllers;

    class EventsController extends Controller
    {
        public function index()
        {
            $calendars = auth()->user()
                            ->calendars()
                            ->get();

            return view('events.index', compact('calendars', $calendars));
        }

    }
