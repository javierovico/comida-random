<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComidasIngredientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comidas_ingredientes',function (Blueprint $table){
            $table->unsignedInteger('comida');
            $table->string('ingrediente');
            $table->text('cantidad'); //un texto que guarda la cantidad (ya sea litros, kg, tasas, etc
            $table->primary(['comida','ingrediente']);
            $table->foreign('comida')->references('id')->on('comidas');     //si se borra la comida, no se borra el ingrediente
            $table->foreign('ingrediente')->references('nombre')->on('ingredientes')->onDelete('cascade');  //si borramos el ingrediente, se borra la comida
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comidas_ingredientes');
    }
}
