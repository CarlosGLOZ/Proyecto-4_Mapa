<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gincana extends Model
{
    use HasFactory;

    protected $fillable=['id','nombre','user_id','created_at','updated_at'];

    /**
     * El autor de la gincana
     */
    public function autor()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Los puntos de una gincana
     */
    public function puntos()
    {
        return $this->hasMany(PuntoGincana::class);
    }

    /**
     * Las salas abiertas de una gincana
     */
    public function salas()
    {
        return $this->hasMany(SalaGincana::class);
    }
}
