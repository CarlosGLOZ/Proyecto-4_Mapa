<?php

namespace App\Http\Controllers;
use App\Models\Localizacion;
use App\Models\PuntoGincana;
use App\Models\User;
use App\Models\Gincana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use MongoDB\Driver\Session;
use PHPUnit\Runner\Exception;
use Psy\Util\Json;
use function PHPUnit\Framework\throwException;

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

       return view('createGymkhana', compact(['gincana']));
    }

    public function index2($gincana){
        $data = json_decode($gincana, true);
        $id = $data['id'];
        $gin= Gincana::with('puntos')->where('id',$id)->first();
        return view('createGymkhana2',compact('gin'));
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

        try {
            try {
                $request->validate([
                    'id' => 'required',
                    'pista' => 'required',
                    'latitud'=>'required',
                    'longitud'=>'required',

                ]);
            }catch (Exception $e){
                return $e->getMessage();
            }

        $pointExist=Localizacion::where('latitud',$request->latitud)->Where('longitud',$request->longitud)->first();
            if ($pointExist){
                $id=$pointExist->id;

            }else{
                $loc=new Localizacion;
                $loc->nombre="PuntoGin";
                $loc->latitud=$request->latitud;
                $loc->longitud=$request->longitud;
                $loc->punto_gincana=1;
                $loc->user_id=1;
                $loc->save();
                $id=$loc->id;
            }
            $gincanaPoint=PuntoGincana::where('posicion',$request->id)->where('gincana_id',$request->ginID)->first();
            if ($gincanaPoint){
                $gincanaPoint->localizacion_id=$id;
                $gincanaPoint->pista=$request->pista;
                $gincanaPoint->save();
            }else{
                $point= new PuntoGincana;
                $point->gincana_id=$request->ginID;
                $point->localizacion_id=$id;
                $point->posicion=$request->id;
                $point->pista= $request->pista;
                $point->save();
            }


            return "hola";
        }catch (Exception $e){
            return "hola2";

        }



    }

    public function deletePista(Request $request){
        $points=explode(',',$request->points);
        PuntoGincana::where('posicion',$request->id)->where('gincana_id',$request->ginID)->delete();
        $points=array_diff($points,(array)$request->id);
        $points = array_values($points);
        foreach ($points as $key => $point){
            if (($point > $key+1) && $point !== $request->id){
                echo "dentroooo";
                $punto=PuntoGincana::where('posicion',$point)->where('gincana_id',$request->ginID)->first();
                if ($punto){
                    $punto->posicion=$key+1;
                    $punto->save();
                }

            }
        }

    }

    public function getLocaFromPoint(Request $request){
        $point=PuntoGincana::with('localizacion')->where('posicion',$request->PointId)->where('gincana_id',$request->ginID)->first();
        if ($point){
            return $point;
        }else{
            return "false";
        }

    }

    public function pointComplete(Request $request){
        $finalPoint=PuntoGincana::where('gincana_id',$request->ginID)->where('posicion',$request->finalPoint)->first();

        if ($finalPoint){
            return true;
        }else{
            return false;
        }
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
