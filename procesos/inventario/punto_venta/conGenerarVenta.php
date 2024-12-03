<?php

// Incluir la configuración de conexión y establecer la zona horaria
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");

// Establecer el encabezado de respuesta como JSON
header('Content-Type: application/json');

session_start();

// Verificar si hay sesión activa del empleado
if (!isset($_SESSION['id_empleado'])) {
    echo json_encode(["status" => "error", "message" => "Sesión no iniciada."]);
    exit;
}

$idEmpleado = $_SESSION['id_empleado'];

// Validar el método de la solicitud
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Validar que se reciban los datos requeridos
    if (isset($_POST['caja'], $_POST['tipoCliente'], $_POST['productos'])) {
        $caja = $_POST['caja'];
        $tipoCliente = $_POST['tipoCliente'];
        $productosJson = $_POST['productos'];

        // Convertir el JSON a un arreglo
        $productosArray = json_decode($productosJson, true);

        if (!$productosArray || !is_array($productosArray)) {
            echo json_encode(["status" => "error", "message" => "Formato de productos inválido."]);
            exit;
        }

        // Manejar cliente por tipo
        $idReserva = null;
        if ($tipoCliente != 0) {
            $sqlReserva = $dbh->prepare("SELECT id_reserva FROM reservas WHERE id_habitacion = :habitacion AND id_estado_reserva = 2");
            $sqlReserva->bindParam(':habitacion', $tipoCliente);
            $sqlReserva->execute();
            $reserva = $sqlReserva->fetch();

            if ($reserva) {
                $idReserva = $reserva['id_reserva'];
            } else {
                echo json_encode(["status" => "error", "message" => "No se encontró una reserva activa para esta habitación."]);
                exit;
            }
        }

        // Registrar la venta
        $totalVenta = 0;
        $fechaVenta = date('Y-m-d');
        $horaVenta = date('H:i:s');
        $estadoVenta = 1; // Activo
        $idEstadoVenta = 2; // Finalizada por defecto

        $sqlVenta = $dbh->prepare("
            INSERT INTO inventario_ventas (id_empleado, id_reserva, id_punto_venta, id_estado, total_venta, hora_venta, fecha_venta, estado, fecha_sys)
            VALUES (:idUsuario, :idReserva, :idPuntoVenta, :idEstado, :totalVenta, :horaVenta, :fechaVenta, :estado, NOW())
        ");
        $sqlVenta->bindParam(':idUsuario', $idEmpleado);
        $sqlVenta->bindParam(':idReserva', $idReserva);
        $sqlVenta->bindParam(':idPuntoVenta', $caja);
        $sqlVenta->bindParam(':idEstado', $idEstadoVenta);
        $sqlVenta->bindParam(':totalVenta', $totalVenta);
        $sqlVenta->bindParam(':horaVenta', $horaVenta);
        $sqlVenta->bindParam(':fechaVenta', $fechaVenta);
        $sqlVenta->bindParam(':estado', $estadoVenta);

        if ($sqlVenta->execute()) {
            $idVenta = $dbh->lastInsertId();

            // Procesar cada producto
            foreach ($productosArray as $producto) {
                $idProducto = $producto['id'];
                $cantidad = $producto['cantidad'];
                $estadoDebe = $producto['pagar'] ? 0 : 1;

                if ($estadoDebe == 1) {
                    $idEstadoVenta = 1; // Cambiar el estado a pendiente
                }

                // Verificar y actualizar productos
                $sqlProductos = $dbh->prepare("
                    SELECT id_producto, nombre, precio_unitario, cantidad_stock 
                    FROM inventario_productos 
                    WHERE id_producto = :idProducto AND estadoProducto = 1 AND estado = 1
                ");
                $sqlProductos->bindParam(':idProducto', $idProducto);
                $sqlProductos->execute();
                $datosProducto = $sqlProductos->fetch();

                if ($datosProducto) {
                    $nombreProducto = $datosProducto['nombre'];
                    $precioUnitario = $datosProducto['precio_unitario'];
                    $cantidadStock = $datosProducto['cantidad_stock'];

                    if ($cantidadStock >= $cantidad) {
                        $precioTotal = $cantidad * $precioUnitario;

                        $sqlDetalleVenta = $dbh->prepare("
                            INSERT INTO inventario_detalles_ventas (id_venta, id_producto, cantidad_producto, precio_unitario, precio_total, estado_debe, estado, fecha_sys)
                            VALUES (:idVenta, :idProducto, :cantidadProducto, :precioUnitario, :precioTotal, :estadoDebe, :estado, NOW())
                        ");
                        $sqlDetalleVenta->bindParam(':idVenta', $idVenta);
                        $sqlDetalleVenta->bindParam(':idProducto', $idProducto);
                        $sqlDetalleVenta->bindParam(':cantidadProducto', $cantidad);
                        $sqlDetalleVenta->bindParam(':precioUnitario', $precioUnitario);
                        $sqlDetalleVenta->bindParam(':precioTotal', $precioTotal);
                        $sqlDetalleVenta->bindParam(':estadoDebe', $estadoDebe);
                        $sqlDetalleVenta->bindParam(':estado', $estadoVenta);

                        if ($sqlDetalleVenta->execute()) {
                            // Actualizar stock
                            $nuevoStock = $cantidadStock - $cantidad;
                            $sqlUpdateStock = $dbh->prepare("UPDATE inventario_productos SET cantidad_stock = :nuevoStock WHERE id_producto = :idProducto");
                            $sqlUpdateStock->bindParam(':nuevoStock', $nuevoStock);
                            $sqlUpdateStock->bindParam(':idProducto', $idProducto);
                            $sqlUpdateStock->execute();

                            $totalVenta += $precioTotal;
                        } else {
                            echo json_encode(["status" => "error", "message" => "Error al registrar el detalle de la venta."]);
                            exit;
                        }
                    } else {
                        echo json_encode(["status" => "error", "message" => "Stock insuficiente para el producto $nombreProducto."]);
                        exit;
                    }
                } else {
                    echo json_encode(["status" => "error", "message" => "Producto $nombreProducto no encontrado."]);
                    exit;
                }
            }

            // Actualizar el total y el estado de la venta
            $sqlUpdateVenta = $dbh->prepare("UPDATE inventario_ventas SET total_venta = :totalVenta, id_estado = :idEstado WHERE id_venta = :idVenta");
            $sqlUpdateVenta->bindParam(':totalVenta', $totalVenta);
            $sqlUpdateVenta->bindParam(':idEstado', $idEstadoVenta);
            $sqlUpdateVenta->bindParam(':idVenta', $idVenta);
            $sqlUpdateVenta->execute();

            echo json_encode(["status" => "success", "message" => "Venta registrada exitosamente."]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error al registrar la venta."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Campos incompletos."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Método no permitido."]);
}