<?php

namespace App\Services;

use Throwable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Google\Client as Google_Client;
use Illuminate\Support\Facades\Log;
use App\Interfaces\CalendarInterface;
use Illuminate\Support\Facades\Notification;
use App\Notifications\EventCreatedNotification;
use Google\Service\Calendar as Google_Service_Calendar;
use Google\Service\Calendar\Event as Google_Service_Calendar_Event;

class GoogleCalendar implements CalendarInterface
{
    /** @var GoogleClient */
    protected $client;

    const SCOPES = Google_Service_Calendar::CALENDAR_EVENTS;
    const ACCESS_TYPE = 'offline';

    public function __construct()
    {
        $this->client = new Google_Client();
        $this->client->setAuthConfig($this->authConfigJson());
        $this->client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $this->client->addScope(self::SCOPES);
        $this->client->setAccessType(self::ACCESS_TYPE);
        return $this->client;
    }

    /**
     * Get auth json config
     *
     * @return string
     */
    private function authConfigJson()
    {
        return storage_path('app/google-calendar/' . env('GOOGLE_CLIENT_SECRET_PATH'));
    }

    /**
     * Auth with Google
     *
     * @param Request $request
     * @return Redirect
     */
    public function authWithGoogle(Request $request)
    {
        if ($request->has('code')) {
            $this->client->fetchAccessTokenWithAuthCode($request->get('code'));
            $request->session()->put('google_access_token', $this->client->getAccessToken());
            return redirect('/');
        } else {
            return redirect($this->client->createAuthUrl());
        }
    }

    /**
     * Store event in Google calendar
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeEvent(Request $request): \Illuminate\Http\JsonResponse
    {
        $this->client->setAccessToken($request->session()->get('google_access_token'));

        $service = new Google_Service_Calendar($this->client);

        $event = $this->formatRequestToEvent($request);

        try {
            $event = $service->events->insert(env('GOOGLE_FAKE_ACCOUNT'), $event);
        } catch (\Throwable $th) {
            $this->log_exception($th, 'Error occured during saving an event');
            return response()->json(['message' => 'Error occured during saving an event'], 400);
        }

        // this should be in queue implements interface ShouldQueue
        Notification::send($request->email, new EventCreatedNotification($event));

        return response()->json(['message' => 'Event created'], 200);
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
     * Parse request from FE and create Google Service Calendar Event object
     *
     * @param Request $request
     * @return Google_Service_Calendar_Event
     */
    private function formatRequestToEvent(Request $request): Google_Service_Calendar_Event
    {

        $startDateTime = Carbon::parse($request->date . $request->time)->format(\DateTime::RFC3339);
        $endDateTime = Carbon::parse($request->date . $request->time)->addMinutes(30)->format(\DateTime::RFC3339);

        $attende = ['email' => $request->email];

        $event = new Google_Service_Calendar_Event(array(
            'summary' => $request->name,
            'description' => $request->note,
            'start' => array(
                'dateTime' => $startDateTime,
                'timeZone' => 'Europe/Belgrade',
            ),
            'end' => array(
                'dateTime' => $endDateTime,
                'timeZone' => 'Europe/Belgrade',
            ),
            'colorId' => '11',
            'sendUpdates' => true,
            'attendees' => [$attende],
            'attendeesOmitted' => true,
        ));

        return $event;
    }
}
