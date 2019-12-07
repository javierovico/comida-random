<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comidas',function (Blueprint $table){
            $table->increments('id')->unique();
            $table->text('nombre');
            $table->text('instrucciones');
            $table->text('thumbnail')->nullable();
            $table->text('fuente')->nullable();
            $table->text('youtube')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comidas');
    }
}
