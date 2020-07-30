<?php

namespace App\Jobs;

use App\Google;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SynchronizeGoogleCalendars extends SynchronizeGoogleResource implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getGoogleService()
    {
        return app(Google::class)
            ->connectUsing($this->user->token)
            ->service('Calendar');
    }

    public function getGoogleRequest($service, $options)
    {
        return $service->calendarList->listCalendarList($options);
    }

    public function syncItem($googleCalendar)
    {

        if ($googleCalendar->deleted) {
            return $this->user->calendars()
                ->where('google_id', $googleCalendar->id)
                ->get()->each->delete();
        }

        $this->user->calendars()->create([
            'google_id' => $googleCalendar->id,
            'name' => $googleCalendar->summary,
            'color' => $googleCalendar->backgroundColor,
            'timezone' => $googleCalendar->timeZone,
        ]);
    }
}
