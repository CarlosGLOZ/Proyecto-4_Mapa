<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeLocalizacion extends Model
{
    use HasFactory;

    /**
     * La localizacion a la que pertenece un like
     */
    public function localizacion()
    {
        return $this->belongsTo(Localizacion::class);
    }

    /**
     * El usuario que ha creado el like
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
