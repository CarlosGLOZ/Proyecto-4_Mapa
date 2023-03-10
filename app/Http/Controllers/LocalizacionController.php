<?php

namespace App\Http\Controllers;

use App\Models\Localizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocalizacionController extends Controller
{
    /**
     * Devuelve las localizaciones y sus tags de este usuario
     */
    public function get()
    {
        if (Auth::check()) {
            return Localizacion::with('usuario', 'tags')->where(['user_id' => auth()->user()->id])->get();
        }

        return [];
    }
}
