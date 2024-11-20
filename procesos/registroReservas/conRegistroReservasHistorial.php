<?php

// Incluir la conexion y ajustar la zona horaria a Bogota e iniciar una sesion
include_once "../config/conex.php";
date_default_timezone_set("America/Bogota");
session_start();

// Obtener la URL de la pagina actual
$urlActual = $_SERVER['HTTP_REFERER'];

// Validar si los campos están vacíos
if (!empty($_POST['tipoHab']) && !empty($_POST['habitacion']) && !empty($_POST['nombres']) && !empty($_POST['apellidos']) && !empty($_POST['checkIn']) && !empty($_POST['checkOut']) && !empty($_POST['documento']) && !empty($_POST['telefono']) && !empty($_POST['email']) && !empty($_POST['sexo']) && !empty($_POST['nacionalidad']) && !empty($_POST['departamento']) && !empty($_POST['ciudad'])) {
    // Capturar todos los valores que se reciben del formulario
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
    $totalFacturaRes = $_POST['totalFactura'];
    $montoReserva = $_POST['montoReserva'];
    $estadoReserva = $_POST['estadoRes'] ?? 0;
    $estadoRegistro = 0;
    $estado = 1;
    $fecha = date('Y-m-d'); // Obtener la fecha actual
    $hora = date('H:i:s'); // Obtener la hora actual
    $diasAntelacionMaxima = 15;

    // Convertir las fechas a marcas de tiempo
    $marcaTiempoCheckIn = strtotime($checkIn);
    $marcaTiempoCheckOut = strtotime($checkOut);
    $marcaTiempoHoy = strtotime('today midnight');

    // Calcular la diferencia en días desde hoy hasta la fecha de entrada
    $diasAntelacion = floor(($marcaTiempoCheckIn - $marcaTiempoHoy) / (60 * 60 * 24));

    if ($checkIn < $checkOut) { // Validar las fechas
        if ($diasAntelacion > $diasAntelacionMaxima) {
            echo json_encode(["status" => "error", "message" => "La reserva no puede realizarse con más de {$diasAntelacionMaxima} días de antelación."]);
            exit;
        } else {
            $estadoHab = 6;
            if ($estadoReserva != 0) {
                $estadoRes = $estadoReserva;
            } else {
                $estadoRes = 2;
            }

            // Consultar habitación
            $sqlHabitacion = "SELECT id_habitacion, id_hab_estado, id_servicio, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE id_habitacion = " . $habitacion . " AND estado = 1";
            $rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

            $servHabitacion = $rowHabitacion['id_servicio'];

            $sqlPrecioVentilador = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = " . $tipoHab . " AND hts.id_servicio = " . $servHabitacion . " AND htp.estado = 1 AND hts.estado = 1";
            $sqlPrecioAire = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = " . $tipoHab . " AND hts.id_servicio = " . $servHabitacion . " AND htp.estado = 1 AND hts.estado = 1";

            $rowPrecioVentilador = $dbh->query($sqlPrecioVentilador)->fetch();
            $rowPrecioAire = $dbh->query($sqlPrecioAire)->fetch();

            // Convertir fechas en días
            $timestampInicio = strtotime($checkIn);
            $timestampFin = strtotime($checkOut);

            // Calcular la diferencia en segundos
            $diferenciaSegundos = $timestampFin - $timestampInicio;

            // Convertir la diferencia en segundos a días
            $diferenciaDias = $diferenciaSegundos / 86400;
            $diferenciaDias = round($diferenciaDias);

            // Cálculo de total de reserva
            $total = 0;
            if ($totalFacturaRes != 0) {
                $totalFactura = $totalFacturaRes;
            } else {
                if ($rowHabitacion['id_servicio'] == 1) {
                    $precioTipo = $rowPrecioVentilador['precio'];
                    $subtotal1 = $precioTipo * $diferenciaDias;
                    $totalFactura = $subtotal1;
                } else {
                    $precioTipo = $rowPrecioAire['precio'];
                    $subtotal1 = $precioTipo * $diferenciaDias;
                    $totalFactura = $subtotal1;
                }
            }

            // Insertar información del cliente
            $sqlInforCliente = $dbh->prepare("INSERT INTO info_clientes(id_nacionalidad, id_departamento, id_municipio, documento, nombres, apellidos, celular, sexo, email, estadoRegistro, estado, fecha_reg, hora_reg, fecha_update) VALUES (:id_nacionalidad,:id_departamento,:id_municipio,:documento,:nombres,:apellidos,:celular,:sexo,:email,:estadoRegistro,:estado,:fecha,:hora,now())");

            // Enlazar los marcadores con las variables
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

            $sqlInforReserva = $dbh->prepare("INSERT INTO reservas(id_cliente, id_habitacion, id_estado_reserva, fecha_ingreso, fecha_salida, total_reserva, monto_abonado, estado, fecha_sys) VALUES (:id_cliente,:id_habitaciones, :id_estado_reserva,:fecha_ingreso,:fecha_salida,:total_reserva, :monto_abonado, :estado,now())");

            $sqlActHabitacion = $dbh->prepare("UPDATE habitaciones SET id_hab_estado = :estadoHab WHERE id_habitacion = :habitacion");

            if ($sqlInforCliente->execute()) {
                $ultIDCliente = $dbh->lastInsertId('info_clientes');

                // Enlazar los marcadores de la consulta de la información de la reserva con las variables
                $sqlInforReserva->bindParam(':id_cliente', $ultIDCliente);
                $sqlInforReserva->bindParam(':id_habitaciones', $habitacion);
                $sqlInforReserva->bindParam(':id_estado_reserva', $estadoRes);
                $sqlInforReserva->bindParam(':fecha_ingreso', $checkIn);
                $sqlInforReserva->bindParam(':fecha_salida', $checkOut);
                $sqlInforReserva->bindParam(':total_reserva', $totalFactura);
                $sqlInforReserva->bindParam(':monto_abonado', $montoReserva);
                $sqlInforReserva->bindParam(':estado', $estado);

                if ($sqlInforReserva->execute()) {
                    $sqlActHabitacion->bindParam(':estadoHab', $estadoHab);
                    $sqlActHabitacion->bindParam(':habitacion', $habitacion);

                    if ($sqlActHabitacion->execute()) {
                        echo json_encode(["status" => "success", "message" => "Reserva registrada con éxito."]);
                        exit;
                    } else {
                        echo json_encode(["status" => "error", "message" => "Se ha producido un error en el proceso de registro de la reserva."]);
                        exit;
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Se ha producido un error en el proceso de la reserva."]);
                    exit;
                }
            } else {
                echo json_encode(["status" => "error", "message" => "Se ha producido un error en el registro del cliente."]);
                exit;
            }
        }
    } else {
        echo json_encode(["status" => "error", "message" => "La fecha de salida no puede ser anterior a la fecha de entrada."]);
        exit;
    }
}
?>
