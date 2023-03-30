<?php


use App\Http\Controllers\GoogleController;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
})->middleware('web');


Route::group(['middleware' => 'web'], function() {
    Route::get('/google/auth/callback', [GoogleController::class, 'handleAuthCallback']);
    Route::post('/google/calendar/event', [GoogleController::class, 'store']);
});



