<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    
    /**
     * Las localizaciones en las que está presente un tag
     */
    public function localizaciones()
    {
        return $this->belongsToMany(Localizacion::class, 'localizacion_tag');
    }
}
