<?php
// Incluye el archivo de configuracion de la base de datos
include_once "../../procesos/config/conex.php";

// Funcion para mostrar una alerta y redireccionar a una URL
function mostrarAlertaYRedireccionar($mensaje, $url)
{
    echo "<script>alert('$mensaje'); window.location.href = '$url';</script>";
}

// Obtiene la URL actual
$actual_link = $_SERVER['HTTP_REFERER'];

// Verificar que los campos del formulario no esten vacios
if (!empty($_POST['token']) && !empty($_POST['nuevaContra']) && !empty($_POST['confirContra'])) {

    // Obtener los valores del formulario
    $token = $_POST['token'];
    $nuevaContra = $_POST['nuevaContra'];
    $confirContra = $_POST['confirContra'];

    // Verificar que las contrasenas coincidan
    if ($nuevaContra == $confirContra) {

        // Consulta la base de datos para verificar el token y su fecha de expiracion
        $sqlVerificarToken = $dbh->prepare("SELECT id_empleado, id_cliente_registrado, estado_usuario FROM tokens_recuperacion WHERE token = :token AND fecha_expiracion > NOW()");
        $sqlVerificarToken->bindParam(':token', $token);
        $sqlVerificarToken->execute();

        // Obtener los resultados de la consulta
        $resultConsulta = $sqlVerificarToken->fetch(PDO::FETCH_ASSOC);

        // Obtener informacion especifica del usuario
        $usuarioEmpleado = $resultConsulta['id_empleado'];
        $usuarioCliente = $resultConsulta['id_cliente_registrado'];
        $contraEncriptada = password_hash($nuevaContra, PASSWORD_DEFAULT);

        // Verificar el estado del usuario y actualizar la contraseña en la base de datos correspondiente
        if ($resultConsulta['estado_usuario'] == 0) {
            // Actualizar la contrasena para empleados
            $sqlActualizarContrasena = $dbh->prepare("UPDATE empleados SET contrasena = :contrasena WHERE id_empleado = :id_usuario");
            $sqlActualizarContrasena->bindParam(':contrasena', $contraEncriptada);
            $sqlActualizarContrasena->bindParam(':id_usuario', $usuarioEmpleado);

            // Verificar si la actualizacion de la contrasena fue exitosa
            if ($sqlActualizarContrasena->execute()) {
                mostrarAlertaYRedireccionar("La contraseña se actualizó correctamente", "http://roomlyn.com.co");
            } else {
                echo "Ocurrió un error al actualizar la contraseña para el empleado";
            }
        } else {
            // Actualizar la contrasena para clientes
            $sqlActualizarContrasena = $dbh->prepare("UPDATE clientes_registrados SET contrasena = :contrasena WHERE id_cliente_registrado = :id_usuario");
            $sqlActualizarContrasena->bindParam(':contrasena', $contraEncriptada);
            $sqlActualizarContrasena->bindParam(':id_usuario', $usuarioCliente);
    
            // Verificar si la actualizacion de la contraseña fue exitosa
            if ($sqlActualizarContrasena->execute()) {
                mostrarAlertaYRedireccionar("La contraseña se actualizó correctamente", "http://roomlyn.com.co");
            } else {
                echo "Ocurrió un error al actualizar la contraseña para el cliente";
            }
        }
    } else {
        mostrarAlertaYRedireccionar("Las contraseñas no coinciden", $actual_link);
    }
}
?>