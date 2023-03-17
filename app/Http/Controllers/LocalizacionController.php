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

    /**
     * Encuantra una localizacion de la BDD
     */
    public function find(Request $request)
    {
        $locId = $request->input('locID');

        return Localizacion::with('usuario', 'tags')->find($locId);
    }

    /**
     * Página de localizacions favoritas de un usuario
     */
    public function favoritas()
    {
        if (!Auth::check()) {
            return back();
        }

        $localizacionesFavoritas = auth()->user()->localizacionesGuardadas;

        return view('menu.likes', compact(['localizacionesFavoritas']));
    }

    /**
     * Devolver favoritos de la base de datos en formato JSON para JS
     */
    public function asyncFavoritas()
    {
        if (!Auth::check()) {
            return back();
        }

        $likes = auth()->user()->likes;

        return $likes;
    }
}
