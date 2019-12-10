<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'MiControlador@index');

Route::get('/comida/aleatorio','ControladorComida@aleatorio');
Route::get('/comida/aleatorio-externo','ControladorComida@aleatorioExterno');
Route::apiResource('/comida','ControladorComida');

Route::get('/prueba', function(){
    $comidaNueva = \App\Comida::create([
        'nombre'=> 'pera de agua',
        'instrucciones'=>'herbir'
    ]);
    $ret = $comidaNueva->save() . '<br>';
    $comidaNueva = new \App\Comida([
        'nombre' => 'bori bori22',
        'instrucciones'=> 'cocinar despacio'
    ]);
    $comidaNueva->save();

    $comidaNueva = new \App\Comida();
    $comidaNueva->nombre = ' peeerro';
    $comidaNueva->instrucciones = 'cocinar antes que muera';
    $comidaNueva->save();

    $comidas = App\Comida::all();
    foreach ($comidas as $comida){
        $ret = $ret . $comida->nombre;
//        $comida->delete();
    }
    return $ret;
});


Route::get('/prueba2', function(){
    $ret = '';
    $ingredienteNuevo = new \App\Ingrediente([
        'nombre' => 'peperoni'
    ]);
    $ingredienteNuevo->save();

    $ingredientes = App\Ingrediente::all();
    foreach ($ingredientes as $ingrediente){
        $ret = $ret . $ingrediente->nombre;
    }
    return $ret;
});
