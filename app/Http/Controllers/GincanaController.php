<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Gincana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GincanaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gincana = Gincana::with('autor', 'puntos')->get();
       return view('gynkana', compact(['gincana']));
    }

    public function listar(Request $request) {
        $filtro = $request->input('filtro');
if (!$filtro==''){
    $resu = Gincana::where('nombre', 'like', '%' . $filtro . '%')->get();
    return response()->json($resu);
}else{
//    $resu = Gincana::join('usuario', 'usuario.id', '=', 'gincana.user_id')
//        ->join('punto_gincana', 'punto_gincana.id', '=', 'gincana.punto_gincana_id')
//        ->where('user_id', 2)
//        ->select('usuario.nombre_user', 'punto_gincana.id')
//        ->get();
    $resu = Gincana::with('autor', 'puntos')->where(['user_id' => 2])->get();

    return $resu;
}


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gincana  $gincana
     * @return \Illuminate\Http\Response
     */
    public function show(Gincana $gincana)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gincana  $gincana
     * @return \Illuminate\Http\Response
     */
    public function edit(Gincana $gincana)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gincana  $gincana
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gincana $gincana)
    {
        //
    }

    public function getGincana()
    {
        $restaurantes = Gincana::with(['gincana.autor', 'tags'])->get();
    }
}
