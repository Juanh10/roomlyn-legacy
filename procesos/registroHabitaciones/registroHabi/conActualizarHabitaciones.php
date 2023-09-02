<?php

include_once "../../config/conex.php";

if (isset($_POST['btnActualizar'])) {
    if (!empty($_POST['numHabitacion']) && !empty($_POST['tipoHab']) && !empty($_POST['observaciones']) && !empty($_POST['idHab'])) {

        $idHabitacion = $_POST['idHab'];
        $numHab = $_POST['numHabitacion'];
        $tipoHab = $_POST['tipoHab'];
        $observ = $_POST['observaciones'];

        $consulta = $dbh->prepare("SELECT id, nHabitacion FROM habitaciones WHERE nHabitacion = :numHab");
        $consulta->bindParam(":numHab", $numHab);
        $consulta->execute();

        if ($consulta->rowCount() > 0) {
            echo "MAL";
            $existe = true;
        } else {
            $sql = $dbh->prepare("UPDATE habitaciones SET nHabitacion= :nHab, id_tipo= :idTipo observacion=:observacion, fecha_sys=now() WHERE id = :id");


            $sql->bindParam(":id", $idHabitacion);
            $sql->bindParam(":nHab", $numHab);
            $sql->bindParam(":idTipo", $tipoHab);
            $sql->bindParam(":observacion", $observ);

            if (!$existe && $sql->execute()) {
                echo "Bien";
            } else {
                echo "mal2";
            }
        }
    } else {
       echo "mal3";
    }
}
