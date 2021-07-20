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

        return view('dashboard', compact('houses', $houses));
    }   
}
