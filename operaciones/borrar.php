<?php
session_start();
if (!isset($_SESSION['empleado'])) header("Location: ../login.php");
$borrado = 1; // Variable que establece si se ha podido borrar o no un dato, por defecto será 1, es decir, se interpreta como se borra. 
require_once("../metodos.php");
require_once("../clases.php");
$conexion = conectar("pufosa"); // Establecemos conexion
    // Recogemos los datos del empleado que va a realizar la operacion.
$empleado = mysqli_query($conexion, "select CONCAT(Nombre,' ',Apellido,' ',Inicial_del_segundo_apellido) as Nombre from empleados where empleado_id = '" . $_SESSION['emp_id'] . "'");
    // En cualquier operacion, si no se puede realizar la operacion, en vez de mostrar un mesanje, se cambiará el valor de la varible $borrado a 0, es decir, no se ha borrado el dato.
if (isset($_POST['CLIENTE_ID'])) {
    $cliente = mysqli_query($conexion, "select Nombre from cliente where CLIENTE_ID = '" . $_REQUEST['CLIENTE_ID'] . "'");
    mysqli_query($conexion, "delete from cliente where CLIENTE_ID ='" . $_REQUEST['CLIENTE_ID'] . "'") or $borrado = 0;
    mysqli_close($conexion);
    escribirEn("../ficheros/log.txt", "El empleado " . mysqli_fetch_array($empleado)['Nombre'] . " ha borrado el cliente \"" . mysqli_fetch_array($cliente)['Nombre'] . "\".");
    header("Location: ../clientes/?borrado=" . $borrado);
} else {
    header("Location: ../index.php");
}
?>