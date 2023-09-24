<?php
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");
session_start();

if (!empty($_POST['numHabitacion']) && !empty($_POST['tipoHab']) && !empty($_POST['observaciones'])) {

    $numHab =  $_POST['numHabitacion'];
    $tipoHab = $_POST['tipoHab'];
    $descripcionHab = $_POST['observaciones'];
    $estadoHab = 1; // los diferentes tipos de estados que tiene la habitacion 1: disponible, 2: limpieza, 3: mantenimiento, 4: ocupado
    $estado = 1; // estado si la habitacion esta deshabilitada o no
    $fecha = date("y/m/d");
    $hora = date("G:i:s");

    $existe = false;

    $consulta = $dbh->prepare("SELECT id, nHabitacion, estado FROM habitaciones WHERE nHabitacion = :numHab");
    $consulta->bindParam(":numHab", $numHab); // enlazar el marcador con la variable
    $consulta->execute(); // ejecutar la consulta
    $fila = $consulta -> fetch(); // para acceder a los datos de la BD
    if ($consulta->rowCount() > 0 && $fila['estado'] === 1) {
        $_SESSION['msjError'] = "Esta habitación ya existe";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        $existe = true;
    } else {

        $sql = $dbh->prepare("INSERT INTO habitaciones(nHabitacion, id_tipo, id_hab_estado, tipoCama, cantidadPersonasHab, observacion, estado, fecha, hora, fecha_sys) VALUES (:nHab, :idTipo, :idHabEstado, :tipoCama, :cantPersonas, :observacion, :estado, :fecha, :hora, now())");

        $sql->bindParam(":nHab", $numHab);
        $sql->bindParam(":idTipo", $tipoHab);
        $sql->bindParam(":idHabEstado", $estadoHab);
        $sql->bindParam(":observacion", $descripcionHab);
        $sql->bindParam(":estado", $estado);
        $sql->bindParam(":fecha", $fecha);
        $sql->bindParam(":hora", $hora);

        $valorTipoCama = "";
        $cantPersonas = 0;
        foreach ($_POST as $nmCampo => $valorSelect) {
            if (strpos($nmCampo, "tipoCama") === 0) {
                if($valorSelect === "Simple"){
                    $cantPersonas += 1;
                }else if($valorSelect === "Doble"){
                    $cantPersonas += 2;
                }
                // Asigna el valor a :tipoCama en lugar de volver a vincularlo
                $valorTipoCama .= $valorSelect.","; // concatenar el valor de la variable con "valorSelect"
            }
        }

        $sql->bindParam(":cantPersonas", $cantPersonas);

        // funcion "rtrim" Elimina la coma y el espacio en blanco al final si existen
        $valorTipoCama = rtrim($valorTipoCama, ', ');


        $sql->bindParam(":tipoCama", $valorTipoCama);

        if (!$existe && $sql->execute()) {
            $_SESSION['msjExito'] = "Habitación registrada con éxito";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        } else {
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        }

    }
} else {
    $_SESSION['msjError'] = "Campos vacíos";
    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
}
?>