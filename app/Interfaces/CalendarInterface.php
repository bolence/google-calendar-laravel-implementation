<?php

namespace App\Interfaces;

use Illuminate\Http\Request;


interface CalendarInterface
{
    /**
     * Get calendar events
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function getEvents(): \Illuminate\Http\JsonResponse;

    /**
     * Get calendar event
     *
     * @param integer $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    // public function getEvent(int $eventId): \Illuminate\Http\JsonResponse;

    /**
     * Make an calendar event
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeEvent(Request $request): \Illuminate\Http\JsonResponse;

    /**
     * Update an calendar event
     *
     * @param Request $request
     * @param integer $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    // public function updateEvent(Request $request, int $eventId): \Illuminate\Http\JsonResponse;

    /**
     * Delete an calendar event
     *
     * @param integer $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    // public function deleteEvent(int $eventId): \Illuminate\Http\JsonResponse;
}
