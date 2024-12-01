<?php
session_start();
include_once "../../config/conex.php";

if (isset($_SESSION['id_caja'])) {
    $idCaja = $_SESSION['id_caja'];

    // Actualizar el estado de la caja a desconectado
    $sqlActualizarEstado = $dbh->prepare("UPDATE inventario_punto_venta SET estado_conexion = 0 WHERE id_punto_venta = :id");
    $sqlActualizarEstado->bindParam(':id', $idCaja);
    $sqlActualizarEstado->execute();

    // Eliminar las variables de sesion relacionadas con la caja
    unset($_SESSION['id_caja']);
    unset($_SESSION['nombre_caja']);
    unset($_SESSION['usuario']);
}
// Redirigir a la página de login y cerrar la pestaña
echo '<script type="text/javascript">
        window.close(); // Cierra la pestaña actual
      </script>';
exit;
//header("Location: ../../../vistas/vistasAdmin/inicio.php");
exit;
?>
