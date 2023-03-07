<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Localizacion extends Model
{
    use HasFactory;

    /**
     * Las gincanas en las que esta localizacion se utiliza
     */
    public function gincanas()
    {
        return $this->belongsToMany(Gincana::class, 'punto_gincanas');
    }

    /**
     * El usuario al que pertenece esta localizacion
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Los likes que tiene una localizacion
     */
    public function likes()
    {
        return $this->hasMany(LikeLocalizacion::class);
    }

    /**
     * Los tags que tiene una localizacion
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'localizacion_tag');
    }
}
