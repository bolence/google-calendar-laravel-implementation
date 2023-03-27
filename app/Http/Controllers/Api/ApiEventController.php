<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MeetingPostRequest;
use App\Interfaces\CalendarInterface;
use Illuminate\Http\Request;

class ApiEventController extends Controller
{

    /**
     * @var CalendarInterface
     */
    protected $calendar;

    public function __construct(CalendarInterface $calendar)
    {
        $this->calendar = $calendar;
    }
    /**
     * Display all events in calendar
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->calendar->getEvents();
    }

    /**
     * Store a new event to calendar
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->calendar->makeEvent($request);
    }

    /**
     * Display single event in calendar
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return $this->calendar->getEvent($id);
    }

    /**
     * Update event in calendar
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return $this->calendar->updateEvent($request, $id);
    }

    /**
     * Delete event in calendar
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return $this->calendar->deleteEvent($id);
    }
}
