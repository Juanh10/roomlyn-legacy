<?php
include_once "../../procesos/config/conex.php";

function mostrarAlertaYRedireccionar($mensaje, $url)
{
    echo "<script>alert('$mensaje'); window.location.href = '$url';</script>";
}

$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

if (!empty($_POST['token']) && !empty($_POST['nuevaContra']) && !empty($_POST['confirContra'])) {

    $token = $_POST['token'];
    $nuevaContra = $_POST['nuevaContra'];
    $confirContra = $_POST['confirContra'];

    if ($nuevaContra == $confirContra) {

        $sqlVerificarToken = $dbh->prepare("SELECT id_empleado, id_cliente_registrado, estado_usuario FROM tokens_recuperacion WHERE token = :token AND fecha_expiracion > NOW()");
        $sqlVerificarToken->bindParam(':token', $token);
        $sqlVerificarToken->execute();

        $resultConsulta = $sqlVerificarToken->fetch(PDO::FETCH_ASSOC);

        $usuarioEmpleado = $resultConsulta['id_empleado'];
        $usuarioCliente = $resultConsulta['id_cliente_registrado'];
        $contraEncriptada = password_hash($nuevaContra, PASSWORD_DEFAULT);

        if ($resultConsulta['estado_usuario'] == 0) {
            $sqlActualizarContrasena = $dbh->prepare("UPDATE empleados SET contrasena = :contrasena WHERE id_empleado = :id_usuario");
            $sqlActualizarContrasena->bindParam(':contrasena', $contraEncriptada);
            $sqlActualizarContrasena->bindParam(':id_usuario', $usuarioEmpleado);

            if ($sqlActualizarContrasena->execute()) {
                mostrarAlertaYRedireccionar("La contraseña se actualizó correctamente", "http://roomlyn.com.co");
            } else {
                echo "Ocurrió un error";
            }
        } else {
            $sqlActualizarContrasena = $dbh->prepare("UPDATE clientes_registrados SET contrasena = :contrasena WHERE id_cliente_registrado = :id_usuario");
            $sqlActualizarContrasena->bindParam(':contrasena', $contraEncriptada);
            $sqlActualizarContrasena->bindParam(':id_usuario', $usuarioCliente);
    
            if ($sqlActualizarContrasena->execute()) {
                mostrarAlertaYRedireccionar("La contraseña se actualizó correctamente", "http://roomlyn.com.co");
            } else {
                echo "Ocurrió un error";
            }
        }
    } else {
        mostrarAlertaYRedireccionar("Las contraseñas no coinciden", $actual_link);
    }
}
