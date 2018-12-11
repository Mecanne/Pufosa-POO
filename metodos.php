<?php

 function conectar($database)
 {
     $conexion = mysqli_connect("localhost","root","",$database);
     return $conexion;
 }

 /**
  * Consulta que define a la tabla base.
  *
  * @param [String] $tabla 
  * @return String
  */
 function getConsultaTabla($tabla)
 {
    switch($tabla)
    {
        case 'clientes':
            return "SELECT
                        CLIENTE_ID,
                        cliente.nombre,
                        Direccion,
                        Ciudad,
                        Estado,
                        CodigoPostal,
                        CodigoDeArea,
                        Telefono,
                        CONCAT(empleados.Nombre,' ',Apellido,' ',Inicial_del_segundo_apellido) AS Vendedor,
                        Limite_De_Credito,
                        Comentarios
                    FROM cliente
                    INNER JOIN empleados
                        ON empleado_ID = vendedor_ID
                    ORDER BY cliente.nombre ASC";
            break;
    }
 }

 /**
  * Devuelve un array con los nombres para la cabecera de cada tabla.
  *
  * @param [String] $tabla
  * @return Array
  */
 function getCabeceraTabla($tabla)
 {
    switch($tabla)
    {
        case 'clientes':
            return ["Nombre","Direccion","Ciudad","Estado","Codigo postal","Codigo de area","Telefono","Vendedor","Limite de credito","Comentarios","Opciones"];
            break;
        default:
            return null;
    }
 }

 function crearLogin()
 {
     // Creamos el contenedor de toda la pagina excepto el menu y le asignamos la clase 'container-fluid' para que haga efecto BOOTSTRAP (Version 3)
    $contenedor = new Caja();
    $contenedor->añadirAtributo("class","container-fluid");
    $contenedorFormulario = new Caja();
    $contenedorFormulario->añadirAtributo("class","container-fluid login-container");

    
    // Creamos el formulario que recogerá el id del empleado.
    $formulario = new Formulario("post","access.php");
    $formulario->añadirAtributo("class","form");
    $formulario->añadirAtributo("style","width:400px;padding:40px;");

    //Creamos los campos del formulario
    $inputID = new Input("text","","emp_id");
    $inputID->añadirAtributo("class","form-control");

    $submitInput = new Input("submit","","","Acceder");
    $submitInput->añadirAtributo("class","btn btn-primary form-control");
    //Añadimos los campos al formulario
    $formulario->añadirCampo("ID del empleado",$inputID);
    $formulario->añadirCampo("",$submitInput);

    //Creamos le objeto Imagen que ocntendrá la imagen del logo de la empresa.
    $imgLogo = new Imagen("img/logo.png","Logo de la empresa");

    //Añadimos la imagen al contenedor secudario.
    $contenedorFormulario->añadirContenido($imgLogo);
    //Añadimos el formulario.
    $contenedorFormulario->añadirContenido($formulario);

    //Añadimos el contenedor secundario al principal.
    $contenedor->añadirContenido($contenedorFormulario);

    echo $contenedor;
 }
 
?>