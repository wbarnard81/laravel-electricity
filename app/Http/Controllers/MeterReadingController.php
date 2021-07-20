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
        $data = $request->validate([
            'start_reading' => 'required|numeric'
        ]);

        $data['meter_id'] = $meter->id;
        $data['reading'] = 0;
        $data['previous_reading'] = $request['previous_reading'] ?? 0;
        $data['units_purchased'] = $request['units_purchased'] ?? 0;
        $data['rand_value'] = $request['rand_value'] ?? 0;

        MeterReading::create($data);

        return redirect('/houses/' . $house->id);
    }

    public function store_units_purchased(House $house, Meter $meter, Request $request)
    {
        $data = $request->validate([
            'units_purchased' => 'required|numeric',
            'rand_value' => 'required|numeric'
        ]);

        dd($data);
    }

    
    public function store_reading(House $house, Meter $meter, Request $request)
    {
        $lastRecord = MeterReading::latest()->first();

        $data = $request->validate([
            'reading' => 'required|numeric'
        ]);

        $data['meter_id'] = $meter->id;
        $data['start_reading'] = $request['start_reading'] ?? 0;
        $data['previous_reading'] = $lastRecord->previous_reading;
        $data['units_purchased'] = $request['units_purchased'] ?? 0;
        $data['rand_value'] = $request['rand_value'] ?? 0;

        MeterReading::create($data);
    }
}
