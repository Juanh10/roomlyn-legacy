<?php

include_once "../../config/conex.php";

// actulizar los datos de los tipos de habitaciones

if (isset($_POST['actTipo'])) {

    session_start();

    if (!empty($_POST['nombreTipo']) && !empty($_POST['cantidadCamas']) && !empty($_POST['cantidadPersonas']) && !empty($_POST['precioVentilador']) && !empty($_POST['precioAire'])) { // condicion para saber si los campos no vienen vacios

        // capturamos todos los datos del formulario
        $idTipoHab = $_POST['idTipoHab'];
        $nombreTipo = $_POST['nombreTipo'];
        $cantidadCamas = $_POST['cantidadCamas'];
        $cantidadPersonas = $_POST['cantidadPersonas'];
        $precioVentilador = $_POST['precioVentilador'];
        $precioAire = $_POST['precioAire'];

        $sql = $dbh->prepare("UPDATE habitaciones_tipos SET tipoHabitacion= :tipoHab, cantidadCamas= :cantidadCama, capacidadPersonas= :cantidadPersona, precioVentilador= :precioVentilador, precioAire= :precioAire WHERE id = :idTipo"); // consulta sql

        // vinculamos los marcadores con las variables
        $sql->bindParam(':tipoHab', $nombreTipo);
        $sql->bindParam(':cantidadCama', $cantidadCamas);
        $sql->bindParam(':cantidadPersona', $cantidadPersonas);
        $sql->bindParam(':precioVentilador', $precioVentilador);
        $sql->bindParam(':precioAire', $precioAire);
        $sql->bindParam(':idTipo', $idTipoHab);

        // ejecutamos la consulta
        if ($sql->execute()) {
            $_SESSION['msjExito'] = "Datos actualizados";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        } else {
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }
    } else {
        $_SESSION['msjError'] = "Campos vacíos";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
    }
}


// Eliminar los servicios de los tipos de habitaciones

if(isset($_POST['btnElmServ'])){
    
    session_start();

    if(!empty($_POST['idServicio'])){

        $idServicios = $_POST['idServicio'];
        $idTipoHab = $_POST['idTipoHab'];

        $estadoElmServ = 0;

        $sqlElmServ = $dbh -> prepare("UPDATE habitaciones_tipos_elementos SET estado=:estado WHERE id = :idServ"); // consulta sql

        $sqlElmServ -> bindParam(':estado', $estadoElmServ); // vincular los marcadores con las variables
        $sqlElmServ -> bindParam(':idServ', $idServicios);

        // ejecutamos la consulta 
        if($sqlElmServ -> execute()){
            $_SESSION['msjExito'] = "Servicio deshabilitado";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }else{
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }

        
    }else{
        echo "Ocurrió un error";
    }
}