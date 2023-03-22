<?php

namespace App\Interfaces;

use Illuminate\Http\Request;


interface CalendarInterface
{

    public function getEvents();

    public function getEvent(int $eventId);

    public function makeEvent(Request $request);

    public function updateEvent(Request $request, int $eventId);

    public function deleteEvent(int $eventId);
}
