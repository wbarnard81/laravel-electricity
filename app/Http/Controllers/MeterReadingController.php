<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Meter;
use App\Models\MeterReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeterReadingController extends Controller
{
    public function store_start_reading(House $house, Meter $meter, Request $request)
    {
        dd('store_start_reading');

        // MeterReading::create($data);
    }

    public function store_units_purchased(House $house, Meter $meter, Request $request)
    {
        dd('store_units_purchased');

        // MeterReading::create($data);
    }

    public function store_reading(House $house, Meter $meter, Request $request)
    {
        dd('store_reading');

        // MeterReading::create($data);
    }
}
