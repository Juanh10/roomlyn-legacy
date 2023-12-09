<?php
session_start();
include_once "../../config/conex.php";

// Registrar Servicio
if(isset($_POST['registrarServicio'])){
    // Verificar si el campo del servicio no está vacío
    if(!empty($_POST['servicio'])){
        // Obtener el valor del servicio desde el formulario
        $servicio = $_POST['servicio'];
    
        // Preparar la consulta para insertar el servicio en la base de datos
        $sql = $dbh -> prepare("INSERT INTO habitaciones_servicios(servicio, fecha_sys) VALUES (:elemento, now())");
    
        // Enlazar el parámetro
        $sql -> bindParam(':elemento', $servicio);
    
        // Ejecutar la consulta
        if($sql -> execute()){
            // Redirigir después de la inserción exitosa
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            $_SESSION['mensaje'] = "Servicio registrado con éxito";
        } else {
            // Redirigir con mensaje de error en caso de fallo
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        }
    } else {
        // Redirigir si el campo está vacío
        header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
        $_SESSION['mensaje'] = "Campos vacíos. Por favor, llena todos los campos.";
    }
}

// Registrar Elemento
if(isset($_POST['registrarElemento'])){
    // Verificar si el campo del elemento no está vacío
    if(!empty($_POST['elemento'])){
        // Obtener el valor del elemento desde el formulario
        $elemento = $_POST['elemento'];
    
        // Preparar la consulta para insertar el elemento en la base de datos
        $sql = $dbh -> prepare("INSERT INTO habitaciones_elementos(elemento, fecha_sys) VALUES (:elemento, now())");
    
        // Enlazar el parámetro
        $sql -> bindParam(':elemento', $elemento);
    
        // Ejecutar la consulta
        if($sql -> execute()){
            // Redirigir después de la inserción exitosa
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            $_SESSION['msjExito'] = "Elemento registrado con éxito";
        } else {
            // Redirigir con mensaje de error en caso de fallo
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        }
    } else {
        // Redirigir si el campo está vacío
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        $_SESSION['msjError'] = "Campos vacíos. Por favor, llena todos los campos.";
    }
}
?>