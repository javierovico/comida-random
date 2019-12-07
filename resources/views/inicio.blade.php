<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Comida aleatoria">
    <meta name="author" content="javierovico@gmail.com">
    <title>Generador de comidas al azar</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta name="theme-color" content="#563d7c">
</head>
<body>
<header>
    <div class="bg-dark collapse" id="navbarHeader" style="">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-md-7 py-4">
                    <h4 class="text-white">Información</h4>
                    <p class="text-muted">
                        Breve página que trata sobre la utilización del API de comidas proporciona por <a href="https://www.themealdb.com/">TheMealDB</a>
                    </p>
                </div>
                <div class="col-sm-4 offset-md-1 py-4">
                    <h4 class="text-white">Contacto</h4>
                    <ul class="list-unstyled">
                        <li><a href="mailto:javierovico@gmail.com" class="text-white">javierovico@gmail.com</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="navbar navbar-dark bg-dark box-shadow">
        <div class="container d-flex justify-content-between">
            <a href="#" class="navbar-brand d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                <strong>Inicio</strong>
            </a>
            <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>
</header>
<main role="main">
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Generador de comidas al azar</h1>
            <p class="lead text-muted">
                Si tenes hambre, tenes mucho tiempo libre y te encontrás aburrido, presioná el botón de abajo y preparate algo que, probablemente, nunca viste :)
            </p>
            <p>
                <a id="botonGenerar" href="#" class="btn btn-primary my-2">¡Generar ya!</a>
            </p>
        </div>
    </section>

    <div class="album bg-light">
        <div id="lugar-comida" class="container">

        </div>
    </div>

</main>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script
        src="https://code.jquery.com/jquery-3.4.1.js"
        integrity="sha256-WpOohJOqMqqyKL9FccASB9O0KwACQJpFTUBLTYOVvVU="
        crossorigin="anonymous"></script>
<script>
    var puta;
    $("#botonGenerar").click(function(){
        $("#lugar-comida").html('');
        $.ajax({url: "intermedio.php", success: function(result){
                puta = result;
                console.log(result);
                var listaIngrediente = '';
                for(var i=0; i<result['ingredientes'].length;i++){
                    var ingrediente = result['ingredientes'][i];
                    listaIngrediente += '' +
                        '<div class="col-sm-3" style="padding-top: 15px;">' +
                        '   <div class="card" style="height: 100%">' +
                        '       <img class="card-img-top" src="'+ingrediente.thumbnail+'" alt="'+ingrediente.thumbnail+'">' +
                        '       <div class="card-body">' +
                        '           <h5 class="card-title">'+ingrediente.nombre +'</h5>' +
                        '           <p class="card-text">'+ingrediente.cantidad+'</p>' +
                        '       </div>' +
                        '   </div>' +
                        '</div>'
                }
                var nuevosValores =
                    '<header class="entry-header">' +
                    '   <h1 class="entry-title">'+result['nombre']+'</h1>' +
                    '</header>' +
                    '<div class="row">' +
                    '   <div class="col-sm-7">' +
                    '       <div class="card bg-light">' +
                    '           <div class="card-header h4">Praparación</div>' +
                    '           <div class="card-body">' +
                    '               <p class="card-text">'+result['instrucciones']+'</p>' +
                    '           </div>' +
                    '       </div>' +
                    '       <h4>Ingredientes</h4>'+
                    '       <div class="container">' +
                    '           <div class="row">' +
                    '              '+listaIngrediente+
                    '           </div>' +
                    '       </div>'+
                    '   </div>' +
                    '   <div class="col-sm-5">' +
                    '       <h4>Resultado:</h4>' +
                    '       <img src="'+result['thumbnail']+'" class="img-thumbnail" alt="Responsive image">' +
                    '       <h4>Video Explicativo</h4>' +
                    '       <div class="embed-responsive embed-responsive-16by9">\n' +
                    '           <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/'+result['youtube']+'"></iframe>' +
                    '       </div>' +
                    '   </div>' +
                    '</div>';
                $("#lugar-comida").html(nuevosValores)
            }});
    });
</script>
</body>
</html>
