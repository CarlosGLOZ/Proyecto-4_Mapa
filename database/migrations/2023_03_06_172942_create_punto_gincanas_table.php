<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuntoGincanasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('punto_gincanas', function (Blueprint $table) {
            $table->id();
            $table->integer('posicion', false, true);
            $table->foreignId('gincana_id')->constrained()->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('localizacion_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->string('localizacion_maps_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('punto_gincanas');
    }
}
