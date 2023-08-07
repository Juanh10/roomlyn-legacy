<?php

include "../../config/conex.php";

if(!empty($_POST['nombreTipo']) && !empty($_POST['cantidadCamas']) && !empty($_POST['cantidadPersonas']) && !empty($_POST['precioVentilador']) && !empty($_POST['precioAire']) && !empty($_FILES['imagenes']) && !empty($_POST['opcionesServ'])){

    $nombreTipo = $_POST['nombreTipo'];
    $cantidadCamas = $_POST['cantidadCamas'];
    $cantidadPersonas = $_POST['cantidadPersonas'];
    $precioVentilador = $_POST['precioVentilador'];
    $precioAire= $_POST['precioAire'];
    $opcionesServ= $_POST['opcionesServ'];
    $estado = 1;

    $precioVentilador2 = number_format($precioVentilador, 0, ',', '.')."  "; // funcion para formatear el valor y ponerlo con puntos decimales

    $precioAire2 = number_format($precioAire, 0, ',', '.'); //! recordarme de esto

    $sql = $dbh -> prepare("INSERT INTO habitaciones_tipos(tipoHabitacion, cantidadCamas, capacidadPersonas, precioVentilador, precioAire, estado, fecha_sys) VALUES (:nombreTipo, :cantidadCamas, :cantidadPersonas, :precioVentilador, :precioAire, :estado,  now())"); // consulta de la tabla habitaciones_tipos de la BD

    $sql -> bindParam(':nombreTipo',$nombreTipo);
    $sql -> bindParam(':cantidadCamas',$cantidadCamas);
    $sql -> bindParam(':cantidadPersonas',$cantidadPersonas);
    $sql -> bindParam(':precioVentilador',$precioVentilador);
    $sql -> bindParam(':precioAire',$precioAire);
    $sql -> bindParam(':estado',$estado);

    if($sql -> execute()){

        $sql2 = $dbh -> prepare("INSERT INTO habitaciones_tipos_elementos(id_habitacion_tipo, id_elemento) VALUES (:idTipo, :idElemento)"); // consulta de la tabla habitaciones_tipos_elementos de la BD
        
        $ultID = $dbh -> lastInsertId('habitaciones_tipos');
        $sql2 -> bindParam(':idTipo',$ultID);

        foreach($opcionesServ as $opciones){
            $sql2 -> bindParam(':idElemento',$opciones);
            if($sql2 -> execute()){
                header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
                session_start();
                $_SESSION['msjRegistradoTipoH'] = "REGISTRADO";
            }else{
                echo "ERROR";
            }
        }
    }else{
        echo "ERROR";
    }

}else{
    echo "CAMPOS VACIOS";
}

?>