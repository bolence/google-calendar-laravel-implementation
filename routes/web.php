<?php


use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});


Route::get('/google/auth/callback', [GoogleController::class, 'handleAuthCallback']);
Route::get('/google/calendar/event', [GoogleController::class, 'createEvent']);
