<?php
// Iniciar sesión y cargar la configuración de conexión
session_start();
include_once "../config/conex.php";

// Verificar si se recibió el ID del cliente
if (!empty($_POST['idCliente'])) {
    // Obtener el ID del cliente y establecer el estado a 0 (inactivo)
    $cliente = $_POST['idCliente'];
    $estado = 0;

    // Preparar la consulta para actualizar el estado del cliente y su información asociada
    $sqlUpdate = $dbh->prepare("UPDATE clientes_registrados INNER JOIN info_clientes ON info_clientes.id_info_cliente = clientes_registrados.id_info_cliente SET clientes_registrados.estado = :estCli, info_clientes.estado=:estInfo, info_clientes.fecha_update = now() WHERE id_cliente_registrado = :idCliente");

    // Asociar parámetros a la consulta de actualización
    $sqlUpdate->bindParam(':estCli', $estado);
    $sqlUpdate->bindParam(':estInfo', $estado);
    $sqlUpdate->bindParam(':idCliente', $cliente);

    // Ejecutar la consulta de actualización
    if ($sqlUpdate->execute()) {
        // Redireccionar a la página de cerrar sesión
        header("Location: ../login/conCerrarSesion2.php");
    } else {
        // Mostrar mensaje de error si hay un problema con la actualización
        $_SESSION['msjAct'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
        exit;
    }
} else {
    // Mostrar mensaje de error si no se recibió el ID del cliente
    $_SESSION['msjAct'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
    header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
    exit;
}
?>