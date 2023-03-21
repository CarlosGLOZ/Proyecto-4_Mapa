<?php

namespace App\Http\Controllers;

use App\Models\SalaGincana;
use Illuminate\Http\Request;

class SalaGincanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('salasgincanas');
    }
}
