<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PuntoGincana extends Model
{
    use HasFactory;
    protected $fillable=['id','gincana_id','localizacion_id','localizacion_maps_id'];

    /**
     * La gincana a la que pertenece un punto
     */
    public function gincana()
    {
        return $this->belongsTo(Gincana::class);
    }

    /**
     * La gincana a la que pertenece un punto
     */
    public function localizacion()
    {
        return $this->belongsTo(Localizacion::class);
    }
}
