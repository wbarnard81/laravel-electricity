<?php

namespace App\Http\Controllers;

use App\Models\House;
use App\Models\Meter;
use App\Models\MeterReading;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class HouseController extends Controller
{
    public function create()
    {
        return view('houses.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $slug = '';

        if($request['complex']){
            $slug = $user->id . "_" . Str::of($request['complex'])->slug('_');
        } else {
            $slug = $user->id . "_" . Str::of($request['address'])->slug('_');
        }

        $house = $request->validate([
            'name' => 'required',
            'complex' => 'nullable',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
        ]);

        $slugExist = DB::table('houses')->where('slug', $slug)->get()->toArray();

        if($slugExist) {
            return back()->with('slug', 'Complex name or address already exists.')->withInput();
        }

        $houseID = DB::table('houses')->insertGetId([
            'user_id' => $user->id,
            'slug' => $slug,
            'name' => $house['name'],
            'complex' => $house['complex'] ?? '',
            'address' => $house['address'],
            'city' => $house['city'],
            'province' => $house['province'],
            'postal_code' => $house['postal_code'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Meter::create([
            'house_id' => $houseID,
            'meter_name' => 'Electricity',
            'type' => 'electricity'
        ]);

        Meter::create([
            'house_id' => $houseID,
            'meter_name' => 'Water',
            'type' => 'water'
        ]);

        return redirect('dashboard')->with('successMsg', 'House has been added.');
    }

    public function show($slug)
    {
        $house = House::where('slug', $slug)->with('meters')->with('meterReadings')->firstOrFail();

        $electricityData = [
            'date' => [],
            'units' => []
        ];

        $waterData = [
            'date' => [],
            'units' => []
        ];

        $electricityMeterId = '';
        $waterMeterId = '';

        foreach($house->meters as $meter) {
            if(!$electricityMeterId){
                $electricityMeterId = $meter['id'];
                $eData = MeterReading::where('meter_id', $meter['id'])->get();
                foreach($eData as $data){
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

        return view('houses.show')->with('house', $house)->with('electricityData', $electricityData)->with('waterData', $waterData);
    }
}
