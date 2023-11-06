<?php

session_start();

include_once "../config/conex.php";

$urlActual = $_SERVER['HTTP_REFERER'];

if (!empty($_POST['tipoHab']) && !empty($_POST['habitacion']) && !empty($_POST['idCliente']) && !empty($_POST['checkIn']) && !empty($_POST['checkOut'])) {

    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $tipoHab = $_POST['tipoHab'];
    $habitacion = $_POST['habitacion'];
    $cliente = $_POST['idCliente'];
    $estadoRegistro = 1;
    $estado = 1;

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

        $sqlInforReserva = $dbh->prepare("INSERT INTO reservas(id_cliente, id_habitaciones, id_estado_reserva, fecha_ingreso, fecha_salida, total_reserva, estado, fecha_sys) VALUES (:id_cliente,:id_habitaciones, :id_estado_reserva,:fecha_ingreso,:fecha_salida,:total_reserva,:estado,now())");

        $sqlActHabitacion = $dbh->prepare("UPDATE habitaciones SET id_hab_estado = 5 WHERE nHabitacion = :habitacion");

        $sqlInforReserva->bindParam(':id_cliente', $cliente);
        $sqlInforReserva->bindParam(':id_habitaciones', $habitacion);
        $sqlInforReserva->bindParam(':id_estado_reserva', $estado);
        $sqlInforReserva->bindParam(':fecha_ingreso', $checkIn);
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
        $_SESSION['msjReservas'] = "La fecha de llegada debe ser anterior a la fecha de salida. Por favor, corrige las fechas.";
        header("Location: $urlActual");
        exit;
    }
}
