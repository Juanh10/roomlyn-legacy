<?php
include_once "../../config/conex.php";

// Actualizar elemento
if(isset($_POST['btnActElemento'])){
    // Verificar si los campos necesarios no están vacíos
    if (!empty($_POST['idServicio']) && !empty($_POST['servicioAct'])) {
    
        // Obtener valores del formulario
        $idServicio = $_POST['idServicio'];
        $servicioAct = $_POST['servicioAct'];
    
        // Preparar la consulta para actualizar el elemento
        $sql = $dbh->prepare("UPDATE habitaciones_elementos SET elemento = :servicio, fecha_sys = now() WHERE id_hab_elemento = :idServicios");
    
        // Enlazar parámetros
        $sql->bindParam(':servicio', $servicioAct);
        $sql->bindParam(':idServicios', $idServicio);
    
        // Ejecutar la consulta
        if ($sql->execute()) {
            // Redirigir después de la actualización exitosa
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            session_start();
            $_SESSION['msjExito'] = "El elemento ha sido actualizado exitosamente";
        } else {
            // Redirigir con mensaje de error en caso de fallo
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico roomlyn@gmail.com para informarnos sobre este inconveniente.";
        }
    } else {
        // Redirigir si los campos están vacíos
        session_start();
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        $_SESSION['msjError'] = "Por favor, complete todos los campos del formulario.";
    }
}

// Actualizar servicio
if(isset($_POST['btnActServ'])){
    // Verificar si los campos necesarios no están vacíos
    if (!empty($_POST['idServicio']) && !empty($_POST['servicioAct'])) {
    
        // Obtener valores del formulario
        $idServicio = $_POST['idServicio'];
        $servicioAct = $_POST['servicioAct'];
    
        // Preparar la consulta para actualizar el servicio
        $sql = $dbh->prepare("UPDATE habitaciones_servicios SET servicio = :servicio, fecha_sys = now() WHERE id_servicio = :idServicios");
    
        // Enlazar parámetros
        $sql->bindParam(':servicio', $servicioAct);
        $sql->bindParam(':idServicios', $idServicio);
    
        // Ejecutar la consulta
        if ($sql->execute()) {
            // Redirigir después de la actualización exitosa
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            session_start();
            $_SESSION['mensaje'] = "El servicio ha sido actualizado exitosamente";
        } else {
            // Redirigir con mensaje de error en caso de fallo
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico roomlyn@gmail.com para informarnos sobre este inconveniente.";
        }
    } else {
        // Redirigir si los campos están vacíos
        session_start();
        header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
        $_SESSION['msjError'] = "Por favor, complete todos los campos del formulario.";
    }
}
?>