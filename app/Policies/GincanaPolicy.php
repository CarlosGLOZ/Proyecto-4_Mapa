<?php

namespace App\Policies;

use App\Models\Gincana;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GincanaPolicy
{
    use HandlesAuthorization;

    /**
     * Si el jugador es autor de la gincana
     */
    public function admin(User $user, Gincana $gincana)
    {
        if ($gincana->autor->id == $user->id) {
            return true;
        }

        return false;
    }
}
