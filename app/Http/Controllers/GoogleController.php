<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Google\Client as Google_Client;
use Google\Service\Calendar\EventAttendee as Google_Service_Calendar_EventAttendee;
use Google\Service\Calendar as Google_Service_Calendar;
use Google\Service\Calendar\Event as Google_Service_Calendar_Event;

class GoogleController extends Controller
{
    public function handleAuthCallback(Request $request)
    {

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/' . env('GOOGLE_CLIENT_SECRET_PATH')));
        $client->setRedirectUri(env('GOOGLE_REDIRECT_URI'));
        $client->addScope(Google_Service_Calendar::CALENDAR_EVENTS);
        $client->setAccessType('offline');

        if ($request->has('code')) {
            $client->fetchAccessTokenWithAuthCode($request->get('code'));
            $request->session()->put('google_access_token', $client->getAccessToken());
            return redirect('/');
        } else {
            return redirect($client->createAuthUrl());
        }
    }


    public function createEvent(Request $request)
    {

        $client = new Google_Client();
        $client->setAuthConfig(storage_path('app/google-calendar/' . env('GOOGLE_CLIENT_SECRET_PATH')));
        $client->setAccessType('offline');
        $client->setAccessToken($request->session()->get('google_access_token'));
        $service = new Google_Service_Calendar($client);

        $start = date("Y-m-d\TH:i:sP"); // Now
        $end = date("Y-m-d\TH:i:sP", strtotime("+2 hour"));  // 2 hours later
        $attende = ['email' => 'bosko1979@gmail.com'];

        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'PHP Google Calendar API Test Title',
            'description' => "PHP Google Calendar API Test description1.\nPHP Google Calendar API Test description2.",
            'start' => array(
                'dateTime' => $start,
            ),
            'end' => array(
                'dateTime' => $end,
            ),
            'colorId' => '11',
            'sendUpdates' => true,
            'attendees' => [$attende],
            'attendeesOmitted' => true,
        ));

        $calendarId = 'calendar.gso@gmail.com';

        try {
            $event = $service->events->insert($calendarId, $event);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Event created unsuccessfully!');
        }

        return response()->json(['message' => $event->htmlLink]);
    }
}
