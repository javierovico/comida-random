<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ComidaIngrediente extends Model
{
    protected $table = 'comidas_ingredientes';
    protected $primaryKey = ['comida','ingrediente'];
    public $timestamps = false; //no guardamos la fecha
    protected $guarded = [];    //todx se puede agreagar de forma masiva
    public $incrementing = false;

//    public function comidas(){
//        return $this->belongsTo('App\Comida','id','comida');    //se sobreenteinde que se refiere al id -> comida
//    }
//
//    public function ingredientes(){
//        return $this->hasMany('App\Ingrediente','nombre','ingrediente');    //se sobreenteinde que se refiere al id -> comida
//    }

    /**
     * @return array|mixed
     * Ambos funciones overrides de abajo son para trabajar con dos claves primarias
     */
    protected function getKeyForSaveQuery(){

        $primaryKeyForSaveQuery = array(count($this->primaryKey));

        foreach ($this->primaryKey as $i => $pKey) {
            $primaryKeyForSaveQuery[$i] = isset($this->original[$this->getKeyName()[$i]])
                ? $this->original[$this->getKeyName()[$i]]
                : $this->getAttribute($this->getKeyName()[$i]);
        }

        return $primaryKeyForSaveQuery;

    }

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(Builder $query){

        foreach ($this->primaryKey as $i => $pKey) {
            $query->where($this->getKeyName()[$i], '=', $this->getKeyForSaveQuery()[$i]);
        }

        return $query;
    }

}
