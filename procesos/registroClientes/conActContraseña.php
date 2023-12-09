<?php
// Iniciar sesión y cargar la configuración de conexión
session_start();
include_once "../config/conex.php";

// Verificar si se enviaron los datos del formulario
if (!empty($_POST['contraActual']) && !empty($_POST['contraNueva']) && !empty($_POST['contraNueva2']) && !empty($_POST['idCliente'])) {

    // Obtener datos del formulario
    $contraActual = $_POST['contraActual'];
    $contraNueva = $_POST['contraNueva'];
    $contraNueva2 = $_POST['contraNueva2'];
    $cliente = $_POST['idCliente'];
    $estado = 1;

    // Encriptar la nueva contraseña
    $contraEncriptada = password_hash($contraNueva, PASSWORD_DEFAULT);

    // Preparar consulta SQL para verificar la contraseña actual del cliente
    $sqlConsulta = $dbh->prepare("SELECT id_cliente_registrado, contrasena, estado FROM clientes_registrados WHERE id_cliente_registrado = :idCliente AND estado = :est");

    // Asociar parámetros a la consulta
    $sqlConsulta->bindParam(':idCliente', $cliente);
    $sqlConsulta->bindParam(':est', $estado);

    // Ejecutar la consulta
    $sqlConsulta->execute();

    // Obtener resultados de la consulta
    $rowConsulta = $sqlConsulta->fetch();

    // Verificar si la contraseña actual coincide
    if (password_verify($contraActual, $rowConsulta['contrasena'])) {

        // Verificar si las nuevas contraseñas coinciden
        if ($contraNueva == $contraNueva2) {

            // Preparar consulta SQL para actualizar la contraseña del cliente
            $sqlUpdateContra = $dbh->prepare("UPDATE clientes_registrados SET contrasena= :contra, fecha_update= now() WHERE id_cliente_registrado = :idCli AND estado = :estado");

            // Asociar parámetros a la consulta de actualización
            $sqlUpdateContra->bindParam(':contra', $contraEncriptada);
            $sqlUpdateContra->bindParam(':idCli', $cliente);
            $sqlUpdateContra->bindParam(':estado', $estado);

            // Ejecutar la consulta de actualización
            if ($sqlUpdateContra->execute()) {
                $_SESSION['msjAct'] = "Contraseña actualizada correctamente";
                header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
                exit;
            } else {
                // Si hay un error en la actualización, mostrar mensaje de error
                $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
                exit;
            }
        } else {
            // Si las nuevas contraseñas no coinciden, mostrar mensaje de error
            $_SESSION['msjError'] = "No coinciden las contraseñas";
            header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
            exit;
        }
    } else {
        // Si la contraseña actual es incorrecta, mostrar mensaje de error
        $_SESSION['msjError'] = "La contraseña actual es incorrecta, vuelva a intentar";
        header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
        exit;
    }
} else {
    // Si hay campos vacíos, mostrar mensaje de error
    $_SESSION['msjError'] = "Campos vacíos. Por favor, llena todos los campos";
    header("Location: ../../vistas/vistasRegistroClientes/gestionarSeguridad.php");
    exit;
}
?>