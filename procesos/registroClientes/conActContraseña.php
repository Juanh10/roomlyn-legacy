<?php

session_start();

include_once "../config/conex.php";


if (!empty($_POST['contraActual']) && !empty($_POST['contraNueva']) && !empty($_POST['contraNueva2']) && !empty($_POST['idCliente'])) {

    $contraActual = $_POST['contraActual'];
    $contraNueva = $_POST['contraNueva'];
    $contraNueva2 = $_POST['contraNueva2'];
    $cliente = $_POST['idCliente'];
    $estado = 1;

    $contraEncriptada = password_hash($contraNueva, PASSWORD_DEFAULT);

    $sqlConsulta = $dbh->prepare("SELECT id_cliente_registrado, contrasena, estado FROM clientes_registrados WHERE id_cliente_registrado = :idCliente AND estado = :est");

    $sqlConsulta->bindParam(':idCliente', $cliente);
    $sqlConsulta->bindParam(':est', $estado);

    $sqlConsulta->execute();

    $rowConsulta = $sqlConsulta->fetch();

    if (password_verify($contraActual, $rowConsulta['contrasena'])) {

        if ($contraNueva == $contraNueva2) {

            $sqlUpdateContra = $dbh->prepare("UPDATE clientes_registrados SET contrasena= :contra, fecha_update= now() WHERE id_cliente_registrado = :idCli AND estado = :estado");

            $sqlUpdateContra->bindParam(':contra', $contraEncriptada);
            $sqlUpdateContra->bindParam(':idCli', $cliente);
            $sqlUpdateContra->bindParam(':estado', $estado);

            if ($sqlUpdateContra->execute()) {
                $_SESSION['msjAct'] = "Contraseña actualizada correctamente";
                header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
                exit;
            } else {
                $_SESSION['msjAct'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
                exit;
            }
        }
    } else {
        $_SESSION['msjAct'] = "La contraseña actual es incorrecta, vuelvalo a intentar";
        header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
        exit;
    }
} else {
    $_SESSION['msjAct'] = "Campos vacios. Por favor llena todos los campos";
    header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
    exit;
}
