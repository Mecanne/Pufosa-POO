<?php
    session_start();
    require_once("metodos.php");
    require_once("clases.php");
    $conexion = conectar("pufosa");

    if(isset($_SESSION['empleado'])) header("Location: access.php");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login PUFO S.A.</title>
     <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
    <style>
        *{
            box-sizing: border-box;
        }

        body{
            width: auto;
            height: 95vh;
            background-color: #f2f2f2;
        }

        body div:first-child{
            height: 100%;
            width: auto;
        }

        .login-container{
            display:flex;
            justify-content:center;
            align-items:center;
            flex-direction:column;
        }
    </style>
</head>
<body>
<?php

    //Creamos el login con el metodo crearLogin de la clase WebController
    WebController::crearLogin();

?>
</body>
</html>