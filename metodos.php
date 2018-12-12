<?php

function conectar($base){
    $conexion = mysqli_connect("localhost","root","",$base) or
        die("Problemas de conexión");
    return $conexion;
}

/**
 * Escribe un mensaje en el archivo especificao en la ruta.
 * @param String $ruta Ruta del archivo a escribir
 * param {Mensaje a escribir en la ruta} $mensaje
*/
function escribirEn($ruta,$mensaje){
    $fichero = fopen($ruta,"a");
    fputs($fichero,date("Y-m-d H:i:s")." : ".$mensaje);
    fputs($fichero,"\n");
    fclose($fichero);
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

 
 
?>