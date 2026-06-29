<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\FarmController;

Route::get('/',       [WeatherController::class, 'index'])->name('weather.index');

Route::post('/search',[WeatherController::class, 'search'])->name('weather.search');

Route::get('/farm',    [FarmController::class, 'index'])->name('farm.index');

Route::post('/farm',   [FarmController::class, 'search'])->name('farm.search');

Route::get('/analisis-tani', [FarmController::class, 'analisis']);