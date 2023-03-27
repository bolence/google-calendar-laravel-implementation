<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiEventController;

Route::resource('events', ApiEventController::class);

Route::get('/google/auth/callback', [GoogleCalendarController::class, 'handleAuthCallback']);
