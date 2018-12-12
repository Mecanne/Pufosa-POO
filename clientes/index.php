<?php
    session_start();
    require_once("../metodos.php");
    require_once("../clases.php");
    $conexion = conectar("pufosa");
    if(!isset($_SESSION['empleado'])) header("Location: ../login.php");

    $empleado = $_SESSION['empleado'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Clientes</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <style>
        *{
            box-sizing:border-box;
        }

        form{
            margin: 0px 10px 0px 0px;
        }
    </style>
</head>
<body>
<?php

    //Contenedor principal.
    $contenedor = new Caja();
    $contenedor->añadirAtributo("class","container-fluid");

    //Creamos el boton que mostrará el cuestionario para añadir un cliente.
    $botonAñadir = new Boton("Añadir cliente");
    $botonAñadir->añadirAtributo("class","btn btn-info btn-block");
    $botonAñadir->añadirAtributo("data-toggle","modal");
    $botonAñadir->añadirAtributo("data-target","#añadir");

    //Creamos el contenedor del boton
    $contenedorBoton = new Caja($botonAñadir);
    $contenedorBoton->añadirAtributo("class","container");

    //Creamos el input para poder buscar en la tabla
    $buscador = new Input("text","myInput","","");
    $buscador->añadirAtributo("class","form-control");
    $buscador->añadirAtributo("placeholder","Buscar...");

    //Creamos le contendor del input para buscar
    $contenedorBuscar = new Caja();
    $contenedorBuscar->añadirAtributo("class","container");

    //Añadimos el buscador a su respectiva caja
    $contenedorBuscar->añadirContenido($buscador);

    //Añadimos el boton y la tabla de clientes al contenedor principal.
    $contenedor->añadirContenido($contenedorBoton);
    $contenedor->añadirContenido("<hr>");
    $contenedor->añadirContenido($contenedorBuscar);
    $contenedor->añadirContenido("<hr>");
    $contenedor->añadirContenido(Cliente::crearTabla());

    //Imprimimos el menu y el contenedor    
    echo WebController::imprimirMenu();
    echo Cliente::añadirModal();
    echo $contenedor;
    

    mysqli_close($conexion);
?>
<script>
    $(document).ready(function(){
        $("#myInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
                $("#tablaDatos tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script> 
</body>
</html>