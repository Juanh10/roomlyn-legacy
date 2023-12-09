<?php
session_start();

include_once "../config/conex.php";

// Verificar si los campos no estan vacios
if (!empty($_POST['usuario']) && !empty($_POST['contrasena'])) {

    $usuario = $_POST['usuario'];
    $contrasena = $_POST['contrasena'];
    $estado = 1;

    // Verificar si el usuario es un correo electrónico
    if (filter_var($usuario, FILTER_VALIDATE_EMAIL)) {

        // Validar el usuario en la tabla de clientes registrados
        $validarUsu = $dbh->prepare("SELECT clientes_registrados.id_cliente_registrado, clientes_registrados.id_info_cliente, clientes_registrados.id_rol, clientes_registrados.usuario, clientes_registrados.contrasena, clientes_registrados.estado, info_clientes.nombres, info_clientes.apellidos, info_clientes.celular, info_clientes.email, info_clientes.estado FROM clientes_registrados INNER JOIN info_clientes ON clientes_registrados.id_info_cliente = info_clientes.id_info_cliente WHERE info_clientes.estado = :estCli AND clientes_registrados.estado = :est AND clientes_registrados.usuario = :usurio");

        $validarUsu->bindParam(':estCli', $estado);
        $validarUsu->bindParam(':est', $estado);
        $validarUsu->bindParam(':usurio', $usuario);

        $validarUsu->execute();

        $contador2 = 0;

        foreach ($validarUsu->fetchAll(PDO::FETCH_ASSOC) as $datosCliente) {
            $contador2 += 1;

            $contraBD = $datosCliente['contrasena'];

            // Guardar información del cliente en sesiones
            $_SESSION['id_cliente_registrado'] = $datosCliente['id_cliente_registrado'];
            $_SESSION['id_info_cliente'] = $datosCliente['id_info_cliente'];
            $_SESSION['id_rol'] = $datosCliente['id_rol'];
            $_SESSION['usuario'] = $datosCliente['usuario'];
            $_SESSION['nombres'] = $datosCliente['nombres'];
            $_SESSION['apellidos'] = $datosCliente['apellidos'];
            $_SESSION['celular'] = $datosCliente['celular'];
            $_SESSION['email'] = $datosCliente['email'];
        }

        // Comprobar si no se encontraron registros
        if ($contador2 == 0) {
            $_SESSION['error'] = "El usuario es incorrecto";
            header("location: ../../vistas/login.php");
        } else {
            // Verificar la contraseña
            if (password_verify($contrasena, $contraBD)) {
                header("location: ../../index.php");
            } else {
                $_SESSION['error'] = "La contraseña es incorrecta";
                header("location: ../../vistas/login.php");
            }
        }
    } else {
        // Validar el usuario en la tabla de empleados
        $validar = $dbh->prepare("SELECT empleados.id_empleado, empleados.id_rol, empleados.usuario, empleados.contrasena, info_empleados.pNombre, info_empleados.pApellido FROM empleados JOIN info_empleados ON empleados.id_info_empleado = info_empleados.id_info_empleado WHERE empleados.usuario = :usua and empleados.estado = :estado");

        $validar->bindParam(':usua', $usuario);
        $validar->bindParam(':estado', $estado);
        $validar->execute();

        $contador = 0;

        foreach ($validar->fetchAll(PDO::FETCH_ASSOC) as $datos) {
            $contador += 1;

            $contrasenaBD = $datos['contrasena'];
            $_SESSION['id_empleado'] = $datos['id_empleado'];
            $_SESSION['pNombre'] = $datos['pNombre'];
            $_SESSION['pApellido'] = $datos['pApellido'];
            $_SESSION['tipoUsuario'] = $datos['id_rol'];
            $_SESSION['usuario'] = $datos['usuario'];
        }

        // Comprobar si no se encontraron registros
        if ($contador == 0) {
            $_SESSION['error'] = "El usuario es incorrecto";
            header("location: ../../vistas/login.php");
        } else {
            // Verificar la contraseña
            if (password_verify($contrasena, $contrasenaBD)) {
                header("location: ../../vistas/vistasAdmin/inicio.php");
            } else {
                $_SESSION['error'] = "La contraseña es incorrecta";
                header("location: ../../vistas/login.php");
            }
        }
    }
} else {
    $_SESSION['error'] = "Campos Vacios";
    header("location: ../../vistas/login.php");
}
?>