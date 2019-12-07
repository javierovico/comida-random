<?php
    header('Content-Type: application/json');   //para poder verse como json en firefox
    $urlApi = 'https://www.themealdb.com/api/json/v1/1/';
    $urlComidaRandom = $urlApi.'random.php';
    $arrayRespuesta = array();
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
                    'thumbnail' => 'https://www.themealdb.com/images/ingredients/'.$comidaAleatoria[$ingredienteBusca].'-Small.png'
                );
            }
        }
    }else{
        $arrayRespuesta = array(
            'error' => true,
            'mensaje' => 'no se pudo abrir la url de la api'
        );
    }
    echo json_encode($arrayRespuesta);