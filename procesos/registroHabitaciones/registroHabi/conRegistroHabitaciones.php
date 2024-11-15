<?php
// Incluye la configuracion de conexión a la base de datos y define la zona horaria
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");
session_start(); // Inicia la sesion para manejar mensajes entre páginas

// Función para redirigir con un mensaje, ya sea de error o de éxito
function redirigirConMensaje($mensaje, $error = true)
{
    $_SESSION[$error ? 'msjError' : 'msjExito'] = $mensaje;
    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    exit();
}

// Función para insertar un llavero NFC en la base de datos
function insertarLlaveroNFC($codigoNfc, $dbh)
{
    // Prepara la consulta para insertar un código NFC con la fecha actual
    $sqlNfc = $dbh->prepare("INSERT INTO llaveros_nfc(codigo, fecha_sys) VALUES (:codigo, now())");
    $sqlNfc->bindParam(":codigo", $codigoNfc); // Enlaza el parámetro con el valor del código NFC
    if ($sqlNfc->execute()) { // Ejecuta la consulta
        return $dbh->lastInsertId(); // Retorna el ID del último llavero insertado si es exitoso
    }
    return false; // Retorna false si la inserción falla
}

// Función para insertar una nueva habitación
function insertarHabitacion($dbh, $numHab, $tipoHab, $estadoHab, $sisClimatizacion, $descripcionHab, $estado, $fecha, $hora, $valorTipoCama, $totalCantPersonas, $ultIDNfc)
{
    // Prepara la consulta SQL para insertar los datos de la habitación
    $sql = $dbh->prepare("INSERT INTO habitaciones(nHabitacion, id_hab_tipo, id_hab_estado, id_servicio, id_codigo_nfc, tipoCama, cantidadPersonasHab, observacion, estado, fecha, hora, fecha_update) VALUES (:nHab, :idTipo, :idHabEstado, :tipoServicio, :idNfc, :tipoCama, :cantPersonas, :observacion, :estado, :fecha, :hora, now())");

    // Enlaza los parámetros de la consulta con los valores de las variables
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

    return $sql->execute() ? $dbh->lastInsertId('habitaciones') : false; // Ejecuta la consulta y retorna el ID de la habitación
}

// Función para verificar si una habitación o llavero NFC ya existen
function verificarExistencia($numHab, $codigoNfc, $llaveroNfc, $dbh)
{
    // Verifica si la habitación ya existe y está disponible
    $consulta = $dbh->prepare("SELECT id_habitacion FROM habitaciones WHERE nHabitacion = :numHab AND estado = 1");
    $consulta->bindParam(":numHab", $numHab);
    $consulta->execute();

    if ($consulta->rowCount() > 0) { // Si existe, retorna un mensaje de error
        return "Esta habitación ya existe y está disponible.";
    }

    // Verifica si el código NFC ya está registrado en otra habitación
    if (!empty($codigoNfc)) {
        $consultaNfc = $dbh->prepare("SELECT l.codigo FROM habitaciones as h INNER JOIN llaveros_nfc as l ON h.id_codigo_nfc = l.id_codigo_nfc WHERE l.codigo = :codigo AND h.estado = 1");
        $consultaNfc->bindParam(":codigo", $codigoNfc);
        $consultaNfc->execute();

        if ($consultaNfc->rowCount() > 0) { // Si el llavero existe, retorna un mensaje de error
            return "Este llavero ya está registrado con otra habitación.";
        }
    }
    return false; // Retorna false si no existen conflictos
}

// Función para calcular la cantidad de personas permitidas según el tipo de camas
function calcularCantidadPersonas($tipoCama, $cantTipoSimple, $cantTipoDoble)
{
    $valorCampo = ""; // Cadena para describir los tipos de camas
    $totalCantPersonas = 0; // Total de personas permitidas

    // Recorrer los tipos de cama y sumar la capacidad total
    foreach ($tipoCama as $tipo) {
        if ($tipo == "simple") { // Si la cama es simple, agrega una persona por cama
            $totalCantPersonas += $cantTipoSimple;
            $valorCampo .= $cantTipoSimple . " simple, ";
        } elseif ($tipo == "doble") { // Si es doble, agrega dos personas por cama
            $totalCantPersonas += $cantTipoDoble * 2;
            $valorCampo .= $cantTipoDoble . " doble";
        }
    }

    return [rtrim($valorCampo, ', '), $totalCantPersonas]; // Retorna la descripción y el total de personas
}

// Validación para asegurar que todos los campos requeridos están llenos
if (empty($_POST['numHabitacion']) || empty($_POST['tipoHab']) || empty($_POST['observaciones']) || empty($_POST['opcionesServ']) || (empty($_POST['cantTipoSimple']) && empty($_POST['cantTipoDoble']))) {
    redirigirConMensaje("Por favor, complete todos los campos del formulario.");
}

try {
    // Inicializa las variables con los datos del formulario
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

    // Verifica si la habitación o llavero ya existen
    $mensajeError = verificarExistencia($numHab, $codigoNfc, $llaveroNfc, $dbh);
    if ($mensajeError) { // Si hay error, redirige con el mensaje
        redirigirConMensaje($mensajeError);
    }

    // Inserta el llavero NFC si no está registrado
    //$ultIDNfc = insertarLlaveroNFC($llaveroNfc ? $codigoNfc : 0, $dbh);

    // Verificar si el checkbox está marcado
    if ($llaveroNfc) {
        $ultIDNfc = insertarLlaveroNFC($codigoNfc, $dbh);
        if (!$ultIDNfc) {
            redirigirConMensaje("Error en el registro del llavero NFC.");
        }
    } else {
        $ultIDNfc = 1;
    }

    // Calcula la cantidad de personas que permite la habitación
    [$valorTipoCama, $totalCantPersonas] = calcularCantidadPersonas($tipoCama, $cantTipoSimple, $cantTipoDoble);


    // Inserta la nueva habitación en la base de datos
    $ultIDHabitacion = insertarHabitacion($dbh, $numHab, $tipoHab, $estadoHab, $sisClimatizacion, $descripcionHab, $estado, $fecha, $hora, $valorTipoCama, $totalCantPersonas, $ultIDNfc);

    // Inserta los servicios seleccionados en la habitación
    $sql2 = $dbh->prepare("INSERT INTO habitaciones_elementos_selec(id_habitacion, id_hab_elemento, estado, fecha_sys) VALUES (:idHab, :idElemento, :estadoServ, now())");
    $sql2->bindParam(':idHab', $ultIDHabitacion);
    $sql2->bindParam(':estadoServ', $estado);

    $estadoConfirServicios = true;
    foreach ($opcionesServ as $opcion) {
        $sql2->bindParam(':idElemento', $opcion);
        if (!$sql2->execute()) { // Si falla, cambia el estado de confirmación de servicios
            $estadoConfirServicios = false;
            break;
        }
    }

    // Redirige con un mensaje de éxito o de error según el resultado
    if ($estadoConfirServicios) {
        redirigirConMensaje("Habitación registrada con éxito", false);
    } else {
        redirigirConMensaje("Error en la asignación de servicios.");
    }
} catch (Exception $e) { // Captura cualquier excepción y redirige con mensaje de error
    redirigirConMensaje("Error en el sistema. Intente nuevamente.");
}
