<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JugadorGincana extends Model
{
    use HasFactory;

    /**
     * La sala en la que está un jugador
     */
    public function sala()
    {
        return $this->belongsTo(SalaGincana::class, 'sala_gincanas_id');
    }

    /**
     * El usuario que es este jugador
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
