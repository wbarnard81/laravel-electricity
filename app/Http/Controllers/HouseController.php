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

    public function showElectricity(House $house, Request $request)
    {
        $timeFrame = MeterReading::where('meter_id', $house->meters[0]->id)->pluck('created_at');
        $years = [];
        $months = [];
        $currentYear = now()->year;
        $currentMonth = now()->month;

        foreach ($timeFrame as $date) {
            if(!in_array($date->year, $years, true)){
                array_push($years, $date->year);
            }
            if(!in_array($date->month, $months, true)){
                array_push($months, $date->month);
            }
        };

        // dd($request);

        $year = $request->has('year') ? $request['year'] : $currentYear;
        $month = $request->has('month') ? $request['month'] : $currentMonth;

        $house->load(['meters.readings' => function ($query) use ($year, $month) {
            $query->orderBy('created_at', 'desc')->whereYear('created_at', '=', $year)
            ->whereMonth('created_at', '=', $month)
            ->get();
        }]);

        $chartData = [
            'date' => [],
            'units' => []
        ];

        foreach($house->meters[0]->readings as $data){
            if ($data['units_used'] > 0){
                array_push($chartData['date'], date("Y/m/d", strtotime($data['created_at'])));
                array_push($chartData['units'], $data['units_used']);
            }
        }

        return view('houses.electricity', compact('house', 'chartData', 'years', 'months', 'year', 'month'));
    }

    public function showWater(House $house, Request $request)
    {
        $timeFrame = MeterReading::where('meter_id', $house->meters[1]->id)->pluck('created_at');
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

        $chartData = [
            'date' => [],
            'units' => []
        ];

        foreach($house->meters[1]->readings as $data){
            if ($data['units_used'] > 0){
                array_push($chartData['date'], date("Y/m/d", strtotime($data['created_at'])));
                array_push($chartData['units'], $data['units_used']);
            }
        }

        return view('houses.water', compact('house', 'chartData', 'years', 'months'));
    }
}
