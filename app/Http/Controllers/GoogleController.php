<?php

namespace App\Http\Controllers;

use App\Http\Requests\MeetingPostRequest;
use App\Interfaces\CalendarInterface;
use Illuminate\Http\Request;

class GoogleController extends Controller
{

    /**
     * Class constructor
     *
     * @param CalendarInterface $googleCalendar
     */
    public function __construct(protected CalendarInterface $googleCalendar)
    {

    }

    /**
     * Handle callback from Google Auth
     *
     * @param Request $request
     * @return Redirect
     */
    public function handleAuthCallback(Request $request)
    {
        return $this->googleCalendar->authWithGoogle($request);
    }

    /**
     * Make an Google event
     *
     * @param MeetingPostRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(MeetingPostRequest $request)
    {
        return $this->googleCalendar->makeEvent($request);
    }
}
