<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class HouseController extends Controller
{
    public function create()
    {
        return view('houses.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $tableName = '';

        if($request['complex']){
            $tableName = $user->id . "_" . Str::of($request['complex'])->slug('_');
        } else {
            $tableName = $user->id . "_" . Str::of($request['address'])->slug('_');
        }
        
        // if(!Schema::hasTable($tableName)){
        //     Schema::connection('mysql')->create($tableName, function($table)
        //     {
        //         $table->increments('id');
        //         $table->foreignId('user_id');
        //         $table->string('name');
        //         $table->string('complex');
        //         $table->string('address');
        //         $table->string('city');
        //         $table->string('province');
        //         $table->string('postal_code');
        //         $table->timestamps();
        //     });
        // }

        $house = $request->validate([
            'name' => 'required|unique:houses',
            'complex' => 'nullable',
            'address' => 'required',
            'city' => 'required',
            'province' => 'required',
            'postal_code' => 'required',
        ]);

        DB::table('houses')->insert([
            'user_id' => $user->id,
            'slug' => $tableName,
            'name' => $house['name'],
            'complex' => $house['complex'] ?? '',
            'address' => $house['address'],
            'city' => $house['city'],
            'province' => $house['province'],
            'postal_code' => $house['postal_code'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // DB::table('user_houses')->insert([
        //     'user_id' => $user->id,
        //     'house_id' => $houseID,
        //     'house_table_name' => $tableName,
        //     'created_at' => now(),
        //     'updated_at' => now(),
        // ]);

        return redirect('dashboard')->with('successMsg', 'House has been added.');
    }

    public function show($id)
    {
        $user = Auth::user();
        $tableName = DB::table('user_houses')->where('user_id', $user->id)->pluck('house_table_name');

        dd($id);
    }
}
