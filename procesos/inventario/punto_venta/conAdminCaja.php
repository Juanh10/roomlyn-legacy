<?php

// Incluir la configuración de conexión y establecer la zona horaria
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");

session_start();

// Verificar que la solicitud sea POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validar los campos recibidos
    if (isset($_POST['nombreCaja']) && isset($_POST['ubicacionCaja']) && isset($_POST['contrasena']) && isset($_POST['contrasenaTwo'])) {
        $nombre = $_POST['nombreCaja'];
        $ubicacion = $_POST['ubicacionCaja'];
        $clave = $_POST['contrasena'];
        $claveConfir = $_POST['contrasenaTwo'];
        $fechaActual = new DateTime();
        $fecha = $fechaActual->format('Y-m-d');
        $fechaYHora = $fechaActual->format('Y-m-d H:i:s');

        // Verificar si las contraseñas coinciden
        if ($clave === $claveConfir) {
            // Cifrar la contraseña antes de almacenarla
            $claveHash = password_hash($clave, PASSWORD_DEFAULT);
            
            // Preparar la consulta SQL para insertar los datos
            $sqlCaja = $dbh->prepare("INSERT INTO inventario_punto_venta(nombre, ubicacion, contrasena, fecha_sys) VALUES (:nom, :ubi, :cont, :fech)");

            // Bind de parámetros
            $sqlCaja->bindParam(':nom', $nombre);
            $sqlCaja->bindParam(':ubi', $ubicacion);
            $sqlCaja->bindParam(':cont', $claveHash);
            $sqlCaja->bindParam(':fech', $fechaYHora);

            // Ejecutar la consulta
            if ($sqlCaja->execute()) {
                // Redirigir con un mensaje de éxito
                $_SESSION['msjExito'] = "Caja registrada exitosamente.";
                header("location: ../../../vistas/vistasAdmin/inventarioAdministrarPuntoVenta.php");
                exit;
            } else {
                // Mensaje de error si la consulta falla
                $_SESSION['msjError'] = "Error al registrar la caja. Intenta de nuevo.";
                header("location: ../../../vistas/vistasAdmin/inventarioAdministrarPuntoVenta.php");
                exit;
            }
        } else {
            // Mensaje de error si las contraseñas no coinciden
            $_SESSION['msjError'] = "Las contraseñas no coinciden.";
            header("location: ../../../vistas/vistasAdmin/inventarioAdministrarPuntoVenta.php");
            exit;
        }
    } else {
        // Mensaje de error si faltan campos
        $_SESSION['msjError'] = "Campos vacíos. Por favor, llena los campos requeridos.";
        header("location: ../../../vistas/vistasAdmin/inventarioAdministrarPuntoVenta.php");
        exit;
    }
} else {
    // Redirigir si no se accede por POST
    header("location: ../../../vistas/vistasAdmin/inventarioAdministrarPuntoVenta.php");
    exit;
}
