<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\MeterReadingController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    //Route for Dashboard
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    //Routes for houses
    Route::get('/houses/create', [HouseController::class, 'create']);
    Route::post('/houses', [HouseController::class, 'store']);
    Route::get('/houses/{house}', [HouseController::class, 'show']);
    
    //Routes for readings
    // Route::post('/meter/reading/{id}', [MeterReadingController::class, 'store']);
    Route::post('/houses/{house}/meters/{meter}/readings/start_reading', [MeterReadingController::class, 'store_start_reading']);
    Route::post('/houses/{house}/meters/{meter}/readings/units_purchased', [MeterReadingController::class, 'store_units_purchased']);
    Route::post('/houses/{house}/meters/{meter}/readings/reading', [MeterReadingController::class, 'store_reading']);
});



require __DIR__.'/auth.php';
