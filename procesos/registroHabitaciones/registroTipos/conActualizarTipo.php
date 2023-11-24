<?php

include_once "../../config/conex.php";

function actualizarTipoHab($dbh, $nombreTipo, $cantidadCamas, $cantidadPersonas, $idTipoHab, $precioVentilador, $precioAire)
{
    try {
        // Estado para las inserciones y actualizaciones
        $estado = 1;

        // Actualizar la información básica del tipo de habitación
        $sql = $dbh->prepare("UPDATE habitaciones_tipos SET tipoHabitacion = :tipoHab, cantidadCamas = :cantidadCama, capacidadPersonas = :cantidadPersona WHERE id_hab_tipo = :idTipo");
        $sql->bindParam(':tipoHab', $nombreTipo);
        $sql->bindParam(':cantidadCama', $cantidadCamas);
        $sql->bindParam(':cantidadPersona', $cantidadPersonas);
        $sql->bindParam(':idTipo', $idTipoHab);

        // Verificar si la actualización fue exitosa
        if (!$sql->execute()) {
            throw new Exception("Ocurrió un error al actualizar la información básica.");
        }

        // Consultar el id_tipo_servicio asociado al servicio de ventilador
        $sqlConsultaTipoServicio = "SELECT id_tipo_servicio FROM habitaciones_tipos_servicios WHERE id_hab_tipo = " . $idTipoHab . " AND id_servicio = 1 AND estado = 1";
        $resulTipoServ = $dbh->query($sqlConsultaTipoServicio)->fetch();
        $idTipoSerVentilador = $resulTipoServ['id_tipo_servicio'];

        $sqlConsultaPrecioVent = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON htp.id_tipo_servicio = hts.id_tipo_servicio WHERE hts.id_hab_tipo = " . $idTipoHab . " AND hts.id_servicio = 1 AND htp.precio = " . $precioVentilador . " AND htp.estado = 1";

        $resConsultaPrecio = $dbh->query($sqlConsultaPrecioVent);

        if ($resConsultaPrecio->rowCount() == 0) {
            // Desactivar el precio anterior del servicio de ventilador
            $sqlUpdatePrecioVent = "UPDATE habitaciones_tipos_precios SET estado = 0 WHERE id_tipo_servicio = " . $idTipoSerVentilador . " AND estado = 1";

            if (!$dbh->query($sqlUpdatePrecioVent)) {
                throw new Exception("Ocurrió un error al desactivar el precio anterior.");
            }

            // Insertar el nuevo precio del servicio de ventilador
            $sqlPrecioVentilador = $dbh->prepare("INSERT INTO habitaciones_tipos_precios(id_tipo_servicio, precio, estado, fecha_sys) VALUES (:idTipServ, :precio, :estado, now())");
            $sqlPrecioVentilador->bindParam(':idTipServ', $idTipoSerVentilador);
            $sqlPrecioVentilador->bindParam(':precio', $precioVentilador);
            $sqlPrecioVentilador->bindParam(':estado', $estado);

            // Verificar si la inserción del nuevo precio fue exitosa
            if (!$sqlPrecioVentilador->execute()) {
                throw new Exception("Ocurrió un error al insertar el nuevo precio.");
            }
        }

        // Consultar el id_tipo_servicio asociado al servicio de aire
        $sqlConsultaTipoServicioAire = "SELECT id_tipo_servicio FROM habitaciones_tipos_servicios WHERE id_hab_tipo = " . $idTipoHab . " AND id_servicio = 2 AND estado = 1";
        $resulTipoServAire = $dbh->query($sqlConsultaTipoServicioAire)->fetch();
        $idTipoSerAire = $resulTipoServAire['id_tipo_servicio'];

        $sqlConsultaPrecioAire = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON htp.id_tipo_servicio = hts.id_tipo_servicio WHERE hts.id_hab_tipo = " . $idTipoHab . " AND hts.id_servicio = 2 AND htp.precio = " . $precioAire . " AND htp.estado = 1";

        $resConsultaPrecioAire = $dbh->query($sqlConsultaPrecioAire);

        if ($resConsultaPrecioAire->rowCount() == 0) {
            // Desactivar el precio anterior del servicio de aire
            $sqlUpdatePrecioAire = "UPDATE habitaciones_tipos_precios SET estado = 0 WHERE id_tipo_servicio = " . $idTipoSerAire . " AND estado = 1";

            if (!$dbh->query($sqlUpdatePrecioAire)) {
                throw new Exception("Ocurrió un error al desactivar el precio anterior del aire.");
            }

            // Insertar el nuevo precio del servicio de aire
            $sqlPrecioAire = $dbh->prepare("INSERT INTO habitaciones_tipos_precios(id_tipo_servicio, precio, estado, fecha_sys) VALUES (:idTipServ, :precio, :estado, now())");
            $sqlPrecioAire->bindParam(':idTipServ', $idTipoSerAire);
            $sqlPrecioAire->bindParam(':precio', $precioAire);
            $sqlPrecioAire->bindParam(':estado', $estado);

            // Verificar si la inserción del nuevo precio fue exitosa
            if (!$sqlPrecioAire->execute()) {
                throw new Exception("$_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";");
            }
        }

        // Redireccionar con mensaje de éxito
        $_SESSION['msjExito'] = "Datos actualizados correctamente";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab);
    } catch (Exception $e) {
        // Manejar errores y redireccionar con mensaje de error
        $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab);
    }
}

