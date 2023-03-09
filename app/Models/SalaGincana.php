<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalaGincana extends Model
{
    use HasFactory;

    /**
     * La gincana a la que pertenece esta sala
     */
    public function gincana()
    {
        return $this->belongsTo(Gincana::class);
    }

    /**
     * El creador de una sala
     */
    public function creador()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Los jugadores de una sala
     */
    public function jugadores()
    {
        return $this->belongsToMany(User::class, 'jugador_gincanas', 'sala_gincanas_id');
    }
}
