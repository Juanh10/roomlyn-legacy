<?php
include_once "../../config/conex.php";
session_start();

// Verificar si se presionó el botón de actualizar
if (isset($_POST['btnActualizar'])) {
    // Verificar que los campos necesarios no estén vacíos
    if (!empty($_POST['numHabitacion']) && !empty($_POST['tipoHab']) && !empty($_POST['observaciones']) && !empty($_POST['idHab'])) {
        // Comparar si la cantidad de camas simples o dobles no está vacía
        if (!empty($_POST['cantTipoSimple']) || !empty($_POST['cantTipoDoble'])) {
            // Capturar los datos del formulario
            $idHabitacion = $_POST['idHab'];
            $numHab = $_POST['numHabitacion'];
            $tipoHab = $_POST['tipoHab'];
            $tipoCama = $_POST['tipoCama'];
            $cantTipoSimple = $_POST['cantTipoSimple'];
            $cantTipoDoble = $_POST['cantTipoDoble'];
            $sisClimatizacion = $_POST['sisClimatizacion'];
            $observ = $_POST['observaciones'];

            $existe = false;

            // Verificar si el número de habitación ya está registrado
            $consulta = $dbh->prepare("SELECT id_habitacion, nHabitacion FROM habitaciones WHERE id_habitacion = :idHab");
            $consulta->bindParam(":idHab", $idHabitacion);
            $consulta->execute();

            if ($datos = $consulta->fetch()) {
                if ($datos['nHabitacion'] != $numHab) {
                    // Verificar si el nuevo número de habitación ya está registrado
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
                            // Llamar a la función para actualizar la habitación
                            actualizarHabitacion($sql, $dbh, $idHabitacion, $numHab, $tipoHab, $tipoCama, $cantTipoSimple, $cantTipoDoble, $sisClimatizacion, $observ);
                        }
                    }
                } else {
                    // Llamar a la función para actualizar la habitación
                    actualizarHabitacion($sql, $dbh, $idHabitacion, $numHab, $tipoHab, $tipoCama, $cantTipoSimple, $cantTipoDoble, $sisClimatizacion, $observ);
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

// Verificar si se presionó el botón de actualizar estado
if (isset($_POST['actualizarEstado'])) {
    // Verificar que los campos necesarios no estén vacíos
    if (!empty($_POST['opcion']) && !empty($_POST['idHab'])) {
        $opcion = $_POST['opcion'];
        $idHabitacion = $_POST['idHab'];
        $archivo = $_POST['archivo'];

        // Preparar la consulta para actualizar el estado de la habitación
        $sql = $dbh->prepare("UPDATE habitaciones SET id_hab_estado=:idEstado, fecha_update=now() WHERE id_habitacion = :idHab");
        $sql->bindParam(":idEstado", $opcion);
        $sql->bindParam(":idHab", $idHabitacion);

        // Ejecutar la consulta de actualización de estado
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

//Condicion para saber si el input codigoNfc está vacio
if (!empty($_GET['codigoNfc'])) {

    header('Content-Type: application/json');

    $idHab = $_GET['idHab'];
    $codigoEditNfc = $_GET['codigoNfc'];

    $consultaNfc = $dbh->prepare("SELECT l.codigo FROM habitaciones as h INNER JOIN llaveros_nfc as l ON h.id_codigo_nfc = l.id_codigo_nfc WHERE l.codigo = :codigo AND h.estado = 1");
    $consultaNfc->bindParam(":codigo", $codigoEditNfc);
    $consultaNfc->execute();

    if ($consultaNfc->rowCount() > 0) {
        echo json_encode(['status' => 'error', 'message' => 'El llavero ya está asociado con una habitación.']);
    } else {
        // Preparar la consulta para insertar el nuevo registro
        $sqlLlaveroNfc = $dbh->prepare('INSERT INTO llaveros_nfc(codigo, fecha_sys) VALUES (:cod, now())');
        $sqlLlaveroNfc->bindParam(':cod', $codigoEditNfc);

        //Ejecutar la consulta
        if ($sqlLlaveroNfc->execute()) {
            $lastId = $dbh->lastInsertId();
        }

        $sqlAsociar = $dbh->prepare('UPDATE habitaciones SET id_codigo_nfc = :idLlavero WHERE id_habitacion = :idHab');
        $sqlAsociar->bindParam(':idLlavero', $lastId);
        $sqlAsociar->bindParam(':idHab', $idHab);

        if ($sqlAsociar->execute()) {
            echo json_encode(['status' => 'success', 'message' => 'El llavero NFC se ha asociado correctamente a la habitación.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Ha habido un error al intentar asociar el llavero con la habitación.']);
        }
    }
}

// Función para actualizar la habitación en la base de datos
function actualizarHabitacion($sql, $dbh, $idHabitacion, $numHab, $tipoHab, $tipoCama, $cantTipoSimple, $cantTipoDoble, $sisClimatizacion, $observ)
{
    // Preparar la consulta para actualizar la habitación
    $sql = $dbh->prepare("UPDATE habitaciones SET nHabitacion= :nHab, id_hab_tipo= :idTipo, id_servicio=:tipoServ, observacion=:observacion, tipoCama=:tipoCama, cantidadPersonasHab=:cantPersonas, fecha_update=now() WHERE id_habitacion = :id");

    // Enlazar los parámetros con los valores
    $sql->bindParam(":id", $idHabitacion);
    $sql->bindParam(":nHab", $numHab);
    $sql->bindParam(":idTipo", $tipoHab);
    $sql->bindParam(":tipoServ", $sisClimatizacion);
    $sql->bindParam(":observacion", $observ);

    // Inicializar variables
    $valorCampo = "";
    $cantPersonaSimple = 0;
    $cantPersonaDoble = 0;
    $totalCantPersonas = 0;
    $total1 = 0;
    $total2 = 0;

    // Recorrer los tipos de cama y calcular la cantidad total de personas
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

    // Enlazar el parámetro de tipo de cama
    $sql->bindParam(":tipoCama", $valorTipoCama);

    // Ejecutar la consulta de actualización de la habitación
    if ($sql->execute()) {
        $_SESSION['msjExito'] = "¡Los datos de la habitación se ha actualizado exitosamente!";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    } else {
        $_SESSION['msjError'] = "Ha habido un error al intentar actualizar los datos. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
}
