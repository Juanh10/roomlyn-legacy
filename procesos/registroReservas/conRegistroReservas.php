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

    $diasAntelacionMaxima = 15;

    // Convertir las fechas a marcas de tiempo
    $marcaTiempoCheckIn = strtotime($checkIn);
    $marcaTiempoCheckOut = strtotime($checkOut);
    $marcaTiempoHoy = strtotime('today midnight');

    // Calcular la diferencia en días desde hoy hasta la fecha de entrada
    $diasAntelacion = floor(($marcaTiempoCheckIn - $marcaTiempoHoy) / (60 * 60 * 24));

    if ($checkIn < $checkOut) { // VALIDAR LAS FECHAS YA QUE TIENE QUE SER MENOR LE FECHA DE ENTRADA A LA DE SALIDA

        if ($diasAntelacion > $diasAntelacionMaxima) {
            $_SESSION['msjReservas'] = "La reserva no puede realizarse con más de {$diasAntelacionMaxima} días de antelación.";
            header("Location: $urlActual");
            exit;
        } else {
            $estadoHab = 5;

            // CONSULTA PARA OBTENER EL TOTAL DE LA RESERVA

            $sqlHabitacion = "SELECT id_habitacion, id_hab_estado, id_servicio, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE id_habitacion = " . $habitacion . " AND estado = 1";

            $rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

            $servHabitacion = $rowHabitacion['id_servicio'];

            $sqlPrecioVentilador = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = " . $tipoHab . " AND hts.id_servicio = " . $servHabitacion . " AND htp.estado = 1 AND hts.estado = 1";

            $sqlPrecioAire = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = " . $tipoHab . " AND hts.id_servicio = " . $servHabitacion . " AND htp.estado = 1 AND hts.estado = 1";

            $rowPrecioVentilador = $dbh->query($sqlPrecioVentilador)->fetch();
            $rowPrecioAire = $dbh->query($sqlPrecioAire)->fetch();

            $sqlTipoHab = "SELECT id_hab_tipo, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $tipoHab . " AND estado = 1";

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

            if ($rowHabitacion['id_servicio'] == 1) {

                $precioTipo = $rowPrecioVentilador['precio'];

                $subtotal1 = $precioTipo * $diferenciaDias;

                //$iva = $subtotal1 * 0.19;

                //$totalFactura = $subtotal1 + $iva;
                $totalFactura = $subtotal1;
            } else {
                $precioTipo = $rowPrecioAire['precio'];

                $subtotal1 = $precioTipo * $diferenciaDias;

                //$iva = $subtotal1 * 0.19;

                //$totalFactura = $subtotal1 + $iva;
                $totalFactura = $subtotal1;
            }

            // CONSULTAS PARA INSERTAR LOS REGISTROS

            $sqlInforCliente = $dbh->prepare("INSERT INTO info_clientes(id_nacionalidad, id_departamento, id_municipio, documento, nombres, apellidos, celular, sexo, email, estadoRegistro, estado, fecha_reg, hora_reg, fecha_update) VALUES (:id_nacionalidad,:id_departamento,:id_municipio,:documento,:nombres,:apellidos,:celular,:sexo,:email,:estadoRegistro,:estado,:fecha,:hora,now())"); // preparar la consulta

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

            $sqlInforReserva = $dbh->prepare("INSERT INTO reservas(id_cliente, id_habitacion, id_estado_reserva, fecha_ingreso, fecha_salida, total_reserva, estado, fecha_sys) VALUES (:id_cliente,:id_habitaciones, :id_estado_reserva,:fecha_ingreso,:fecha_salida,:total_reserva,:estado,now())");

            $sqlActHabitacion = $dbh->prepare("UPDATE habitaciones SET id_hab_estado = :estadoHab WHERE id_habitacion = :habitacion");

            if ($sqlInforCliente->execute()) {
                $ultIDCliente = $dbh->lastInsertId('info_clientes'); // obtener el ultimo ID de la tabla infoClientes

                // ENLAZAR LOS MARCADORES DE LA CONSULTA DE LA INFORMACION DE LA RESERVA CON LAS VARIABLES

                $sqlInforReserva->bindParam(':id_cliente', $ultIDCliente);
                $sqlInforReserva->bindParam(':id_habitaciones', $habitacion);
                $sqlInforReserva->bindParam(':id_estado_reserva', $estado);
                $sqlInforReserva->bindParam(':fecha_ingreso', $checkIn);
                $sqlInforReserva->bindParam(':fecha_salida', $checkOut);
                $sqlInforReserva->bindParam(':total_reserva', $totalFactura);
                $sqlInforReserva->bindParam(':estado', $estado);

                if ($sqlInforReserva->execute()) {


                    $sqlActHabitacion->bindParam(':estadoHab', $estadoHab);
                    $sqlActHabitacion->bindParam(':habitacion', $habitacion);

                    if ($sqlActHabitacion->execute()) {
                        $_SESSION['msjReservasExito'] = "";
                        header("Location: ../../vistas/pagHabitaciones.php");
                        exit;
                    } else {
                        $_SESSION['msjReservas'] = "Se ha producido un error en el proceso de registro de la reserva. Te solicitamos amablemente que nos contactes a través del correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                        header("Location: $urlActual");
                        exit;
                    }
                } else {
                    $_SESSION['msjReservas'] = "Se ha producido un error en el proceso de registro de la reserva. Te solicitamos amablemente que nos contactes a través del correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                    header("Location: $urlActual");
                    exit;
                }
            } else {
                $_SESSION['msjReservas'] = "Se ha producido un error en el proceso de registro de la reserva. Te solicitamos amablemente que nos contactes a través del correo electrónico roomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("Location: $urlActual");
                exit;
            }
        }
    } else {
        $_SESSION['msjReservas'] = "La fecha de llegada debe ser anterior a la fecha de salida. Por favor, corrige las fechas.";
        header("Location: $urlActual");
        exit;
    }
} else {
    $_SESSION['msjReservas'] = "Campos vacíos. Por favor, completa todos los campos obligatorios antes de continuar.";
    header("Location: $urlActual");

    exit;
}