<?php

namespace App\Http\Controllers;

use App\Models\JugadorGincana;
use App\Models\SalaGincana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalaGincanaController extends Controller
{
    /**
     * Pagina de la sala.
     */
    public function view($id)
    {
        $sala = SalaGincana::with('gincana', 'jugadores', 'creador')->find($id);

        return view('sala.view', compact(['sala']));
    }
    
    /**
     * Juego de la sala
     */
    public function jugar($id)
    {
        $sala = SalaGincana::with('gincana', 'creador', 'jugadores')->find($id);

        // Si la sala no está activa o el jugador es parte de ella, redirigirlo al juego
        if (!$sala->activa || !$sala->jugadores->contains('id', auth()->user()->id)) {
            redirect()->route('sala.view');
        }

        return view('sala.jugar', compact(['sala']));
    }

    /**
     * Añadir o eliminar a un jugador de una sala dependiendo de su estado actual
     */
    public function acceso(Request $request, SalaGincana $sala)
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        // Comprobar si el usuario es parte de la sala
        try {
            if ($sala->jugadores->contains('id', auth()->user()->id)) {
                JugadorGincana::where([
                    'user_id' => auth()->user()->id,
                    'sala_gincanas_id' => $sala->id
                ])->first()->delete();
            } else {
                $sala->jugadores()->attach(auth()->user()->id);
            }
        } catch (\Throwable $th) {
            return back();
        }

        return back();
    }

    /**
     * Activar/desactivar la sala
     */
    public function estado(Request $request, SalaGincana $sala)
    {
        if (!Auth::check()) {
            return redirect()->route('home');
        }

        if ($sala->creador->id != auth()->user()->id) {
            return redirect()->route('home');
        }

        if ($sala->activa) {
            $sala->activa = 0;
        } else {
            $sala->activa = 1;
        }

        $sala->save();

        return redirect()->route('sala.view', $sala->id);
    }
}
