<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingrediente extends Model
{
    //cosas del primary key
    protected $primaryKey = 'nombre';
    public $incrementing = false;
    protected $keyType = 'string';

    public $timestamps = false; //no guardamos la fecha

    protected $guarded = [];

    public function comidas(){
        return $this->hasMany('App\ComidaIngrediente','ingrediente','nombre');    //se sobreenteinde que se refiere al id -> comida
    }
}
