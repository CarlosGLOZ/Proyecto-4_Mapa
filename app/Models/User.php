<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Las gincanas que ha creado este usuario
     */
    public function gincanas()
    {
        return $this->hasMany(Gincana::class);
    }

    /**
     * Las gincanas que este usuario ha guardado en favoritos
     */
    public function localizacionesGuardadas()
    {
        return $this->belongsToMany(Localizacion::class, 'like_localizacions');
    }

    /**
     * Los likes que este usuario a dado. No confundir con "localizacionesGuardadas()". 
     * "localizacionesGuardadas()" devuelve las localizaciones en si,
     * "likes()" devuelve los registros de la tabla de likes.
     * Esto se hace así porque, si el usuario le ha dado like a una localizacion
     * del maps, no la va a encontrar en la BDD, así que tenemos que pillar el ID
     * y recogerla con eso
     */
    public function likes()
    {
        return $this->hasMany(LikeLocalizacion::class);
    }

    /**
     * La sala que está hosteando este usuario
     */
    public function sala()
    {
        return $this->hasOne(SalaGincana::class);
    }
}
