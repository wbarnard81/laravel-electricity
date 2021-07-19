<?php

namespace App\Http\Controllers;

use App\Models\MeterReading;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MeterReadingController extends Controller
{
    public function store(Request $request, $id)
    {
        $lastReading = MeterReading::where('meter_id', $id)->orderBy('created_at', 'desc')->first();

        $validatedData = $request->validate([
            'meter_id'.$id => 'nullable|numeric',
            'start_reading'.$id => 'nullable|numeric',
            'previous_reading'.$id => 'nullable|numeric',
            'units_purchased'.$id => 'nullable|numeric',
            'rand_value'.$id => 'nullable|numeric',
            'reading'.$id => 'nullable|numeric',
        ]);

        dd($validatedData);

        $data = [
            'meter_id' => $id,
            'start_reading' => $lastReading['start_reading'] > 0 ? $lastReading['start_reading'] : '0',
            'previous_reading' => $lastReading['previous_reading'] > 0 ? $lastReading['previous_reading'] : '0',
            'units_purchased' => $lastReading['units_purchased'] > 0 ? $lastReading['units_purchased'] : '0',
            'rand_value' => $lastReading['rand_value'] > 0 ? $lastReading['rand_value'] : '0',
            'reading' => $lastReading['reading'] > 0 ? $lastReading['reading'] : '0',
        ];

        Validator::make($data, [
            'meter_id' => 'required|numeric',
            'start_reading' => 'required|numeric',
            'previous_reading' => 'required|numeric',
            'units_purchased' => 'required|numeric',
            'rand_value' => 'required|numeric',
            'reading' => 'required|numeric',
        ]);

        MeterReading::create($data);


    }
}
