<?php

namespace App\Http\Controllers;

use App\Models\Gincana;
use Illuminate\Http\Request;

class GincanaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $gincana=Gincana::all();

       return view('gynkana', compact(['gincana']));
    }

    public function listar() {


        $gincanas = User::find(1)->gincanas();
        return $gincanas;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gincana  $gincana
     * @return \Illuminate\Http\Response
     */
    public function show(Gincana $gincana)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gincana  $gincana
     * @return \Illuminate\Http\Response
     */
    public function edit(Gincana $gincana)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Gincana  $gincana
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Gincana $gincana)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gincana  $gincana
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gincana $gincana)
    {
        //
    }
}
