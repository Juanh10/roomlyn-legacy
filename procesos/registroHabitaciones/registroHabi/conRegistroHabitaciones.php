<?php
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");
session_start();

if (!empty($_POST['numHabitacion']) && !empty($_POST['tipoHab']) && !empty($_POST['observaciones'])) {

    $numHab =  $_POST['numHabitacion'];
    $tipoHab = $_POST['tipoHab'];
    $tipoCama = $_POST['tipoCama'];
    $cantTipoSimple = $_POST['cantTipoSimple'];
    $cantTipoDoble = $_POST['cantTipoDoble'];
    $sisClimatizacion = $_POST['sisClimatizacion'];
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

        $sql = $dbh->prepare("INSERT INTO habitaciones(nHabitacion, id_tipo, id_hab_estado, tipoCama, cantidadPersonasHab, tipoServicio, observacion, estado, fecha, hora, fecha_sys) VALUES (:nHab, :idTipo, :idHabEstado, :tipoCama, :cantPersonas, :tipoServicio, :observacion, :estado, :fecha, :hora, now())");

        $sql->bindParam(":nHab", $numHab);
        $sql->bindParam(":idTipo", $tipoHab);
        $sql->bindParam(":idHabEstado", $estadoHab);
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
    
        foreach($tipoCama as $tipo){
            if($tipo == "simple"){
                $cantPersonaSimple += 1;
                $total1 = $cantPersonaSimple * $cantTipoSimple;
                $valorCampo.= $cantTipoSimple." ".$tipo.",";
            }else if($tipo == "doble"){
                $cantPersonaDoble += 2;
                $total2 = $cantPersonaDoble * $cantTipoDoble;
                $valorCampo.= $cantTipoDoble." ".$tipo." ";
            }
            $totalCantPersonas = $total1 + $total2;
        }

        $sql->bindParam(":cantPersonas", $totalCantPersonas);

        // funcion "rtrim" Elimina la coma y el espacio en blanco al final si existen
        $valorTipoCama = rtrim($valorCampo, ', ');


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