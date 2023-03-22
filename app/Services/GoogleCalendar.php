<?php

namespace App\Services;

use stdClass;
use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Interfaces\CalendarInterface;

class GoogleCalendar implements CalendarInterface
{

    protected $calendar;

    public function __construct()
    {
        $this->calendar = new stdClass();
    }

    /**
     * Get all calendar events
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents(): \Illuminate\Http\JsonResponse
    {
        try {
            $this->calendar->getEventsFromGoogle();
        } catch (\Throwable $th) {
            $this->log_exception($th, 'Error occured during getting events');
            return response()->json(['message' => 'Error occured getting all events'], 400);
        }

        return response()->json(['message' => 'Google calendar'], 200);
    }

    /**
     * Get Google calendar event
     *
     * @param integer $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvent(int $eventId): \Illuminate\Http\JsonResponse
    {
        try {
            //code...
        } catch (\Throwable $th) {
            $this->log_exception($th, 'Error occured during getting event ' . $eventId);
        }

        return response()->json(['message' => 'Get event'], 200);
    }

    /**
     * Store event in Google calendar
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeEvent(Request $request): \Illuminate\Http\JsonResponse
    {

        try {
            //code...
        } catch (\Throwable $th) {
            $this->log_exception($th, 'Error occured during saving an event');
        }

        return response()->json(['message' => 'Store event'], 200);
    }

    /**
     * Update event in Google calendar
     *
     * @param Request $request
     * @param integer $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEvent(Request $request, int $eventId): \Illuminate\Http\JsonResponse
    {
        try {
            //code...
        } catch (\Throwable $th) {
            $this->log_exception($th, 'Error occured during updating event ' . $eventId);
        }

        return response()->json(['message' => 'Update event'], 200);
    }

    /**
     * Delete event from Google calendar
     *
     * @param integer $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEvent(int $eventId): \Illuminate\Http\JsonResponse
    {
        try {
            //code...
        } catch (\Throwable $th) {
            $this->log_exception($th, 'Error occured during deleting event ' . $eventId);
        }

        return response()->json(['message' => 'Delete event'], 200);
    }

    /**
     * Log exception
     *
     * @param Throwable $th
     * @param string $message
     * @return void
     */
    private function log_exception(Throwable $th, string $message): void
    {
        Log::exception($message . $th->getMessage() . ' on line ' . $th->getLine() . ' code ' . $th->getCode());
    }
}
