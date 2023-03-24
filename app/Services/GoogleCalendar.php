<?php

namespace App\Services;

use Throwable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\GoogleCalendar\Event as GoogleServiceCalendar;
use Illuminate\Support\Facades\Log;
use App\Interfaces\CalendarInterface;

class GoogleCalendar implements CalendarInterface
{

    protected $calendar;

    public function __construct()
    {
        $this->calendar = new GoogleServiceCalendar;
    }

    /**
     * Get all calendar events
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents(): \Illuminate\Http\JsonResponse
    {
        try {
            $events = $this->calendar->get();
        } catch (\Throwable $th) {
            $this->log_exception($th, 'Error occured during getting events');
            return response()->json(['message' => 'Error occured getting all events'], 400);
        }

        return response()->json(['events' => $events[0]], 200);
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
            $event = $this->calendar->find($eventId);
        } catch (\Throwable $th) {
            $this->log_exception($th, 'Error occured during getting event ' . $eventId);
        }

        return response()->json(['event' => $event], 200);
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
            $this->formatRequest($request);
            $this->calendar->save('insertEvent');
        } catch (\Throwable $th) {
            $this->log_exception($th, 'Error occured during saving an event');
            return response()->json(['message' => 'Error occured during saving an event'], 400);
        }

        return response()->json(['message' => 'Event created'], 200);
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
            $this->calendar->update($request->all());
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
            $this->calendar->delete($eventId);
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
        Log::info('Errors ' . json_encode($th->getMessage()));
        Log::error($message . ' ' . $th->getMessage() . ' on line ' . $th->getLine() . ' code ' . $th->getCode());
    }

    /**
     * Parse request from FE
     *
     * @param Request $request
     * @return GoogleServiceCalendar $this
     */
    private function formatRequest(Request $request): GoogleServiceCalendar
    {
        $startDateTime = Carbon::createFromTimestamp($request->date . $request->time);

        $this->calendar->name = $request->name;
        $this->calendar->startDateTime = $startDateTime;
        $this->calendar->endDateTime = $startDateTime->addHour();
        $this->calendar->description = $request->note;
        $this->calendar->addAttendee(['email' => $request->email]);

        return $this->calendar;
    }
}
