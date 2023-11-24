<?php
session_start();

include_once "../config/conex.php";


if (!empty($_POST['nombres']) && !empty($_POST['apellidos']) && !empty($_POST['documento']) && !empty($_POST['celular']) && !empty($_POST['email']) && !empty($_POST['sexo']) && !empty($_POST['nacionalidad']) && !empty($_POST['departamento']) && !empty($_POST['ciudad']) && !empty($_POST['idCliente'])) {

    $idCliente = $_POST['idCliente'];
    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $documento = $_POST['documento'];
    $telefono = $_POST['celular'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
    $nacionalidad = $_POST['nacionalidad'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];

    $sqlUpdate = $dbh->prepare("UPDATE info_clientes INNER JOIN clientes_registrados ON clientes_registrados.id_info_cliente = info_clientes.id_info_cliente SET info_clientes.id_nacionalidad = :nacionalidad, info_clientes.id_departamento = :departamento, info_clientes.id_municipio = :municipio, info_clientes.documento = :docu, info_clientes.nombres = :nombres, info_clientes.apellidos = :ape, info_clientes.celular = :tel, info_clientes.sexo = :sexo, info_clientes.email = :email, info_clientes.fecha_update = now(), clientes_registrados.usuario = :usuario, clientes_registrados.fecha_update = now() WHERE clientes_registrados.id_cliente_registrado = :idCliente");

    $sqlUpdate->bindParam(':idCliente', $idCliente);
    $sqlUpdate->bindParam(':nacionalidad', $nacionalidad);
    $sqlUpdate->bindParam(':departamento', $departamento);
    $sqlUpdate->bindParam(':municipio', $ciudad);
    $sqlUpdate->bindParam(':docu', $documento);
    $sqlUpdate->bindParam(':nombres', $nombres);
    $sqlUpdate->bindParam(':ape', $apellidos);
    $sqlUpdate->bindParam(':tel', $telefono);
    $sqlUpdate->bindParam(':sexo', $sexo);
    $sqlUpdate->bindParam(':email', $email);
    $sqlUpdate->bindParam(':usuario', $email);


    if ($sqlUpdate->execute()) {
        $_SESSION['msjAct'] = "Datos actualizados";
        header("Location: ../../vistas/vistasRegistroClientes/gestionarDatos.php");
        exit;
    } else {
        $_SESSION['msjAct'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
        header("Location: ../../vistas/vistasRegistroClientes/gestionarDatos.php");
        exit;
    }
} else {
    $_SESSION['msjAct'] = "Campos vacios. Por favor llena todos los campos.";
    header("Location: ../../vistas/vistasRegistroClientes/gestionarDatos.php");
    exit;
}
