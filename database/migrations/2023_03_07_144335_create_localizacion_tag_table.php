<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLocalizacionTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('localizacion_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('localizacion_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->nullable();
            $table->foreignId('tag_id')->constrained()->onDelete('cascade')->onUpdate('cascade')->nullable();
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
        Schema::dropIfExists('localizacion_tag');
    }
}
