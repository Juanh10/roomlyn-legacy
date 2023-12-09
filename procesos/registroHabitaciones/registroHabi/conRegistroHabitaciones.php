<?php
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");
session_start();

// Verificar si se enviaron los datos del formulario
if (!empty($_POST['numHabitacion']) && !empty($_POST['tipoHab']) && !empty($_POST['observaciones']) && !empty($_POST['opcionesServ'])) {

    // Verificar si se proporcionó la cantidad de camas simples o dobles
    if (!empty($_POST['cantTipoSimple']) || !empty($_POST['cantTipoDoble'])) {

        $numHab =  $_POST['numHabitacion'];
        $tipoHab = $_POST['tipoHab'];
        $tipoCama = $_POST['tipoCama'];
        $cantTipoSimple = $_POST['cantTipoSimple'];
        $cantTipoDoble = $_POST['cantTipoDoble'];
        $sisClimatizacion = $_POST['sisClimatizacion'];
        $descripcionHab = $_POST['observaciones'];
        $opcionesServ = $_POST['opcionesServ'];
        $estadoHab = 1; // los diferentes tipos de estados que tiene la habitacion 1: disponible, 2: limpieza, 3: mantenimiento, 4: ocupado
        $estado = 1; // estado si la habitacion esta deshabilitada o no
        $fecha = date("y/m/d");
        $hora = date("G:i:s");

        $existe = false;

        // Verificar si la habitación ya existe
        $consulta = $dbh->prepare("SELECT id_habitacion, nHabitacion, estado FROM habitaciones WHERE nHabitacion = :numHab AND estado = 1");
        $consulta->bindParam(":numHab", $numHab);
        $consulta->execute();
        $fila = $consulta->fetch();

        if ($consulta->rowCount() > 0) {
            $_SESSION['msjError'] = "Esta habitación ya existe y está disponible.";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            $existe = true;
        } else {
            // Preparar la consulta para insertar la nueva habitación
            $sql = $dbh->prepare("INSERT INTO habitaciones(nHabitacion, id_hab_tipo, id_hab_estado, id_servicio, tipoCama, cantidadPersonasHab, observacion, estado, fecha, hora, fecha_update) VALUES (:nHab, :idTipo, :idHabEstado, :tipoServicio, :tipoCama, :cantPersonas, :observacion, :estado, :fecha, :hora, now())");

            // Enlazar los parámetros con los valores
            $sql->bindValue(":nHab", $numHab);
            $sql->bindValue(":idTipo", $tipoHab);
            $sql->bindValue(":idHabEstado", $estadoHab);
            $sql->bindValue(":tipoServicio", $sisClimatizacion, PDO::PARAM_INT);  // Asegura que sea tratado como un entero
            $sql->bindValue(":observacion", $descripcionHab);
            $sql->bindValue(":estado", $estado);
            $sql->bindValue(":fecha", $fecha);
            $sql->bindValue(":hora", $hora);

            $valorCampo = "";
            $cantPersonaSimple = 0;
            $cantPersonaDoble = 0;
            $totalCantPersonas = 0;
            $total1 = 0;
            $total2 = 0;

            // Calcular la cantidad total de personas en la habitación
            foreach ($tipoCama as $tipo) {
                if ($tipo == "simple") {
                    $cantPersonaSimple += 1;
                    $total1 = $cantPersonaSimple * $cantTipoSimple;
                    $valorCampo .= $cantTipoSimple . " " . $tipo . ",";
                } else if ($tipo == "doble") {
                    $cantPersonaDoble += 2;
                    $total2 = $cantPersonaDoble * $cantTipoDoble;
                    $valorCampo .= $cantTipoDoble . " " . $tipo . " ";
                }
                $totalCantPersonas = $total1 + $total2;
            }

            // Enlazar los parámetros adicionales
            $sql->bindParam(":cantPersonas", $totalCantPersonas);

            // Eliminar la coma y el espacio en blanco al final si existen
            $valorTipoCama = rtrim($valorCampo, ', ');
            $sql->bindParam(":tipoCama", $valorTipoCama);

            $estadoConfirServicios = false;

            // Verificar si se ejecutó la consulta de inserción de la habitación
            if (!$existe && $sql->execute()) {

                // Preparar la consulta para insertar los servicios asociados a la habitación
                $sql2 = $dbh->prepare("INSERT INTO habitaciones_elementos_selec(id_habitacion, id_hab_elemento, estado, fecha_sys) VALUES (:idHab, :idElemento, :estadoServ, now())");

                // Obtener el último ID de la habitación insertada
                $ultID = $dbh->lastInsertId('habitaciones');
                $sql2->bindParam(':idHab', $ultID);
                $sql2->bindParam(':estadoServ', $estado);

                foreach ($opcionesServ as $opciones) { // Recorrer todas las opciones de servicios
                    $sql2->bindParam(':idElemento', $opciones);
                    if ($sql2->execute()) { // Ejecutar la consulta
                        $estadoConfirServicios = true;
                    } else {
                        $estadoConfirServicios = false;
                    }
                }

                // Verificar si se ejecutó la consulta de inserción de servicios
                if ($estadoConfirServicios) {
                    $_SESSION['msjExito'] = "Habitación registrada con éxito";
                    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                }
            } else {
                $_SESSION['msjError'] = "Ha habido un error en el proceso de registro. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            }
        }
    } else {
        $_SESSION['msjError'] = "Por favor, complete la información sobre la cantidad de camas.";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
} else {
    $_SESSION['msjError'] = "Por favor, complete todos los campos del formulario.";
    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
}
?>