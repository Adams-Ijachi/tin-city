<?php

use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', AdminDashboardController::class);

Route::get('/view-location/{vehicle}', [\App\Http\Controllers\VehicleController::class, 'index'])
    ->name('view-location.vehicle');
