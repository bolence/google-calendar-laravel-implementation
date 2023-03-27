<?php

namespace App\Services;

use Throwable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Google\Client as Google_Client;
use Google\Service\Calendar\Event as Google_Service_Calendar_Event;
use Google\Service\Calendar as Google_Service_Calendar;
use Illuminate\Support\Facades\Log;
use App\Interfaces\CalendarInterface;

class GoogleCalendar implements CalendarInterface
{
    /**
     * @var GoogleServiceCalendar
     */
    protected $calendar;

    public function __construct()
    {
        // $this->calendar = new GoogleServiceCalendar;
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

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/' . env('GOOGLE_CLIENT_SECRET_PATH')));
        $client->setAccessType('offline');
        $client->setAccessToken($request->session()->get('google_access_token'));
        $service = new Google_Service_Calendar($client);

        $event = new Google_Service_Calendar_Event([
            'summary' => $request->input('name'),
            'description' => $request->input('description'),
            'start' => [
                'dateTime' => $request->input('start_time'),
                'timeZone' => 'America/Los_Angeles',
            ],
            'end' => [
                'dateTime' => $request->input('end_time'),
                'timeZone' => 'America/Los_Angeles',
            ],
            'attendees' => array(
                array('email' => 'lpage@example.com'),
                array('email' => 'sbrin@example.com'),
            ),
        ]);

        $calendarId = 'calendar.gso@gmail.com';

        try {
            $event = $service->events->insert($calendarId, $event);
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
            //.... code
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
        Log::error($message . ' ' . $th->getMessage() . ' on line ' . $th->getLine() . ' with status code ' . $th->getCode() . ' in file ' . $th->getFile());
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
        $this->calendar->endDateTime = $startDateTime->addMinutes(30);
        $this->calendar->description = $request->note;
        $this->calendar->addAttendee(['email' => $request->email]);

        return $this->calendar;
    }
}
