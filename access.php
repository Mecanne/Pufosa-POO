<?php
    session_start();
    require_once("metodos.php");
    require_once("clases.php");
    $conexion = conectar("pufosa");

    if(isset($_SESSION['empleado'])) 
    {
        header("Location: clientes/");
    }
    else if(isset($_POST['emp_id']))
    {
        $registros = mysqli_query($conexion,"SELECT * FROM empleados WHERE empleado_ID = '".$_POST['emp_id']."'");
        if($reg = mysqli_fetch_array($registros))
        {
            $empleado = new Empleado(
                $reg['empleado_ID'],
                $reg['Nombre'],
                $reg['Apellido'],
                $reg['Inicial_del_segundo_apellido'],
                $reg['Trabajo_ID'],
                $reg['Jefe_ID'],
                $reg['Fecha_contrato'],
                $reg['Salario'],
                $reg['Comision'],
                $reg['Departamento_ID']
            );
            $_SESSION['empleado'] = $empleado;
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