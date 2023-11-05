<?php
include_once "../config/conex.php";
date_default_timezone_set("America/Bogota");
session_start();

// Obtener la URL de la pagina actual
$urlActual = $_SERVER['HTTP_REFERER'];

if (!empty($_POST['tipoHab']) && !empty($_POST['habitacion']) && !empty($_POST['nombres']) && !empty($_POST['apellidos']) && !empty($_POST['checkIn']) && !empty($_POST['checkOut']) && !empty($_POST['documento']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['sexo']) && !empty($_POST['nacionalidad']) && !empty($_POST['departamento']) && !empty($_POST['ciudad'])) {

    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $documento = $_POST['documento'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
    $nacionalidad = $_POST['nacionalidad'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];
    $tipoHab = $_POST['tipoHab'];
    $habitacion = $_POST['habitacion'];
    $estadoRegistro = 0;
    $estado = 1;
    $fecha = date('Y-m-d'); // Obtener la fecha actual
    $hora = date('H:i:s'); // obtener la hora actual

    if ($checkIn < $checkOut) { // VALIDAR LAS FECHAS YA QUE TIENE QUE SER MENOR LE FECHA DE ENTRADA A LA DE SALIDA

        // CONSULTA PARA OBTENER EL TOTAL DE LA RESERVA

        $sqlHabitacion = "SELECT id_habitaciones, id_hab_estado, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, tipoServicio, observacion, estado FROM habitaciones WHERE id_habitaciones = " . $habitacion . " AND estado = 1";

        $rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

        $sqlTipoHab = "SELECT id_hab_tipo, precioVentilador, precioAire, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $tipoHab . " AND estado = 1";

        $rowTipoHab = $dbh->query($sqlTipoHab)->fetch();

        // CONVERTIR FECHAS EN DIAS
        $timestampInicio = strtotime($checkIn);
        $timestampFin = strtotime($checkOut);

        // Calcular la diferencia en segundos
        $diferenciaSegundos = $timestampFin - $timestampInicio;

        // Convertir la diferencia en segundos a días
        $diferenciaDias = $diferenciaSegundos / 86400;

        $diferenciaDias = round($diferenciaDias);

        $total = 0;

        if ($rowHabitacion['tipoServicio'] == 0) {

            $precioTipo = $rowTipoHab['precioVentilador'];

            $subtotal1 = $precioTipo * $diferenciaDias;

            $iva = $subtotal1 * 0.19;

            $totalFactura = $subtotal1 + $iva;
        } else {
            $precioTipo = $rowTipoHab['precioAire'];

            $subtotal1 = $precioTipo * $diferenciaDias;

            $iva = $subtotal1 * 0.19;

            $totalFactura = $subtotal1 + $iva;
        }

        // CONSULTA PARA VERIFICAR SI EL CLIENTE YA ESTA REGISTRADO EN LA BD



        // CONSULTAS PARA INSERTAR LOS REGISTROS

        $sqlInforCliente = $dbh->prepare("INSERT INTO info_clientes(id_nacionalidad, id_departamento, id_municipio, documento, nombres, apellidos, celular, sexo, email, estadoRegistro, estado, fecha, hora, fecha_sys) VALUES (:id_nacionalidad,:id_departamento,:id_municipio,:documento,:nombres,:apellidos,:celular,:sexo,:email,:estadoRegistro,:estado,:fecha,:hora,now())"); // preparar la consulta

        // ENLAZAR LOS MARCADORES CON LAS VARIABLES

        $sqlInforCliente->bindParam(':id_nacionalidad', $nacionalidad);
        $sqlInforCliente->bindParam(':id_departamento', $departamento);
        $sqlInforCliente->bindParam(':id_municipio', $ciudad);
        $sqlInforCliente->bindParam(':documento', $documento);
        $sqlInforCliente->bindParam(':nombres', $nombres);
        $sqlInforCliente->bindParam(':apellidos', $apellidos);
        $sqlInforCliente->bindParam(':celular', $telefono);
        $sqlInforCliente->bindParam(':sexo', $sexo);
        $sqlInforCliente->bindParam(':email', $email);
        $sqlInforCliente->bindParam(':estadoRegistro', $estadoRegistro);
        $sqlInforCliente->bindParam(':estado', $estado);
        $sqlInforCliente->bindParam(':fecha', $fecha);
        $sqlInforCliente->bindParam(':hora', $hora);

        $sqlInforReserva = $dbh->prepare("INSERT INTO reservas(id_cliente, id_habitaciones, id_estado_reserva, fecha_ingreso, fecha_salida, total_reserva, estado, fecha_sys) VALUES (:id_cliente,:id_habitaciones, :id_estado_reserva,:fecha_ingreso,:fecha_salida,:total_reserva,:estado,now())");

        $sqlActHabitacion = $dbh->prepare("UPDATE habitaciones SET id_hab_estado = 5 WHERE nHabitacion = :habitacion");

        if ($sqlInforCliente->execute()) {
            $ultIDCliente = $dbh->lastInsertId('info_clientes'); // obtener el ultimo ID de la tabla infoClientes

            // ENLAZAR LOS MARCADORES DE LA CONSULTA DE LA INFORMACION DE LA RESERVA CON LAS VARIABLES

            $sqlInforReserva->bindParam(':id_cliente', $ultIDCliente);
            $sqlInforReserva->bindParam(':id_habitaciones', $habitacion);
            $sqlInforReserva->bindParam(':id_estado_reserva', $estado);
            $sqlInforReserva->bindParam(':fecha_ingreso', $checkIn);
            $sqlInforReserva->bindParam(':fecha_salida', $checkOut);
            $sqlInforReserva->bindParam(':fecha_salida', $checkOut);
            $sqlInforReserva->bindParam(':total_reserva', $totalFactura);
            $sqlInforReserva->bindParam(':estado', $estado);

            if ($sqlInforReserva->execute()) {


                $sqlActHabitacion->bindParam(':habitacion', $habitacion);

                if ($sqlActHabitacion->execute()) {
                    $_SESSION['msjReservasExito'] = "";
                    header("Location: ../../vistas/pagHabitaciones.php");
                    exit;
                } else {
                    $_SESSION['msjReservas'] = "Ocurrió un error";
                    header("Location: $urlActual");
                    exit;
                }
            } else {
                $_SESSION['msjReservas'] = "Ocurrió un error";
                header("Location: $urlActual");
                exit;
            }
        } else {
            $_SESSION['msjReservas'] = "Ocurrió un error";
            header("Location: $urlActual");
            exit;
        }
    } else {
        $_SESSION['msjReservas'] = "La fecha de llegada debe ser anterior a la fecha de salida. Por favor, corrige las fechas.";
        header("Location: $urlActual");
        exit;
    }
} else {
    $_SESSION['msjReservas'] = "Campos vacíos";

    header("Location: $urlActual");

    exit;
}
