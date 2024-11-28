<?php

// Incluir la configuración de conexión y establecer la zona horaria
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $cajaId = $_POST['caja'];
    $password = $_POST['password'];
    $usuario = $_POST['usuario'];

    // Verificar que la caja y la contraseña no estén vacíos
    if (empty($cajaId) || empty($password)) {
        $_SESSION['msjError'] = "Todos los campos son obligatorios.";
        header("Location: ../../../vistas/vistasAdmin/inventarioLoginPuntoVenta.php");
        exit;
    }

    // Consulta para verificar que la caja existe
    $sql = "SELECT id_punto_venta, nombre, contrasena FROM inventario_punto_venta WHERE id_punto_venta = :cajaId AND estado = 1"; 
    $stmt = $dbh->prepare($sql);
    $stmt->bindParam(':cajaId', $cajaId);
    $stmt->execute();
    $caja = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($caja) {
        // Verificar la contraseña
        if (password_verify($password, $caja['contrasena'])) {
            // Iniciar sesión
            $_SESSION['id_caja'] = $caja['id_punto_venta'];
            $_SESSION['nombre_caja'] = $caja['nombre'];
            $_SESSION['usuario'] = $usuario;

            // Redirigir a la página principal del sistema de ventas o caja
            header("Location: ../../../vistas/vistasAdmin/inventarioPuntoVenta.php");
            exit;
        } else {
            $_SESSION['msjError'] = "Contraseña incorrecta.";
            header("Location: ../../../vistas/vistasAdmin/inventarioLoginPuntoVenta.php");
            exit;
        }
    } else {
        $_SESSION['msjError'] = "La caja seleccionada no existe.";
        header("Location: ../../../vistas/vistasAdmin/inventarioLoginPuntoVenta.php");
        exit;
    }
}
?>