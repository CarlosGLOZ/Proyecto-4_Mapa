<?php

namespace App\Policies;

use App\Models\SalaGincana;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Auth;

class SalaPolicy
{
    use HandlesAuthorization;

    /**
     * Si el usuario es jugador de una gincana
     */
    public function jugador(User $user, SalaGincana $sala)
    {
        foreach ($sala->jugadores as $jugador) {
            if ($jugador->id == $user->id) {
                return true;
            }
        }

        return false;
    }

    /**
     * Si el jugador es creador de la sala
     */
    public function admin(User $user, SalaGincana $sala)
    {
        if ($sala->creador->id == $user->id) {
            return true;
        }

        return false;
    }
}
