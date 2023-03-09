<?php

namespace App\Http\Controllers;

use App\Models\Localizacion;
use Illuminate\Http\Request;

class LocalizacionController extends Controller
{
    /**
     * Devuelve las localizaciones y sus creadores
     */
    public function get()
    {
        return Localizacion::with('usuario', 'tags')->get();
    }
}
