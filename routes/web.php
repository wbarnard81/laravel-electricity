<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HouseController;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\MeterReadingController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        $houses = DB::table('houses')->where('user_id', auth()->user()->id)->get();
        return view('dashboard', compact('houses', $houses));
    })->name('dashboard');

    //Routes for houses
    Route::get('/houses/create', [HouseController::class, 'create']);
    Route::post('/houses/store', [HouseController::class, 'store']);
    Route::get('/houses/show/{slug}', [HouseController::class, 'show']);
    Route::post('/meter/store', [MeterController::class, 'store']);
    Route::post('/meter/reading/{id}', [MeterReadingController::class, 'store']);
});



require __DIR__.'/auth.php';
