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
    </style>
</head>
<body>
<?php

    //Contenedor principal.
    $contenedor = new Caja();
    $contenedor->añadirAtributo("class","container-fluid");

    //Creamos el menu.
    $menu = new Menu();
    //Añadimos las clases.
    $menu->añadirAtributo("class","navbar navbar-inverse");
    $menu->añadirAtributo("style","border-radius: 0px;");

    //Creamos el contenedor para dentro del menu.
    $contenedorMenu = new Caja();
    //Le añadimos las clases
    $contenedorMenu->añadirAtributo("class","container-fluid");

    //Creamos el contenedor para la cabecera del menu
    $cabeceraMenu = new Caja();
    //Le añadimos las clases
    $cabeceraMenu->añadirAtributo("class","navbar-header");

    $textoCabecera = new ElementoHTML("p","PUFO S.A.");
    $textoCabecera->añadirAtributo("class","navbar-text");
    $textoCabecera->añadirAtributo("style","font-weight:bold;color:white;");
    $cabeceraMenu->añadirContenido($textoCabecera);
    //Creamos la lista para las opciones del menu sobre las tablas
    $listaTablas = new Lista();
    $listaTablas->añadirAtributo("class","nav navbar-nav");
    $enlaceClientes = new Enlace("Clientes","");
    $enlaceClientes->añadirAtributo("class","active");
    $listaTablas->añadirElemento($enlaceClientes);

    //Creamos la lista para las otras opciones del menu
    $listaOpciones = new Lista();
    $listaOpciones->añadirAtributo("class","nav navbar-nav navbar-right");
    $listaOpciones->añadirElemento(new Enlace("Cerrar sesion","../operaciones/logout.php"));

    $contenedorMenu->añadirContenido($cabeceraMenu);
    $contenedorMenu->añadirContenido($listaTablas);
    $contenedorMenu->añadirContenido($listaOpciones);

    $menu->añadirContenido($contenedorMenu);

    $contenedor->añadirContenido(Cliente::crearTabla());

    echo $menu;
    echo $contenedor;
    

    mysqli_close($conexion);
?>
</body>
</html>