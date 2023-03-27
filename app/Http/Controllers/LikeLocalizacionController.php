<?php

namespace App\Http\Controllers;

use App\Models\LikeLocalizacion;
use App\Models\Localizacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeLocalizacionController extends Controller
{
    /**
     * Devuelve si el usuario logueado ha dado a like a una localizacion dada
     */
    public function isLiked(Request $request)
    {
        if (!Auth::check()) {
            return false;
        }

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

    /**
     * Eliminar un like
     */
    public function destroy(Request $request)
    {
        $locId = $request->input('id_localizacion'); // El ID de la localizacion
        $tipo = $request->input('tipo_localizacion'); // El tipo de localizacion que es (BDD o Google Maps)

        if ($tipo == 'BDD') {
            // Eliminar la localizacion y, por cascade, su like
            $localizacion = Localizacion::find($locId);

            $result = $localizacion->delete();

        } elseif ($tipo == 'Google Maps') {

            $like = LikeLocalizacion::where([
                'user_id' => auth()->user()->id,
                'localizacion_maps_id' => $locId
            ]);

            $result = $like->delete();
        }

        if ($result) {
            return ['status' => 'OK'];
        } else {
            return ['status' => 'NOT OK'];
        }
    }

    /**
     * Guardar un like
     */
    public function store(Request $request)
    {
        $tipo = $request->input('tipo_localizacion'); // El tipo de localizacion que es (BDD o Google Maps)
        
        if ($tipo == 'BDD') {
            $locId = $request->input('id_localizacion'); // El ID de la localizacion
            $localizacion = Localizacion::find($locId);
            
            $result = $localizacion->likes()->create([
                'user_id' => auth()->user()->id,
            ]);
            
        } elseif ($tipo == 'Google Maps') {
            $locId = $request->input('id_localizacion'); // El ID de la localizacion

            $result = LikeLocalizacion::create([
                'user_id' => auth()->user()->id,
                'localizacion_maps_id' => $locId
            ]);
        } elseif ($tipo == 'NUEVO') {
            $result = Localizacion::create([
                'nombre' => $request->input('nombre'),
                'descripcion' => $request->input('descripcion'),
                'latitud' => $request->input('latitud'),
                'longitud' => $request->input('longitud'),
                'user_id' => auth()->user()->id,
                'punto_gincana' => 0
            ])->likes()->create([
                'user_id' => auth()->user()->id,
            ]);
        }

        if ($result) {
            return ['status' => 'OK'];
        } else {
            return ['status' => 'NOT OK'];
        }
    }
}
