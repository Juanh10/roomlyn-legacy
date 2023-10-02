<?php

include_once "../../config/conex.php";
session_start();


if (isset($_POST['btnActualizar'])) {
    if (!empty($_POST['numHabitacion']) && !empty($_POST['tipoHab']) && !empty($_POST['observaciones']) && !empty($_POST['idHab'])) { // Comparar si los datos no estan vacios

        // Capturar todos los datos enviados del formulario
        $idHabitacion = $_POST['idHab'];
        $numHab = $_POST['numHabitacion'];
        $tipoHab = $_POST['tipoHab'];
        $sisClimatizacion = $_POST['sisClimatizacion'];
        $observ = $_POST['observaciones'];

        $existe = false;

        $consulta = $dbh->prepare("SELECT id, nHabitacion FROM habitaciones WHERE id = :idHab"); // consulta sql
        $consulta->bindParam(":idHab", $idHabitacion); // enlazar el marcador con la variable
        $consulta->execute(); // ejecutar la consulta

        if ($datos = $consulta->fetch()) { // obtener datos de la consulta
            if ($datos['nHabitacion'] != $numHab) {
                $consulta2 = $dbh->prepare("SELECT id, nHabitacion, estado FROM habitaciones WHERE nHabitacion = :numHab");
                $consulta2->bindParam(":numHab", $numHab);
                $consulta2->execute();

                $filas = $consulta2 -> fetch();

                if ($consulta2->rowCount() > 0 && $filas['estado'] === 1) {
                    $_SESSION['msjError'] = "Error: El número de habitación ya ha sido registrado anteriormente.";
                    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                    $existe = true;
                } else {
                    if(!$existe){
                        actualizarHabitacion($sql, $dbh, $idHabitacion, $numHab, $tipoHab, $sisClimatizacion, $observ);
                    }
                }
            } else {
                actualizarHabitacion($sql, $dbh, $idHabitacion, $numHab, $tipoHab, $sisClimatizacion, $observ);
            }
        }
    } else {
        $_SESSION['msjError'] = "Campos vacíos";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
}


if (isset($_POST['actualizarEstado'])) {
    if (!empty($_POST['opcion']) && !empty($_POST['idHab'])) {
        $opcion = $_POST['opcion'];
        $idHabitacion = $_POST['idHab'];

        $sql = $dbh->prepare("UPDATE habitaciones SET id_hab_estado=:idEstado, fecha_sys=now() WHERE id = :idHab");
        $sql->bindParam(":idEstado", $opcion);
        $sql->bindParam(":idHab", $idHabitacion);

        if ($sql->execute()) {
            $_SESSION['msjExito'] = "¡Se ha cambiado el estado exitosamente!";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        } else {
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        }
    } else {
        $_SESSION['msjError'] = "Campos vacíos";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
}


function actualizarHabitacion($sql, $dbh, $idHabitacion, $numHab, $tipoHab, $sisClimatizacion, $observ){

    $sql = $dbh->prepare("UPDATE habitaciones SET nHabitacion= :nHab, id_tipo= :idTipo, tipoServicio= :tipoServ, observacion=:observacion, tipoCama=:tipoCama, cantidadPersonasHab=:cantPersonas, fecha_sys=now() WHERE id = :id");


    $sql->bindParam(":id", $idHabitacion);
    $sql->bindParam(":nHab", $numHab);
    $sql->bindParam(":idTipo", $tipoHab);
    $sql->bindParam(":tipoServ", $sisClimatizacion);
    $sql->bindParam(":observacion", $observ);

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

    if ($sql->execute()) {
        $_SESSION['msjExito'] = "¡La habitación se ha actualizado exitosamente!";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    } else {
        $_SESSION['msjError'] = "Ocurrió un error";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
}

?>