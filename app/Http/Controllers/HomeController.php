<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function dashboard()
    {
        $houses = auth()->user()->houses()->get();

        // dd($houses[0]);

        if(count($houses) == 0) {
            return view('houses.create');
        } else {
            return view('dashboard', ['houses' => $houses]);
        }
    }   
}
