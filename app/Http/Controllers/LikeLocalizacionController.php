<?php

namespace App\Http\Controllers;

use App\Models\LikeLocalizacion;
use Illuminate\Http\Request;

class LikeLocalizacionController extends Controller
{
    /**
     * Devuelve si el usuario logueado ha dado a like a una localizacion dada
     */
    public function isLiked(Request $request)
    {
        $locId = $request->input('localizacion_id'); // El ID de la localizacion
        $tipo = $request->input('tipo_localizacion'); // El tipo de localizacion que es (BDD o Google Maps)

        if ($tipo == 'BDD') {
            $like = LikeLocalizacion::where([
                'localizacion_id' => $locId,
                'user_id' => auth()->user()->id,
            ])->first();

            if ($like == null) {
                return false;
            }

            return true;
        } elseif ($tipo == 'Google Maps') {
            $like = LikeLocalizacion::where([
                'localizacion_maps_id' => $locId,
                'user_id' => auth()->user()->id,
            ])->first();

            if ($like == null) {
                return false;
            }

            return true;
        }
    }
}
