<?php

use App\Http\Controllers\Api\ApiMeetingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::resource('meetings', ApiMeetingController::class);
