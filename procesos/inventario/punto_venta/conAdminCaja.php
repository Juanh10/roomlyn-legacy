<?php

// Incluir la configuración de conexión y establecer la zona horaria
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");

session_start();

// Verificar que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Detectar la operación a realizar
    $fechaActual = new DateTime();
    $fechaYHora = $fechaActual->format('Y-m-d H:i:s');
    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        // INSERT
        if ($action === "insert") {
            if (isset($_POST['nombreCaja']) && isset($_POST['ubicacionCaja']) && isset($_POST['contrasena']) && isset($_POST['contrasenaTwo'])) {
                $nombre = $_POST['nombreCaja'];
                $ubicacion = $_POST['ubicacionCaja'];
                $clave = $_POST['contrasena'];
                $claveConfir = $_POST['contrasenaTwo'];
                $estado = 1;

                // Verificar si las contraseñas coinciden
                if ($clave === $claveConfir) {
                    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

                    $sqlInsert = $dbh->prepare("INSERT INTO inventario_punto_venta(nombre, ubicacion, contrasena, estado, fecha_sys) VALUES (:nom, :ubi, :cont, :est, :fech)");
                    $sqlInsert->bindParam(':nom', $nombre);
                    $sqlInsert->bindParam(':ubi', $ubicacion);
                    $sqlInsert->bindParam(':cont', $claveHash);
                    $sqlInsert->bindParam(':est', $estado);
                    $sqlInsert->bindParam(':fech', $fechaYHora);

                    if ($sqlInsert->execute()) {
                        $_SESSION['msjExito'] = "Caja registrada exitosamente.";
                    } else {
                        $_SESSION['msjError'] = "Error al registrar la caja.";
                    }
                } else {
                    $_SESSION['msjError'] = "Las contraseñas no coinciden.";
                }
            } else {
                $_SESSION['msjError'] = "Campos vacíos. Por favor, llena los campos requeridos.";
            }
        }

        // UPDATE
        elseif ($action === "update") {
            if (isset($_POST['idCaja']) && isset($_POST['nombreEditCaja']) && isset($_POST['ubicacionEditCaja']) && empty($_POST['contrasenaEdit'])) {
                $idCaja = $_POST['idCaja'];
                $nombre = $_POST['nombreEditCaja'];
                $ubicacion = $_POST['ubicacionEditCaja'];

                $sqlUpdate = $dbh->prepare("UPDATE inventario_punto_venta SET nombre = :nom, ubicacion = :ubi, fecha_sys = :fech WHERE id_punto_venta = :id");
                $sqlUpdate->bindParam(':nom', $nombre);
                $sqlUpdate->bindParam(':ubi', $ubicacion);
                $sqlUpdate->bindParam(':fech', $fechaYHora);
                $sqlUpdate->bindParam(':id', $idCaja);

                if ($sqlUpdate->execute()) {
                    $_SESSION['msjExito'] = "Caja actualizada exitosamente.";
                } else {
                    $_SESSION['msjError'] = "Error al actualizar la caja.";
                }
            } else if(isset($_POST['idCaja']) && isset($_POST['contrasenaEdit']) && isset($_POST['contrasenaTwoEdit'])) {

                $idCaja = $_POST['idCaja'];
                $clave = $_POST['contrasenaEdit'];
                $claveConfir = $_POST['contrasenaTwoEdit'];

                // Verificar si las contraseñas coinciden
                if ($clave === $claveConfir) {
                    $claveHash = password_hash($clave, PASSWORD_DEFAULT);

                    $sqlUpdate = $dbh->prepare("UPDATE inventario_punto_venta SET contrasena = :contra, fecha_sys = :fech WHERE id_punto_venta = :id");
                    $sqlUpdate->bindParam(':contra', $claveHash);
                    $sqlUpdate->bindParam(':fech', $fechaYHora);
                    $sqlUpdate->bindParam(':id', $idCaja);

                    if ($sqlUpdate->execute()) {
                        $_SESSION['msjExito'] = "Contraseña actualizada exitosamente.";
                    } else {
                        $_SESSION['msjError'] = "Error al registrar la caja.";
                    }
                } else {
                    $_SESSION['msjError'] = "Las contraseñas no coinciden.";
                }

            }else{
                $_SESSION['msjError'] = "Campos vacíos. Por favor, llena los campos requeridos.";
            }
        }

        // DELETE
        elseif ($action === "delete") {
            if (isset($_POST['idCaja'])) {
                $idCaja = $_POST['idCaja'];
                $estado = 0;

                $sqlDelete = $dbh->prepare("UPDATE inventario_punto_venta SET estado = :est, fecha_sys = :fech WHERE id_punto_venta = :id");
                $sqlDelete->bindParam(':est', $estado);
                $sqlDelete->bindParam(':fech', $fechaYHora);
                $sqlDelete->bindParam(':id', $idCaja);

                if ($sqlDelete->execute()) {
                    $_SESSION['msjExito'] = "Caja deshabilitada exitosamente.";
                } else {
                    $_SESSION['msjError'] = "Error al deshabilitar la caja.";
                }
            } else {
                $_SESSION['msjError'] = "No se proporcionó el ID de la caja.";
            }
        }

        // Redirigir después de completar la operación
        header("location: ../../../vistas/vistasAdmin/inventarioAdministrarPuntoVenta.php");
        exit;
    } else {
        $_SESSION['msjError'] = "Operación no válida.";
        header("location: ../../../vistas/vistasAdmin/inventarioAdministrarPuntoVenta.php");
        exit;
    }
} else {
    // Redirigir si no se accede por POST
    header("location: ../../../vistas/vistasAdmin/inventarioAdministrarPuntoVenta.php");
    exit;
}
