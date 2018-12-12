<?php
session_start();
if (!isset($_SESSION['emp_id'])) header("Location: ../index.php");
require_once("../metodos.php");
$conexion = conectar("pufosa");
    // Recogemos los datos del emppleado que va a realizar la operacion.
$empleado = mysqli_query($conexion, "select CONCAT(Nombre,' ',Apellido,' ',Inicial_del_segundo_apellido) as Nombre from empleados where empleado_id = '" . $_SESSION['emp_id'] . "'");
/**
 * Cada uno de estos ID indica a que tabla quieres añadir datos.
 * En cada opcion, realiza la consulta y si se ejecuta correctamente, te redirige
 * a la pagina correspondiente con la confirmacion de si el dato se ha añadido o no.
 */
if (isset($_POST['nombre'])) {
    $maximo_id = mysqli_query($conexion, "select max(CLIENTE_ID) as max from cliente");
    $maximo_id = mysqli_fetch_array($maximo_id);
    echo $_POST['vendedor'] . "<br>";
    $consulta = "insert into cliente values(" . ($maximo_id['max'] + 1) . "
                                                ,'" . $_POST['nombre'] . "'
                                                ,'" . $_POST['direccion'] . "'
                                                ,'" . $_POST['ciudad'] . "'
                                                ,'" . $_POST['estado'] . "'
                                                ," . $_POST['codigopostal'] . "
                                                ," . $_POST['codigodearea'] . "
                                                ," . $_POST['telefono'] . "
                                                ," . $_POST['vendedor'] . "
                                                ," . $_POST['limite'] . "
                                                ,'" . $_POST['comentarios'] . "')";

    if (mysqli_query($conexion, $consulta) or die("Problemas con la consulta: " . mysqli_error($conexion) . "<br>Consulta: " . $consulta)) {
        escribirEn("../ficheros/log.txt", "El empleado " . mysqli_fetch_array($empleado)['Nombre'] . " ha añadido el cliente \"" . $_REQUEST['nombre'] . "\".");
        header("Location: ../clientes/?añadido=1");

    } else {
        header("Location: ../clientes/?añadido=0");
    }

} else {
    header("Location: ../login.php");
}
mysqli_close($conexion);
?>