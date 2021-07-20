<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Meter;
use App\Models\MeterReading;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function create()
    {
        return view('houses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:houses,name',
            'complex' => 'nullable',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required', 
            'postal_code' => 'required',
        ]);

        $house = auth()->user()->houses()->create($data);

        Meter::create([
            'house_id' => $house->id,
            'meter_name' => 'Electricity',
            'type' => 'electricity'
        ]);

        Meter::create([
            'house_id' => $house->id,
            'meter_name' => 'Water',
            'type' => 'water'
        ]);

        return redirect('dashboard')->with('successMsg', 'House has been added.');
    }

    public function show(House $house, Request $request)
    {
        $timeFrame = MeterReading::pluck('created_at');
        $years = [];
        $months = [];
        foreach ($timeFrame as $date) {
            if(!in_array($date->year, $years, true)){
                array_push($years, $date->year);
            }
            if(!in_array($date->month, $months, true)){
                array_push($months, $date->month);
            }
        };

        $year = $request->has('year') ? $request['year'] : now()->year;
        $month = $request->has('month') ? $request['month'] : now()->month;

        $house->load(['meters.readings' => function ($query) use ($year, $month) {
            $query->orderBy('created_at', 'desc')->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->get();
        }]);

        $electricityData = [
            'date' => [],
            'units' => []
        ];

        $waterData = [
            'date' => [],
            'units' => []
        ];

        $electricityMeterId = '';

        foreach($house->meters as $meter) {
            if(!$electricityMeterId){
                $electricityMeterId = $meter['id'];
                
                foreach($meter->readings as $data){
                    array_push($electricityData['date'], date("Y/m/d", strtotime($data['created_at'])));
                    array_push($electricityData['units'], intval($data['previous_reading']) - intval($data['reading']));
                }
            } else {
                $eData = MeterReading::where('meter_id', $meter['id'])->get();
            
                foreach($eData as $data){
                    array_push($waterData['date'], date("Y/m/d", strtotime($data['created_at'])));
                    array_push($waterData['units'], intval($data['previous_reading']) - intval($data['reading']));
                }
            }
        }

        return view('houses.show', compact('house', 'electricityData', 'waterData', 'years', 'months'));
    }
}
