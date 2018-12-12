<?php
    session_start();
    require_once("../metodos.php");
    require_once("../clases.php");
    $conexion = conectar("pufosa");
    if(!isset($_SESSION['emp_id'])) header("Location: ../login.php");

    $empleado = mysqli_query($conexion, "select CONCAT(Nombre,' ',Apellido,' ',Inicial_del_segundo_apellido) as Nombre from empleados where empleado_id = '" . $_SESSION['emp_id'] . "'");

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modificar cliente</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> 
</head>
<body>
<?php

    

    //Creamos el contenedor para le modal
    $contenedor = new Caja();
    $contenedor->añadirAtributo("class", "container-fluid");

    //Creamos el formulario para modificar el cliente.
    $formularioModificar = new Formulario("POST", "../operaciones/añadir.php");
    $formularioModificar->añadirAtributo("id", "formularioModificar");

    //Añadimos todos los campos necesarios al formulario

    $campoNombre = new Input("text", "", "nombre", "");
    $campoNombre->añadirAtributo("class", "form-control");
    $campoNombre->añadirAtributo("required", "none");

    $campoDireccion = new Input("text", "", "direccion", "");
    $campoDireccion->añadirAtributo("class", "form-control");
    $campoDireccion->añadirAtributo("required", "none");

    $campoCiudad = new Input("text", "", "ciudad", "");
    $campoCiudad->añadirAtributo("class", "form-control");
    $campoCiudad->añadirAtributo("required", "none");


    $campoEstado = new Input("text", "", "estado", "");
    $campoEstado->añadirAtributo("class", "form-control");
    $campoEstado->añadirAtributo("required", "none");

    $campoCodigoPostal = new Input("number", "", "codigopostal", "0");
    $campoCodigoPostal->añadirAtributo("class", "form-control");

    $campoCodigoDeArea = new Input("number", "", "codigodearea", "0");
    $campoCodigoDeArea->añadirAtributo("class", "form-control");

    $campoTelefono = new Input("number", "", "telefono", "0");
    $campoTelefono->añadirAtributo("class", "form-control");

    $campoVendedor = crearSelectVendedor();

    $campoLimite = new Input("number", "", "limite", "0");
    $campoLimite->añadirAtributo("class", "form-control");

    $campoComentarios = new Textarea("comentarios");
    $campoComentarios->añadirAtributo("class", "form-control");
    

    //Añadimos los campos al formulario

    $formularioModificar->añadirCampo("Nombre", $campoNombre);
    $formularioModificar->añadirCampo("Direccion", $campoDireccion);
    $formularioModificar->añadirCampo("Ciudad", $campoCiudad);
    $formularioModificar->añadirCampo("Estado", $campoEstado);
    $formularioModificar->añadirCampo("Codigo postal", $campoCodigoPostal);
    $formularioModificar->añadirCampo("Codigo de area", $campoCodigoDeArea);
    $formularioModificar->añadirCampo("Telefono", $campoTelefono);
    $formularioModificar->añadirCampo("Vendedor", $campoVendedor);
    $formularioModificar->añadirCampo("Limite de credito", $campoLimite);
    $formularioModificar->añadirCampo("Comentarios", $campoComentarios);

    //Añadimos el formulario al el contenedor del cuerpo del modal.
    $contenedor->añadirContenido($formularioModificar);
?>
</body>
</html>