// Verificar si se ha enviado el formulario de actualización
if (isset($_POST['actTipo'])) {

    session_start();

    // Verificar que los campos del formulario no estén vacíos
    if (!empty($_POST['nombreTipo']) && !empty($_POST['cantidadCamas']) && !empty($_POST['cantidadPersonas']) && !empty($_POST['precioVentilador']) && !empty($_POST['precioAire'])) {

        // Capturar los datos del formulario
        $idTipoHab = $_POST['idTipoHab'];
        $nombreTipo = $_POST['nombreTipo'];
        $cantidadCamas = $_POST['cantidadCamas'];
        $cantidadPersonas = $_POST['cantidadPersonas'];
        $precioVentilador = $_POST['precioVentilador'];
        $precioAire = $_POST['precioAire'];
        $existe = false; // Booleano para saber si existe el tipo de habitación 

        // Consultar el tipo de habitación actual
        $consultaTipo = $dbh->prepare("SELECT id_hab_tipo, tipoHabitacion, estado FROM habitaciones_tipos WHERE id_hab_tipo = :idTipo");
        $consultaTipo->bindParam(":idTipo", $idTipoHab);
        $consultaTipo->execute(); // Ejecutar la consulta
        $fila1 = $consultaTipo->fetch(); // Obtener datos de la consulta

        // Verificar si el nombre del tipo de habitación ha cambiado
        if ($fila1['tipoHabitacion'] != $nombreTipo) {
            // Consultar si ya existe un tipo de habitación con el nuevo nombre
            $consulta2 = $dbh->prepare("SELECT id_hab_tipo, tipoHabitacion, estado FROM habitaciones_tipos WHERE tipoHabitacion = :nmTipo");
            $consulta2->bindParam("nmTipo", $nombreTipo);
            $consulta2->execute(); // Ejecutar la consulta
            $fila2 = $consulta2->fetch(); // Obtener datos de la consulta

            // Verificar si ya existe un tipo de habitación con el nuevo nombre y está activo
            if ($consulta2->rowCount() > 0 && $fila2['estado'] == 1) {
                $_SESSION['msjError'] = "Error: El tipo de habitación ya ha sido registrado anteriormente.";
                header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
                $existe = true;
            } else {
                // Si no existe, actualizar el tipo de habitación
                if (!$existe) {
                    actualizarTipoHab($dbh, $nombreTipo, $cantidadCamas, $cantidadPersonas, $idTipoHab, $precioVentilador, $precioAire);
                }
            }
        } else {
            // Si el nombre no ha cambiado, actualizar el tipo de habitación directamente
            actualizarTipoHab($dbh, $nombreTipo, $cantidadCamas, $cantidadPersonas, $idTipoHab, $precioVentilador, $precioAire);
        }
    } else {
        // Si hay campos vacíos, mostrar un mensaje de error
        $_SESSION['msjError'] = "Campos vacíos. Por favor llena todos los campos.";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
    }
}



// Eliminar los servicios de los tipos de habitaciones

if (isset($_POST['btnElmServ'])) {

    session_start();

    if (!empty($_POST['idServicio'])) {

        $idServicios = $_POST['idServicio'];
        $idTipoHab = $_POST['idTipoHab'];

        $estadoElmServ = 0;

        $sqlElmServ = $dbh->prepare("UPDATE habitaciones_tipos_servicios SET estado=:estado WHERE id_tipo_servicio = :idServ"); // consulta sql

        $sqlElmServ->bindParam(':estado', $estadoElmServ); // vincular los marcadores con las variables
        $sqlElmServ->bindParam(':idServ', $idServicios);

        // ejecutamos la consulta 
        if ($sqlElmServ->execute()) {
            $_SESSION['msjExito'] = "¡Se ha deshabilitado correctamente!";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        } else {
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }
    } else {
        $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
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

            $sql = $dbh->prepare("INSERT INTO habitaciones_tipos_servicios(id_hab_tipo, id_servicio, estado, fecha_sys) VALUES (:idTipoHab, :idElemento, :estado, now())"); // consulta sql

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
                header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
            } else {
                $_SESSION['msjExito'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
            }
        } else {
            $_SESSION['msjError'] = "Debes seleccionar al menos un servicio";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }
    } else {
        $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
    }
}
