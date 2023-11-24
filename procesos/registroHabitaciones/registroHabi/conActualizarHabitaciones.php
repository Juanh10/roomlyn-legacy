<?php

include_once "../../config/conex.php";
session_start();


if (isset($_POST['btnActualizar'])) {
    if (!empty($_POST['numHabitacion']) && !empty($_POST['tipoHab']) && !empty($_POST['observaciones']) && !empty($_POST['idHab'])) { // Comparar si los datos no estan vacios


        if (!empty($_POST['cantTipoSimple']) || !empty($_POST['cantTipoDoble'])) {

            // Capturar todos los datos enviados del formulario
            $idHabitacion = $_POST['idHab'];
            $numHab = $_POST['numHabitacion'];
            $tipoHab = $_POST['tipoHab'];
            $tipoCama = $_POST['tipoCama'];
            $cantTipoSimple = $_POST['cantTipoSimple'];
            $cantTipoDoble = $_POST['cantTipoDoble'];
            $sisClimatizacion = $_POST['sisClimatizacion'];
            $observ = $_POST['observaciones'];

            $existe = false;

            $consulta = $dbh->prepare("SELECT id_habitacion, nHabitacion FROM habitaciones WHERE id_habitacion = :idHab"); // consulta sql
            $consulta->bindParam(":idHab", $idHabitacion); // enlazar el marcador con la variable
            $consulta->execute(); // ejecutar la consulta

            if ($datos = $consulta->fetch()) { // obtener datos de la consulta
                if ($datos['nHabitacion'] != $numHab) {
                    $consulta2 = $dbh->prepare("SELECT id_habitacion, nHabitacion, estado FROM habitaciones WHERE nHabitacion = :numHab");
                    $consulta2->bindParam(":numHab", $numHab);
                    $consulta2->execute();

                    $filas = $consulta2->fetch();

                    if ($consulta2->rowCount() > 0 && $filas['estado'] === 1) {
                        $_SESSION['msjError'] = "Error: El número de habitación ya ha sido registrado anteriormente.";
                        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                        $existe = true;
                    } else {
                        if (!$existe) {
                            actualizarHabitacion($sql, $dbh, $idHabitacion, $numHab, $tipoHab, $tipoCama, $cantTipoSimple, $cantTipoDoble,   $sisClimatizacion, $observ);
                        }
                    }
                } else {
                    actualizarHabitacion($sql, $dbh, $idHabitacion, $numHab, $tipoHab, $tipoCama, $cantTipoSimple, $cantTipoDoble,   $sisClimatizacion, $observ);
                }
            }
        } else {
            $_SESSION['msjError'] = "Por favor, completa la información sobre la cantidad de camas.";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        }
    } else {
        $_SESSION['msjError'] = "Por favor, completa todos los campos.";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
}


if (isset($_POST['actualizarEstado'])) {
    if (!empty($_POST['opcion']) && !empty($_POST['idHab'])) {
        $opcion = $_POST['opcion'];
        $idHabitacion = $_POST['idHab'];
        $archivo = $_POST['archivo'];

        $sql = $dbh->prepare("UPDATE habitaciones SET id_hab_estado=:idEstado, fecha_update=now() WHERE id_habitacion = :idHab");
        $sql->bindParam(":idEstado", $opcion);
        $sql->bindParam(":idHab", $idHabitacion);

        if ($sql->execute()) {
            $_SESSION['msjExito'] = "¡Se ha cambiado el estado exitosamente!";
            header("location: ../../../vistas/vistasAdmin/" . $archivo . ".php");
        } else {
            $_SESSION['msjError'] = "Ha habido un error al intentar cambiar el estado. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
            header("location: ../../../vistas/vistasAdmin/" . $archivo . ".php");
        }
    } else {
        $_SESSION['msjError'] = "Por favor, completa todos los campos.";
        header("location: ../../../vistas/vistasAdmin/" . $archivo . ".php");
    }
}


function actualizarHabitacion($sql, $dbh, $idHabitacion, $numHab, $tipoHab, $tipoCama, $cantTipoSimple, $cantTipoDoble, $sisClimatizacion, $observ)
{

    $sql = $dbh->prepare("UPDATE habitaciones SET nHabitacion= :nHab, id_hab_tipo= :idTipo, id_servicio=:tipoServ, observacion=:observacion, tipoCama=:tipoCama, cantidadPersonasHab=:cantPersonas, fecha_update=now() WHERE id_habitacion = :id");


    $sql->bindParam(":id", $idHabitacion);
    $sql->bindParam(":nHab", $numHab);
    $sql->bindParam(":idTipo", $tipoHab);
    $sql->bindParam(":tipoServ", $sisClimatizacion);
    $sql->bindParam(":observacion", $observ);

    $valorCampo = "";
    $cantPersonaSimple = 0;
    $cantPersonaDoble = 0;
    $totalCantPersonas = 0;
    $total1 = 0;
    $total2 = 0;

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

    $sql->bindParam(":cantPersonas", $totalCantPersonas);

    // funcion "rtrim" Elimina la coma y el espacio en blanco al final si existen
    $valorTipoCama = rtrim($valorCampo, ', ');


    $sql->bindParam(":tipoCama", $valorTipoCama);

    if ($sql->execute()) {
        $_SESSION['msjExito'] = "¡La habitación se ha actualizado exitosamente!";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    } else {
        $_SESSION['msjError'] = "Ha habido un error al intentar actualizar los datos. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
}
