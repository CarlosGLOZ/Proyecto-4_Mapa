<?php

namespace App\Http\Controllers;
use App\Models\PuntoGincana;
use App\Models\User;
use App\Models\Gincana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Session;

class GincanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $gincana=Gincana::all();

       return view('gynkana', compact(['gincana']));
    }

    public function listar(Request $request) {
        $filtro = $request->input('filtro');
if (!$filtro==''){
    $resu = Gincana::where('nombre', 'like', '%' . $filtro . '%')->get();
    return response()->json($resu);
}else{
    $resu = Gincana::where('user_id', 2)->get();
    return response()->json($resu);

}


    }

    public function saveGin(Request $request){

        $request->validate([
            'nombre' => 'required|unique:gincanas',
            'descripcion' => 'required',
        ]);
        $gincana= new Gincana;
        $gincana->nombre= $request->nombre;
        $gincana->user_id= 1;
        $gincana->save();
        return $gincana;
    }

    public function savePista(Request $request){

        $request->validate([
            'id' => 'required',
            'content' => 'required',
            'localizacion'=>'required',

        ]);

        $point= new PuntoGincana;
        $point->gincana_id=$request->id;


    }

    public function crearView()
    {
        return view('createGymkhana');
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gincana  $gincana
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gincana $gincana)
    {
        //
    }
}
