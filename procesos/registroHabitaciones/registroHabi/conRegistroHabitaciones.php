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
        $codigoNfc = $_POST['codigoNfc'];
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

        // verificar si el codigo ya está registrado a alguna habitacion
        $consultaNfc = $dbh->prepare("SELECT h.id_habitacion, h.id_hab_estado, h.id_hab_tipo, h.id_codigo_nfc, h.nHabitacion, l.id_codigo_nfc, l.codigo FROM habitaciones as h INNER JOIN llaveros_nfc as l ON h.id_codigo_nfc = l.id_codigo_nfc WHERE h.estado = 1 AND l.codigo = :codigo");
        $consultaNfc->bindParam(":codigo", $codigoNfc);
        $consultaNfc->execute();
        $fila = $consultaNfc->fetch();

        if ($consulta->rowCount() > 0) {
            $_SESSION['msjError'] = "Esta habitación ya existe y está disponible.";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            $existe = true;
        } else {
            if ($consultaNfc->rowCount() > 0) {
                $numeroHab = $fila['nHabitacion'];
                $_SESSION['msjError'] = "Este llavero ya está registrado con la habitación " . $numeroHab;
                header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                $existe = true;
            } else {

                $sqlNfc = $dbh->prepare("INSERT INTO llaveros_nfc(codigo, fecha_sys) VALUES (:codigo, now())");
                $sqlNfc->bindParam(":codigo", $codigoNfc);

                if ($sqlNfc->execute()) {

                    $ultIDNfc = $dbh->lastInsertId();

                    echo $ultIDNfc;

                    // Preparar la consulta para insertar la nueva habitación
                    $sql = $dbh->prepare("INSERT INTO habitaciones(nHabitacion, id_hab_tipo, id_hab_estado, id_servicio, id_codigo_nfc, tipoCama, cantidadPersonasHab, observacion, estado, fecha, hora, fecha_update) VALUES (:nHab, :idTipo, :idHabEstado, :tipoServicio, :idNfc, :tipoCama, :cantPersonas, :observacion, :estado, :fecha, :hora, now())");

                    // Enlazar los parámetros con los valores
                    $sql->bindParam(":nHab", $numHab);
                    $sql->bindParam(":idTipo", $tipoHab);
                    $sql->bindParam(":idHabEstado", $estadoHab);
                    $sql->bindParam(":idNfc", $ultIDNfc);
                    $sql->bindParam(":tipoServicio", $sisClimatizacion);
                    $sql->bindParam(":observacion", $descripcionHab);
                    $sql->bindParam(":estado", $estado);
                    $sql->bindParam(":fecha", $fecha);
                    $sql->bindParam(":hora", $hora);

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
                } else {
                    $_SESSION['msjError'] = "Ha habido un error en el proceso de registro. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                }
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
