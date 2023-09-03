<?php

include_once "../../config/conex.php";
session_start();

if (isset($_POST['btnActualizar'])) {
    if (!empty($_POST['numHabitacion']) && !empty($_POST['tipoHab']) && !empty($_POST['observaciones']) && !empty($_POST['idHab'])) { // Comparar si los datos no estan vacios

        // Capturar todos los datos enviados del formulario
        $idHabitacion = $_POST['idHab'];
        $numHab = $_POST['numHabitacion'];
        $tipoHab = $_POST['tipoHab'];
        $observ = $_POST['observaciones'];

        $existe = false;

        $consulta = $dbh->prepare("SELECT id, nHabitacion FROM habitaciones WHERE id = :idHab"); // consulta sql
        $consulta->bindParam(":idHab", $idHabitacion); // enlazar el marcador con la variable
        $consulta->execute(); // ejecutar la consulta

        if ($datos = $consulta->fetch()) { // obtener datos de la consulta
            if ($datos['nHabitacion'] != $numHab) {
                $consulta2 = $dbh->prepare("SELECT id, nHabitacion FROM habitaciones WHERE nHabitacion = :numHab");
                $consulta2->bindParam(":numHab", $numHab);
                $consulta2->execute();

                if ($consulta2->rowCount() > 0) {
                    $_SESSION['msjError'] = "Error: El número de habitación ya ha sido registrado anteriormente.";
                    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                    $existe = true;
                } else {
                    $sql = $dbh->prepare("UPDATE habitaciones SET nHabitacion= :nHab, id_tipo= :idTipo, observacion=:observacion, fecha_sys=now() WHERE id = :id");


                    $sql->bindParam(":id", $idHabitacion);
                    $sql->bindParam(":nHab", $numHab);
                    $sql->bindParam(":idTipo", $tipoHab);
                    $sql->bindParam(":observacion", $observ);

                    if (!$existe && $sql->execute()) {
                        $_SESSION['msjExito'] = "¡La habitación se ha actualizado exitosamente!";
                        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                    } else {
                        $_SESSION['msjError'] = "Ocurrió un error";
                        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                    }
                }
            } else {
                $sql = $dbh->prepare("UPDATE habitaciones SET nHabitacion= :nHab, id_tipo= :idTipo, observacion=:observacion, fecha_sys=now() WHERE id = :id");


                $sql->bindParam(":id", $idHabitacion);
                $sql->bindParam(":nHab", $numHab);
                $sql->bindParam(":idTipo", $tipoHab);
                $sql->bindParam(":observacion", $observ);

                if (!$existe && $sql->execute()) {
                    $_SESSION['msjExito'] = "¡La habitación se ha actualizado exitosamente!";
                        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                } else {
                    $_SESSION['msjError'] = "Ocurrió un error";
                    header("location: ../../../vistas/vistasAdmin/habitaciones.php");
                }
            }
        }
    } else {
        $_SESSION['msjError'] = "Campos vacíos";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
}


if(isset($_POST['actualizarEstado'])){
    if(!empty($_POST['opcion']) && !empty($_POST['idHab'])){
        $opcion = $_POST['opcion'];
        $idHabitacion = $_POST['idHab'];

        $sql = $dbh -> prepare("UPDATE habitaciones SET id_hab_estado=:idEstado, fecha_sys=now() WHERE id = :idHab");
        $sql -> bindParam(":idEstado", $opcion);
        $sql -> bindParam(":idHab", $idHabitacion);

        if($sql -> execute()){
            echo "NICEEE";
        }else{
            echo "Ocurrió un error";
        }


    }else{
        echo "Campos vacíos";
    }
}

?>