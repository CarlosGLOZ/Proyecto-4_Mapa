<?php

namespace App\Http\Controllers;
use App\Models\Localizacion;
use App\Models\PuntoGincana;
use App\Models\User;
use App\Models\Gincana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use MongoDB\Driver\Session;
use PHPUnit\Runner\Exception;
use Psy\Util\Json;
use function PHPUnit\Framework\throwException;

class GincanaController extends Controller
{
   /**
     * Pagina de gincanas.
     */
    public function lista()
    {
       $gincana=Gincana::all();

       return view('gincana.lista', compact(['gincana']));
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
    public function index()
    {
       $gincana=Gincana::all();

       return view('createGymkhana', compact(['gincana']));
    }

    public function index2(Request $request){
        $gincana = Gincana::with('autor','puntos')->find($request->input('id_gincana'));
        return view('createGymkhana2', compact('gincana'));
    }

    public function saveGin2(Request $request){
        $request->validate([
            'nombre' => 'required',
            'descripcion' => 'required',
        ]);
        
        $id = Gincana::insertGetId([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'user_id' => auth()->user()->id,
        ]);

        $gincana = Gincana::with('autor','puntos')->find($id);
        return view('createGymkhana2', compact('gincana'));
    }

    public function crearView()
    {
        return view('createGymkhana');
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

    public function saveGin(Request $request){
        $validator = Validator::make($request->all(), [
                'nombre' => 'required|unique:gincanas',
                'descripcion' => 'required',
            ]);


            if ($validator && $validator->fails()) {
                return response($validator->errors()->first(), 422);
            }
        $gincana= new Gincana;
        $gincana->nombre= $request->nombre;
        $gincana->descripcion= $request->descripcion;
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
        return "borrado";
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
            return 1;
        }else{
            return 0;
        }
    }

    public function deleteGin(Gincana $gincana){
        $gincana->delete();
        return redirect()->route('home');
    }
}
