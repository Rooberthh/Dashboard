<?php


    namespace App\Http\Controllers\Api;


    use App\Http\Controllers\Controller;
    use App\Models\Calendar;
    use Carbon\Carbon;
    use Illuminate\Http\Request;

    class CalendarEventsController extends Controller
    {
        public function index(Calendar $calendar, Request $request)
        {
            $events = $calendar->events()
                ->where('started_at', '>=', $request->get('start'))
                ->where('ended_at', '<=', $request->get('end'))
                ->get();

            $selected = array();
            foreach ($events as $ev) {
                $e = array();
                $e['title'] = $ev->name;
                $e['start'] = $ev->started_at;
                $e['end'] = $ev->ended_at;
                $e['allDay'] = $ev->allday;

                array_push($selected, $e);
            }

            return json_encode($selected);
        }

    }
