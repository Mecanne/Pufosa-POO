<?php
    session_start();
    require_once("metodos.php");
    require_once("clases.php");
    $conexion = conectar("pufosa");

    if(isset($_SESSION['emp_id'])) 
    {
        header("Location: clientes/");
    }
    else if(isset($_POST['emp_id']))
    {
        $registros = mysqli_query($conexion,"SELECT * FROM empleados WHERE empleado_ID = '".$_POST['emp_id']."'");
        if($reg = mysqli_fetch_array($registros))
        {
            $_SESSION['emp_id'] = $reg['empleado_ID'];
            header("Location: clientes/");
        }
        else
        {
            header("Location: login.php");
        }
    }
    else
    {
        header("Location: login.php");
    }

    
    
    
?>