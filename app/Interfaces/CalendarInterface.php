<?php

namespace App\Interfaces;

use Illuminate\Http\Request;


interface CalendarInterface
{
    /**
     * Undocumented function
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvents(): \Illuminate\Http\JsonResponse;

    /**
     * Undocumented function
     *
     * @param integer $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEvent(int $eventId): \Illuminate\Http\JsonResponse;

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function makeEvent(Request $request): \Illuminate\Http\JsonResponse;

    /**
     * Undocumented function
     *
     * @param Request $request
     * @param integer $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateEvent(Request $request, int $eventId): \Illuminate\Http\JsonResponse;

    /**
     * Undocumented function
     *
     * @param integer $eventId
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteEvent(int $eventId): \Illuminate\Http\JsonResponse;
}
