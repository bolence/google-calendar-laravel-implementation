<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Interfaces\CalendarInterface;
use stdClass;

class GoogleCalendar implements CalendarInterface
{

    protected $calendar;

    public function __construct()
    {
        $this->calendar = new stdClass();
    }

    public function getEvents()
    {
        try {
            $this->calendar->getEventsFromGoogle();
        } catch (\Throwable $th) {
            info('Error getting events ' . $th->getMessage() . ' on line ' . $th->getLine() . ' code ' . $th->getCode());
            return response()->json(['message' => 'Error occured getting all events'], 400);
        }

        return response()->json(['message' => 'Google calendar'], 200);
    }

    public function getEvent(int $eventId)
    {
    }

    public function makeEvent(Request $request)
    {
    }

    public function updateEvent(Request $request, int $eventId)
    {
    }

    public function deleteEvent(int $eventId)
    {
    }
}
