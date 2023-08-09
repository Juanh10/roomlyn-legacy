<?php

include "../../config/conex.php";

if (!empty($_POST['nombreTipo']) && !empty($_POST['cantidadCamas']) && !empty($_POST['cantidadPersonas']) && !empty($_POST['precioVentilador']) && !empty($_POST['precioAire']) && !empty($_FILES['imagenes']) && !empty($_POST['opcionesServ'])) {

    session_start();

    $nombreTipo = $_POST['nombreTipo'];
    $cantidadCamas = $_POST['cantidadCamas'];
    $cantidadPersonas = $_POST['cantidadPersonas'];
    $precioVentilador = $_POST['precioVentilador'];
    $precioAire = $_POST['precioAire'];
    $opcionesServ = $_POST['opcionesServ'];
    $estado = 1;

    $precioVentilador2 = number_format($precioVentilador, 0, ',', '.') . "  "; // funcion para formatear el valor y ponerlo con puntos decimales

    $precioAire2 = number_format($precioAire, 0, ',', '.'); //! recordarme de esto

    $sql = $dbh->prepare("INSERT INTO habitaciones_tipos(tipoHabitacion, cantidadCamas, capacidadPersonas, precioVentilador, precioAire, estado, fecha_sys) VALUES (:nombreTipo, :cantidadCamas, :cantidadPersonas, :precioVentilador, :precioAire, :estado,  now())"); // consulta de la tabla habitaciones_tipos de la BD

    $sql->bindParam(':nombreTipo', $nombreTipo);
    $sql->bindParam(':cantidadCamas', $cantidadCamas);
    $sql->bindParam(':cantidadPersonas', $cantidadPersonas);
    $sql->bindParam(':precioVentilador', $precioVentilador);
    $sql->bindParam(':precioAire', $precioAire);
    $sql->bindParam(':estado', $estado);


    $estadoConfirServicios = false;
    $estadoConfirImagenes = false;

    if ($sql->execute()) {

        $sql2 = $dbh->prepare("INSERT INTO habitaciones_tipos_elementos(id_habitacion_tipo, id_elemento) VALUES (:idTipo, :idElemento)"); // consulta de la tabla habitaciones_tipos_elementos de la BD

        $ultID = $dbh->lastInsertId('habitaciones_tipos'); // funcion para capturar el ultimo id de la tabla habitaciones_tipos
        $sql2->bindParam(':idTipo', $ultID);


        foreach ($opcionesServ as $opciones) { // recorrer todas las opciones de servicios
            $sql2->bindParam(':idElemento', $opciones);
            if ($sql2->execute()) { // ejecutar la consulta
                $estadoConfirServicios = true;
            } else {
                $estadoConfirServicios = false;
            }
        }


        //* SECCION PARA SUBIR LAS IMAGENES A LA BASE DE DATOS


        $sql3 = $dbh->prepare("INSERT INTO habitaciones_imagenes(idTipoHabitacion, nombre, ruta) VALUES (:idTipo, :nombre, :ruta)"); // preparar la consulta de la tabla de las imagenes

        $imagenesNombre = $_FILES['imagenes']['name']; // capturar el nombre de la imagen esto me da con la extension tambien (imagen.png)
        $rutaTmp = $_FILES['imagenes']['tmp_name']; // capturar la ruta temporal

        for ($i = 0; $i < count($imagenesNombre); $i++) {  // recorrer las imagenes ya que es un arreglo
            for ($i = 0; $i < count($rutaTmp); $i++) {
                $rutaTmp2 = $rutaTmp[$i];

                $imagenesNombre2 = $imagenesNombre[$i];
                $nombreNuevoImg = pathinfo($imagenesNombre2, PATHINFO_FILENAME); // funcion donde podemos capturar informacion de la imagen en este caso vamos a capurar solamente el nombre de la imagenes (imagen.png / imagen)
                $extensionImg = pathinfo($imagenesNombre2, PATHINFO_EXTENSION); // capturamos la extension de la imagen (imagen.png / png)

                $rutaImg = $nombreNuevoImg . "." . $extensionImg; // creamos la ruta donde se van a guardar las imagenes

                // enlazar los marcadores con las variables para guardar en la base de datos

                $sql3->bindParam(':idTipo', $ultID);
                $sql3->bindParam(':nombre', $nombreNuevoImg);
                $sql3->bindParam(':ruta', $rutaImg);

                if ($sql3->execute()) {
                    move_uploaded_file($rutaTmp2, "../../../imgServidor/".$rutaImg);
                    $estadoConfirImagenes = true;
                } else {
                    $estadoConfirImagenes = false;
                }
            }
        }

        if ($estadoConfirServicios && $estadoConfirImagenes) {
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            $_SESSION['msj2'] = "REGISTRADO";
        } else {
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            $_SESSION['msj2'] = "ERROR";
        }

    } else {
        header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
        $_SESSION['msj2'] = "ERROR";
    }

} else {
    header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
    $_SESSION['msj2'] = "Campos vacios";
}
?>