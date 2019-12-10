<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comida extends Model
{
    public $timestamps = false; //no guardamos la fecha
    protected $guarded = [];

    public function ingredientes(){
        return $this->hasMany('App\ComidaIngrediente','comida','id');    //se sobreenteinde que se refiere al id -> comida
    }
}
