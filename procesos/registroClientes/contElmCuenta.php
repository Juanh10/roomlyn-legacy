<?php

session_start();

include_once "../config/conex.php";

if (!empty($_POST['idCliente'])) {

    $cliente = $_POST['idCliente'];
    $estado = 0;

    $sqlUpdate = $dbh->prepare("UPDATE clientes_registrados INNER JOIN info_clientes ON info_clientes.id_info_cliente = clientes_registrados.id_info_cliente SET clientes_registrados.estado = :estCli, info_clientes.estado=:estInfo, info_clientes.fecha_update = now() WHERE id_cliente_registrado = :idCliente");

    $sqlUpdate->bindParam(':estCli', $estado);
    $sqlUpdate->bindParam(':estInfo', $estado);
    $sqlUpdate->bindParam(':idCliente', $cliente);

    if ($sqlUpdate->execute()) {
        $_SESSION['msjAct'] = "Cuenta eliminada exitosamente";
        header("Location: ../login/conCerrarSesion2.php");
    } else {
        $_SESSION['msjAct'] = "Ocurrió un error";
        header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
        exit;
    }
} else {
    $_SESSION['msjAct'] = "Campos vacios";
    header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
    exit;
}


?>