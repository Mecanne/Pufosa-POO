<?php
require_once("clases.php");

function conectar($base)
{
    $conexion = mysqli_connect("localhost", "root", "", $base) or
        die("Problemas de conexión");
    return $conexion;
}

/**
 * Escribe un mensaje en el archivo especificao en la ruta.
 * @param String $ruta Ruta del archivo a escribir.
 * @param String $mensaje Mensaje a escribir en el archivo.
 */
function escribirEn($ruta, $mensaje)
{
    $fichero = fopen($ruta, "a");
    fputs($fichero, date("Y-m-d H:i:s") . " : " . $mensaje);
    fputs($fichero, "\n");
    fclose($fichero);
}

function getNombreEmpleado($id)
{
    $conexion = conectar("pufosa");

    $registros = "SELECT CONCAT(Nombre,' ',Apellido,' ',Inicial_del_segundo_apellido) AS Nombre 
                    FROM empleados 
                    WHERE empleado_id = '" . $_SESSION['emp_id'] . "'";
}

/**
 * Consulta que define a la tabla base.
 *
 * @param [String] $tabla 
 * @return String
 */
function getConsultaTabla($tabla)
{
    switch ($tabla) {
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
    switch ($tabla) {
        case 'clientes':
            return ["Nombre", "Direccion", "Ciudad", "Estado", "Codigo postal", "Codigo de area", "Telefono", "Vendedor", "Limite de credito", "Comentarios", "Opciones"];
            break;
        default:
            return null;
    }
}

function crearSelectVendedor()
{
    $conexion = conectar("pufosa");
    $registros = mysqli_query($conexion, "SELECT CONCAT(Nombre, ' ', Apellido,' ', Inicial_del_segundo_apellido) AS Nombre,empleado_ID
                                            FROM empleados
                                            WHERE Trabajo_ID = '670'")
        or die("Problemas con el select:" . mysqli_error($conexion));

    $select = new Select("vendedor");
    $select->añadirAtributo("class", "form-control");
    while ($reg = mysqli_fetch_array($registros)) {
        $select->añadirOpcion(new Option($reg['Nombre'], $reg['empleado_ID']));
    }
    return $select;
    mysqli_close($conexion);
}

?>