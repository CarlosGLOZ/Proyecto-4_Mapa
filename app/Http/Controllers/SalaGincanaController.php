<?php

namespace App\Http\Controllers;

use App\Models\SalaGincana;
use Illuminate\Http\Request;

class SalaGincanaController extends Controller
{
    /**
     * Pagina de la sala.
     */
    public function view($id)
    {
        $sala = SalaGincana::with('gincana', 'jugadores', 'creador')->find($id);

        return view('sala.view', compact(['sala']));
    }
}
