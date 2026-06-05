<?php

use App\Http\Controllers\SensorReadingController;
use Illuminate\Support\Facades\Route;

Route::get('/sensor/latest', [SensorReadingController::class, 'latest'])->name('api.sensor.latest');
