<?php
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");
session_start();

function redirigirConMensaje($mensaje, $error = true) {
    $_SESSION[$error ? 'msjError' : 'msjExito'] = $mensaje;
    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    exit();
}

function insertarLlaveroNFC($codigoNfc, $dbh) {
    $sqlNfc = $dbh->prepare("INSERT INTO llaveros_nfc(codigo, fecha_sys) VALUES (:codigo, now())");
    $sqlNfc->bindParam(":codigo", $codigoNfc);
    if ($sqlNfc->execute()) {
        return $dbh->lastInsertId();
    }
    return false;
}

function insertarHabitacion($dbh, $numHab, $tipoHab, $estadoHab, $sisClimatizacion, $descripcionHab, $estado, $fecha, $hora, $valorTipoCama, $totalCantPersonas, $ultIDNfc) {
    $sql = $dbh->prepare("INSERT INTO habitaciones(nHabitacion, id_hab_tipo, id_hab_estado, id_servicio, id_codigo_nfc, tipoCama, cantidadPersonasHab, observacion, estado, fecha, hora, fecha_update) VALUES (:nHab, :idTipo, :idHabEstado, :tipoServicio, :idNfc, :tipoCama, :cantPersonas, :observacion, :estado, :fecha, :hora, now())");

    // Enlazar los parametros con los valores
    $sql->bindParam(":nHab", $numHab);
    $sql->bindParam(":idTipo", $tipoHab);
    $sql->bindParam(":idHabEstado", $estadoHab);
    $sql->bindParam(":idNfc", $ultIDNfc);
    $sql->bindParam(":tipoServicio", $sisClimatizacion);
    $sql->bindParam(":observacion", $descripcionHab);
    $sql->bindParam(":estado", $estado);
    $sql->bindParam(":fecha", $fecha);
    $sql->bindParam(":hora", $hora);
    $sql->bindParam(":tipoCama", $valorTipoCama);
    $sql->bindParam(":cantPersonas", $totalCantPersonas);

    return $sql->execute() ? $dbh->lastInsertId('habitaciones') : false;
}

function verificarExistencia($numHab, $codigoNfc, $llaveroNfc, $dbh) {
    $consulta = $dbh->prepare("SELECT id_habitacion FROM habitaciones WHERE nHabitacion = :numHab AND estado = 1");
    $consulta->bindParam(":numHab", $numHab);
    $consulta->execute();

    if ($consulta->rowCount() > 0) {
        return "Esta habitación ya existe y está disponible.";
    }

    if (!empty($codigoNfc)) {
        $consultaNfc = $dbh->prepare("SELECT l.codigo FROM habitaciones as h INNER JOIN llaveros_nfc as l ON h.id_codigo_nfc = l.id_codigo_nfc WHERE l.codigo = :codigo AND h.estado = 1");
        $consultaNfc->bindParam(":codigo", $codigoNfc);
        $consultaNfc->execute();

        if ($consultaNfc->rowCount() > 0) {
            return "Este llavero ya está registrado con otra habitación.";
        }
    }
    return false;
}

function calcularCantidadPersonas($tipoCama, $cantTipoSimple, $cantTipoDoble) {
    $valorCampo = "";
    $totalCantPersonas = 0;

    foreach ($tipoCama as $tipo) {
        if ($tipo == "simple") {
            $totalCantPersonas += $cantTipoSimple;
            $valorCampo .= $cantTipoSimple . " simple, ";
        } elseif ($tipo == "doble") {
            $totalCantPersonas += $cantTipoDoble * 2;
            $valorCampo .= $cantTipoDoble . " doble";
        }
    }

    return [rtrim($valorCampo, ', '), $totalCantPersonas];
}

//Validacion
if (empty($_POST['numHabitacion']) || empty($_POST['tipoHab']) || empty($_POST['observaciones']) || empty($_POST['opcionesServ']) || (empty($_POST['cantTipoSimple']) && empty($_POST['cantTipoDoble']))) {
    redirigirConMensaje("Por favor, complete todos los campos del formulario.");
}

try {
    $numHab = $_POST['numHabitacion'];
    $tipoHab = $_POST['tipoHab'];
    $tipoCama = $_POST['tipoCama'];
    $cantTipoSimple = $_POST['cantTipoSimple'];
    $cantTipoDoble = $_POST['cantTipoDoble'];
    $sisClimatizacion = $_POST['sisClimatizacion'];
    $descripcionHab = $_POST['observaciones'];
    $opcionesServ = $_POST['opcionesServ'];
    $codigoNfc = $_POST['codigoNfc'] ?? 0;
    $llaveroNfc = $_POST['regLlavero'];
    $estadoHab = 1;
    $estado = 1;
    $fecha = date("y/m/d");
    $hora = date("G:i:s");

    // Verificar existencia
    $mensajeError = verificarExistencia($numHab, $codigoNfc, $llaveroNfc, $dbh);
    if ($mensajeError) {
        redirigirConMensaje($mensajeError);
    }

    // Insertar llavero NFC si no esta registrado
    $ultIDNfc = insertarLlaveroNFC($llaveroNfc ? $codigoNfc : 0, $dbh);
    if (!$ultIDNfc) {
        redirigirConMensaje("Error en el registro del llavero NFC.");
    }

    // Calcular cantidad de personas
    [$valorTipoCama, $totalCantPersonas] = calcularCantidadPersonas($tipoCama, $cantTipoSimple, $cantTipoDoble);

    // Insertar habitacion
    $ultIDHabitacion = insertarHabitacion($dbh, $numHab, $tipoHab, $estadoHab, $sisClimatizacion, $descripcionHab, $estado, $fecha, $hora, $valorTipoCama, $totalCantPersonas, $ultIDNfc);

    // Insertar servicios de habitacion
    $sql2 = $dbh->prepare("INSERT INTO habitaciones_elementos_selec(id_habitacion, id_hab_elemento, estado, fecha_sys) VALUES (:idHab, :idElemento, :estadoServ, now())");
    $sql2->bindParam(':idHab', $ultIDHabitacion);
    $sql2->bindParam(':estadoServ', $estado);

    $estadoConfirServicios = true;
    foreach ($opcionesServ as $opcion) {
        $sql2->bindParam(':idElemento', $opcion);
        if (!$sql2->execute()) {
            $estadoConfirServicios = false;
            break;
        }
    }

    if ($estadoConfirServicios) {
        redirigirConMensaje("Habitación registrada con éxito", false);
    } else {
        redirigirConMensaje("Error en la asignación de servicios.");
    }

} catch (Exception $e) {
    redirigirConMensaje("Error en el proceso de registro. Contáctanos: hotelroomlyn@gmail.com.");
}

?>