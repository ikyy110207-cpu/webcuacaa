<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\LoginController;

Route::get('/',       [WeatherController::class, 'index'])->name('weather.index');

Route::post('/search',[WeatherController::class, 'search'])->name('weather.search');


