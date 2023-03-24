<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Gincana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GincanaController extends Controller
{
   /**
     * Pagina de gincanas.
     */
    public function index()
    {
        // $gincanas = Gincana::with('autor', 'puntos')->get();
        return view('gincana.lista');
    }

    /**
     * Devolver lista de gincanas según un filtro
     */
    public function fitrar(Request $request) {
        $filtro = $request->input('filtro');
        $propias = $request->input('propias');

        if ($propias == 'true') {
            $resu = Gincana::with('autor', 'puntos')->where(['user_id' => auth()->user()->id])->where('nombre', 'like', $filtro.'%')->get();
        } else {
            $resu = Gincana::with('autor', 'puntos')->where('nombre', 'like', $filtro.'%')->get();
        }

        return $resu;
    }

    /**
     * Devolver pagina de gincana con los datos de la gincana
     */
    public function view($id)
    {
        $gincana = Gincana::with('autor', 'salas.creador', 'puntos.localizacion')->find($id);

        return view('gincana.view', compact(['gincana']));
    }

    /**
     * Devolver los datos de una gincana
     */
    public function find($id)
    {
       return Gincana::with('autor', 'puntos.localizacion', 'salas')->find($id);
    }
}
