<?php

namespace App\Http\Controllers;
use App\Models\Gincana;
use Illuminate\Http\Request;

class GincanaController extends Controller
{
    public function showGincanaPlay($id)
    {
        return view('gincana.GincanaPlay', compact(['id']));
    }

    public function find($id)
    {
       return Gincana::with('autor', 'puntos', 'salas')->find($id);
    }

}
