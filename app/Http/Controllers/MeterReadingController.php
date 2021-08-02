<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Meter;
use App\Models\MeterReading;
use Illuminate\Http\Request;

class MeterReadingController extends Controller
{
    public function get_all_readings()
    {
        $allReadings = [];
        dd('sdfsdf');
    }

    public function store_start_reading(House $house, Meter $meter, Request $request)
    {
        $data = $request->validate([
            'start_reading' => 'required|numeric'
        ]);

        $data['meter_id'] = $meter->id;
        $data['reading'] = 0;
        $data['previous_reading'] = $data['start_reading'];
        $data['units_purchased'] = 0;
        $data['rand_value'] = 0;
        $data['units_used'] = 0;

        $created = MeterReading::create($data);

        return redirect('/houses/' . $house->id . '/' . $created->meter->type);
    }

    public function store_units_purchased(House $house, Meter $meter, Request $request)
    {
        $lastRecord = MeterReading::where('meter_id', $meter->id)->latest()->first();

        $data = $request->validate([
            'units_purchased' => 'required|numeric',
            'rand_value' => 'required|numeric'
        ]);
        
        $data['units_used'] = 0;
        $data['previous_reading'] = $lastRecord->reading > 0 ? $lastRecord->reading : $lastRecord->start_reading;
        $data['meter_id'] = $meter->id;
        $data['start_reading'] = 0;
        $data['reading'] = 0;

        MeterReading::create($data);
        
        return redirect('/houses/' . $house->id . '/' . $lastRecord->meter->type);
    }

    
    public function store_reading(House $house, Meter $meter, Request $request)
    {
        $lastRecord = MeterReading::where('meter_id', $meter->id)->latest()->first();

        $data = $request->validate([
            'reading' => 'required|numeric'
        ]);

        if ($lastRecord->units_purchased > 0) {
            $data['previous_reading'] = $lastRecord->previous_reading + $lastRecord->units_purchased;
            $data['units_used'] = $data['previous_reading'] - $data['reading'];
        } else {
            $data['previous_reading'] = $lastRecord->reading > 0 ? $lastRecord->reading : $lastRecord->start_reading;
            $data['units_used'] = $data['previous_reading'] - $data['reading'];
        }

        $data['meter_id'] = $meter->id;
        $data['start_reading'] = $request['start_reading'] ?? 0;
        $data['units_purchased'] = $request['units_purchased'] ?? 0;
        $data['rand_value'] = $request['rand_value'] ?? 0;

        MeterReading::create($data);

        return redirect('/houses/' . $house->id . '/' . $lastRecord->meter->type);
    }
}
