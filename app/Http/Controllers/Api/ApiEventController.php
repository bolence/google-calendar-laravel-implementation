<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingPostRequest;
use App\Services\GoogleCalendar;
use Illuminate\Http\Request;

class ApiEventController extends Controller
{

    protected $googleCalendar;

    public function __construct(GoogleCalendar $googleCalendar)
    {
        $this->googleCalendar = $googleCalendar;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->googleCalendar->getEvents();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MeetingPostRequest $request)
    {
        return $this->googleCalendar->makeEvent($request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->googleCalendar->getEvent($id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->googleCalendar->updateEvent($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->googleCalendar->deleteEvent($id);
    }
}
