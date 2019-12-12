<?php

namespace App\Http\Controllers;

use App\Comida;
use App\ComidaIngrediente;
use App\Ingrediente;
use Exception;
use Illuminate\Http\Request;

class ControladorComida extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comida::all();
    }

    public function aleatorio($idAleatorio = null){
        try{
            $comida = $idAleatorio==null?Comida::all()->random():Comida::find($idAleatorio);
            foreach($comida->comidaIngredientes as $comidaIngrediente){
                $comidaIngrediente->ingredientes;   //refesca cada ingrediente de la comida ingrediente (para obtener el thumbnail)
            }
            return $comida;
        } catch (Exception $e){
            return ['error'=>true,'mensaje'=>$e->getMessage()];
        }
    }

    /**
     * @return mixed
     * Optiene una comida del api externa, lo guarda en la base de datos local, y lo envia
     * Eventualmente, si la comida ya estaba guardada, no actualiza los valores
     * Eventualmente, si el ingrediente ya estaba en la base, no se actualizan valores
     */
    public function aleatorioExterno(){
        $respuestaApiExterna = $this::optenerNuevaRespuesta();
        if($respuestaApiExterna['error'] == true){
            return ['error' => true, 'mensaje'=>'error con la api externa proveida'];
        }else{
            try{
                //Trata de encontrar en la base de datos local una comida con el mismo id retornado por la API externa
                $comidaNueva = Comida::find($respuestaApiExterna['id']);
                if($comidaNueva == null){   //todavia no existe en la base de datos local
                    $comidaNueva = new Comida([
                        'id' => $respuestaApiExterna['id'],
                        'nombre' => $respuestaApiExterna['nombre'],
                        'instrucciones'  => $respuestaApiExterna['instrucciones'],
                        'thumbnail'  => $respuestaApiExterna['thumbnail'],
                        'fuente'  => $respuestaApiExterna['fuente'],
                        'youtube'  => $respuestaApiExterna['youtube'],
                    ]);
                    $comidaNueva->save();       //se crea nuevo en la BD
                    foreach($respuestaApiExterna['ingredientes'] as $ingredienteArray){ //se itera los ingredientes
                        $ingrediente = Ingrediente::find($ingredienteArray['nombre']);  //busca el ingrediente en la BD
                        if($ingrediente == null){   //si todavia no existia el ingrediente
                            $ingrediente = new Ingrediente([
                                'nombre' => $ingredienteArray['nombre'],
                                'thumbnail_grande' => $ingredienteArray['thumbnail_grande'],
                                'thumbnail_pequenho' => $ingredienteArray['thumbnail_pequenho'],
                            ]);
                            $ingrediente->save();   //se crea nuevo ingrediente
                        }
                        //agregar a ingrediente x comida
                        $comidaIngrediente = new ComidaIngrediente([
                            'comida' => $comidaNueva->id,
                            'ingrediente' =>$ingrediente->nombre,
                            'cantidad' => $ingredienteArray['cantidad'],
                        ]);
                        $comidaIngrediente->save(); //se gaurda
                    }
                }
                return $this->aleatorio($comidaNueva->id);
            }catch (Exception $e){
                return ['error'=>true, 'mensaje'=>$e->getMessage()];
            }
        }
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
     * @param  \App\Comida  $comida
     * @return \Illuminate\Http\Response
     */
    public function show(Comida $comida)
    {
        return $comida;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Comida  $comida
     * @return \Illuminate\Http\Response
     */
    public function edit(Comida $comida)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Comida  $comida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comida $comida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Comida  $comida
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comida $comida)
    {
        //
    }


    /**
     * @return array
     * Solo se encarga de cambiar el formato del json proveido por la API externa
     */
    function optenerNuevaRespuesta(){
        $urlApi = 'https://www.themealdb.com/api/json/v1/1/';
        $urlComidaRandom = $urlApi.'random.php';
        $file = @fopen($urlComidaRandom, 'r');
        if($file){
            $stringJson = '';
            while(!feof($file)) {
                $stringJson .= @fgets($file, 4096);
            }
            fclose ($file);
            $comidaAleatoria = json_decode($stringJson,true)['meals'][0];
            $arrayRespuesta = array(
                'error' => false,
                'id' => $comidaAleatoria['idMeal'],
                'nombre' => $comidaAleatoria['strMeal'],
                'instrucciones' => $comidaAleatoria['strInstructions'],
                'thumbnail' => $comidaAleatoria['strMealThumb'],
                'fuente' => (array_key_exists('strSource',$comidaAleatoria))?$comidaAleatoria['strSource']:"",
                'youtube' => substr($comidaAleatoria['strYoutube'],32)
            );
            for($i=1;$i<=20;$i++){  //el api siempre devuelve 20 valores de ingredientes (algunos vacios)
                $ingredienteBusca = 'strIngredient'.$i;
                $cantidadBusca = 'strMeasure'.$i;
                if(array_key_exists($ingredienteBusca, $comidaAleatoria) && !empty($comidaAleatoria[$ingredienteBusca])){ //tiene que existir y no estar vacio
                    $arrayRespuesta['ingredientes'][] = array(
                        'nombre'    => $comidaAleatoria[$ingredienteBusca],
                        'cantidad'  => $comidaAleatoria[$cantidadBusca],
                        'thumbnail_pequenho' => 'https://www.themealdb.com/images/ingredients/'.$comidaAleatoria[$ingredienteBusca].'-Small.png',
                        'thumbnail_grande' => 'https://www.themealdb.com/images/ingredients/'.$comidaAleatoria[$ingredienteBusca].'.png'
                    );
                }
            }
        }else{
            $arrayRespuesta = array(
                'error' => true,
                'mensaje' => 'no se pudo abrir la url de la api'
            );
        }
        return $arrayRespuesta;
    }
}
