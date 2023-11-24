<?php

include_once "../../config/conex.php";

// Eliminar los servicios de los tipos de habitaciones

if (isset($_POST['btnElmServ'])) {

    session_start();

    if (!empty($_POST['idServicio'])) {

        $idServicios = $_POST['idServicio'];
        $idTipoHab = $_POST['idTipoHab'];

        $estadoElmServ = 0;

        $sqlElmServ = $dbh->prepare("UPDATE habitaciones_elementos_selec SET estado=:estado WHERE id_hab_tipo_elemento = :idServ"); // consulta sql

        $sqlElmServ->bindParam(':estado', $estadoElmServ); // vincular los marcadores con las variables
        $sqlElmServ->bindParam(':idServ', $idServicios);

        // ejecutamos la consulta 
        if ($sqlElmServ->execute()) {
            $_SESSION['msjExito'] = "¡Se ha deshabilitado correctamente!";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php?id=" . $idTipoHab . "");
        } else {
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php?id=" . $idTipoHab . "");
        }
    } else {
        $_SESSION['msjError'] = "Ocurrió un error";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php?id=" . $idTipoHab . "");
    }
}


// Agregar servicios segun los tipos de habitaciones

if (isset($_POST['añadirServ'])) {

    session_start();

    if (!empty($_POST['idTipoHab'])) { // si el campo no esta vacio

        $idTipoHab = $_POST['idTipoHab'];

        if (!empty($_POST['listaServi'])) { // si el campo no esta vacio

            $tipoServ = $_POST['listaServi'];
            $estado = 1;

            $sql = $dbh->prepare("INSERT INTO habitaciones_elementos_selec(id_habitacion, id_hab_elemento, estado, fecha_sys) VALUES (:idTipoHab, :idElemento, :estado, now())"); // consulta sql

            $sql->bindParam(':idTipoHab', $idTipoHab); // vincular los marcadores con las variables
            $sql->bindParam(':estado', $estado);

            $estadoSer = false;

            foreach ($tipoServ as $tipo) { // recorrer el arreglo de los servicios
                $sql->bindParam(':idElemento', $tipo);

                if ($sql->execute()) { // ejecutar la consulta
                    $estadoSer = true;
                } else {
                    $estadoSer = false;
                }
            }

            if ($estadoSer) {
                $_SESSION['msjExito'] = "Servicios agregado con éxito";
                header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            } else {
                $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("location: ../../../vistas/vistasAdmin/habitaciones.php");
            }
        } else {
            $_SESSION['msjError'] = "Debes seleccionar al menos un elemento de la habitación";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php");
        }
    } else {
        $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php");
    }
}



?>