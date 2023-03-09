<?php

namespace App\Http\Controllers;
use App\Models\Gincana;
use Illuminate\Http\Request;

class GincanaController extends Controller
{
    public function showGincanaPlay()
    {
        return view('gincana.GincanaPlay');
    }
}
