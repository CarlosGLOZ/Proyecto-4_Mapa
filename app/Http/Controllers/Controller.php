<?php

namespace App\Http\Controllers;

use App\Models\Gincana;
use App\Models\JugadorGincana;
use App\Models\Localizacion;
use App\Models\SalaGincana;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {

    }
}
