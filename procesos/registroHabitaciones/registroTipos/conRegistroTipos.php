<?php

include_once "../../config/conex.php";

if (!empty($_POST['nombreTipo']) && !empty($_POST['cantidadCamas']) && !empty($_POST['cantidadPersonas']) && !empty($_POST['precioVentilador']) && !empty($_POST['precioAire']) && !empty($_FILES['imagenes']) && !empty($_POST['opcionesServ'])) {

    session_start();

    // capturar todos los datos

    $nombreTipo = $_POST['nombreTipo'];
    $cantidadCamas = $_POST['cantidadCamas'];
    $cantidadPersonas = $_POST['cantidadPersonas'];
    $precioVentilador = $_POST['precioVentilador'];
    $precioAire = $_POST['precioAire'];
    $opcionesServ = $_POST['opcionesServ'];
    $estado = 1;

    $precioVentilador2 = number_format($precioVentilador, 0, ',', '.') . "  "; // funcion para formatear el valor y ponerlo con puntos decimales

    $precioAire2 = number_format($precioAire, 0, ',', '.'); //! recordarme de esto


    // consulta de la base de datos del nombre del tipo de habitacion para comparar si ya existe ese tipo

    $existeDato = false;

    $consultaNm = $dbh->prepare("SELECT id_hab_tipo, tipoHabitacion, estado FROM habitaciones_tipos WHERE tipoHabitacion = :nmTipo AND estado = :nmEstado");
    $consultaNm->bindParam(":nmTipo", $nombreTipo);
    $consultaNm->bindParam(":nmEstado", $estado);
    $consultaNm->execute();

    if ($consultaNm->rowCount() > 0) {
        $_SESSION['msjError'] = "Este tipo de habitación ya existe";
        header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
        $existeDato = true;
    } else {
        $sql = $dbh->prepare("INSERT INTO habitaciones_tipos(tipoHabitacion, cantidadCamas, capacidadPersonas, estado, fecha_sys) VALUES (:nombreTipo, :cantidadCamas, :cantidadPersonas, :estado,  now())"); // consulta de la tabla habitaciones_tipos de la BD

        $sql->bindParam(':nombreTipo', $nombreTipo);
        $sql->bindParam(':cantidadCamas', $cantidadCamas);
        $sql->bindParam(':cantidadPersonas', $cantidadPersonas);
        $sql->bindParam(':estado', $estado);


        $estadoConfirServicios = false;
        $estadoConfirPrecios = false;
        $estadoConfirImagenes = false;

        if (!$existeDato && $sql->execute()) {

            $sql2 = $dbh->prepare("INSERT INTO habitaciones_tipos_servicios(id_hab_tipo, id_servicio, estado, fecha_sys) VALUES (:idTipo, :idElemento, :estadoServ, now())"); // consulta de la tabla habitaciones_tipos_elementos de la BD

            $estadoServ = 1;
            $ultID = $dbh->lastInsertId('habitaciones_tipos'); // funcion para capturar el ultimo id de la tabla habitaciones_tipos
            $sql2->bindParam(':idTipo', $ultID);
            $sql2->bindParam(':estadoServ', $estadoServ);

            $ventilador = 1;
            $aire = 2;

            $opcionesServ2 = array_merge([$ventilador, $aire], $opcionesServ);

            foreach ($opcionesServ2 as $opciones) { // recorrer todas las opciones de servicios
                $sql2->bindParam(':idElemento', $opciones);
                if ($sql2->execute()) { // ejecutar la consulta
                    $estadoConfirServicios = true;
                } else {
                    $estadoConfirServicios = false;
                }
            }

            if ($estadoConfirServicios) {

                $sqlServicioTipo = $dbh->prepare("SELECT id_tipo_servicio, id_hab_tipo, id_servicio, estado FROM habitaciones_tipos_servicios WHERE id_hab_tipo = " . $ultID . " AND id_servicio = " . $ventilador . "");

                $sqlServicioTipo->execute();

                $resultadoServTipo = $sqlServicioTipo->fetch(PDO::FETCH_ASSOC);

                if ($resultadoServTipo) {

                    $id_tipo_servicio = $resultadoServTipo['id_tipo_servicio'];

                    $sqlInsertPrecio = $dbh->prepare("INSERT INTO habitaciones_tipos_precios(id_tipo_servicio, precio, estado, fecha_sys) VALUES (:idTipoServicio, :precio, :estado, now())");

                    $sqlInsertPrecio->bindParam(':idTipoServicio', $id_tipo_servicio);
                    $sqlInsertPrecio->bindParam(':precio', $precioVentilador);
                    $sqlInsertPrecio->bindParam(':estado', $estado);

                    if ($sqlInsertPrecio->execute()) {
                        $sqlServicioTipoAire = $dbh->prepare("SELECT id_tipo_servicio, id_hab_tipo, id_servicio, estado FROM habitaciones_tipos_servicios WHERE id_hab_tipo = " . $ultID . " AND id_servicio = " . $aire . "");

                        $sqlServicioTipoAire->execute();

                        $resultadoServTipoAire = $sqlServicioTipoAire->fetch(PDO::FETCH_ASSOC);

                        if ($resultadoServTipoAire) {
                            $id_tipo_servicioAire = $resultadoServTipoAire['id_tipo_servicio'];

                            $sqlInsertPrecioAire = $dbh->prepare("INSERT INTO habitaciones_tipos_precios(id_tipo_servicio, precio, estado, fecha_sys) VALUES (:idTipoServicio, :precio, :estado, now())");

                            $sqlInsertPrecioAire->bindParam(':idTipoServicio', $id_tipo_servicioAire);
                            $sqlInsertPrecioAire->bindParam(':precio', $precioAire);
                            $sqlInsertPrecioAire->bindParam(':estado', $estado);

                            if($sqlInsertPrecioAire->execute()){
                                $estadoConfirPrecios = true;
                            }else{
                                header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
                                $_SESSION['msj2'] = "Ocurrió un error";
                            }

                        }
                    }
                }
            }


            //* SECCION PARA SUBIR LAS IMAGENES A LA BASE DE DATOS


            $sql3 = $dbh->prepare("INSERT INTO habitaciones_imagenes(id_hab_tipo, nombre, ruta, estado) VALUES (:idTipo, :nombre, :ruta, :estadoImg)"); // preparar la consulta de la tabla de las imagenes
            $estadoImg = 1;

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
                    $sql3->bindParam(':estadoImg', $estadoImg);

                    if ($sql3->execute()) {
                        move_uploaded_file($rutaTmp2, "../../../imgServidor/" . $rutaImg);
                        $estadoConfirImagenes = true;
                    } else {
                        $estadoConfirImagenes = false;
                    }
                }
            }

            if ($estadoConfirServicios && $estadoConfirImagenes) {
                header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
                $_SESSION['msj2'] = "Se registró exitosamente";
            } else {
                header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
                $_SESSION['msj2'] = "Ocurrió un error";
            }
        } else {
            header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
            $_SESSION['msj2'] = "Ocurrió un error";
        }
    }
} else {
    header("location: ../../../vistas/vistasAdmin/regTipoHabitacion.php");
    $_SESSION['msj2'] = "Campos vacios";
}
