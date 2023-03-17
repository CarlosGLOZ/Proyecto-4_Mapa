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
            $resu = Gincana::with('autor', 'puntos')->where(['user_id' => auth()->user()->id])->get();
        } else {
            $resu = Gincana::with('autor', 'puntos')->where('nombre', 'like', $filtro.'%')->get();
        }

        return $resu;
    }


    public function find($id)
    {
        $gincana = Gincana::with('autor', 'salas', 'puntos')->find($id);

        // return 
    }

    /**
     * Esta función parece que no se usa para nada??
     */
    public function getGincana()
    {
        $restaurantes = Gincana::with(['gincana.autor', 'tags'])->get();
    }
}
