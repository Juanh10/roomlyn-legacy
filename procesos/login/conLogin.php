<?php

session_start();

include_once "../config/conex.php";

//* HACER LA VALIDACION DEL INICIO DE SESION SI LOS CAMPOS NO ESTAN VACIOS SE HACE LA CONSULTA A LA BD

if (!empty($_POST['usuario']) && !empty($_POST['contraseña'])) {


    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];
    $estado = 1;

    if (filter_var($usuario, FILTER_VALIDATE_EMAIL)) {
        
        $validarUsu = $dbh->prepare("SELECT clientes_registrados.id_cliente_registrado, clientes_registrados.id_info_cliente, clientes_registrados.id_rol, clientes_registrados.usuario, clientes_registrados.contraseña, clientes_registrados.estado, info_clientes.nombres, info_clientes.apellidos, info_clientes.celular, info_clientes.email, info_clientes.estado FROM clientes_registrados INNER JOIN info_clientes ON clientes_registrados.id_info_cliente = info_clientes.id_info_cliente WHERE info_clientes.estado = :estCli AND clientes_registrados.estado = :est AND clientes_registrados.usuario = :usurio");

        $validarUsu->bindParam(':estCli',$estado);
        $validarUsu->bindParam(':est',$estado);
        $validarUsu->bindParam(':usurio',$usuario);

        $validarUsu -> execute();

        $contador2 = 0;

        foreach($validarUsu -> fetchAll(PDO::FETCH_ASSOC) as $datosCliente){

            $contador2 += 1;

            $contraBD = $datosCliente['contraseña'];

            $_SESSION['id_cliente_registrado'] = $datosCliente['id_cliente_registrado']; //* Guardar el id en una sesion
            $_SESSION['id_rol'] = $datosCliente['id_rol']; //* Guardar el id en una sesion
            $_SESSION['usuario'] = $datosCliente['usuario']; //* Guardar el id en una sesion
            $_SESSION['nombres'] = $datosCliente['nombres']; //* Guardar el id en una sesion
            $_SESSION['apellidos'] = $datosCliente['apellidos']; //* Guardar el id en una sesion
            $_SESSION['apellidos'] = $datosCliente['apellidos']; //* Guardar el id en una sesion
            $_SESSION['celular'] = $datosCliente['celular']; //* Guardar el id en una sesion
            $_SESSION['email'] = $datosCliente['email']; //* Guardar el id en una sesion

        }

        if($contador2 == 0){
            $_SESSION['error'] = "El usuario es incorrecto";
            header("location: ../../vistas/login.php");
        }else{
            if (password_verify($contraseña, $contraBD)) {
                header("location: ../../index.php");
            } else {
                $_SESSION['error'] = "La contraseña es incorrecta";
                header("location: ../../vistas/login.php");
            }
        }

    } else {

        $validar = $dbh->prepare("SELECT usuarios.idUsuario, usuarios.id_rol, usuarios.usuario, usuarios.contraseña, infousuarios.pNombre, infousuarios.pApellido FROM usuarios JOIN infousuarios ON usuarios.id_infoUsuario = infousuarios.id_infoUsuario WHERE usuarios.usuario = :usua and usuarios.estado = :estado"); //* preparar la consulta

        //* Bloque para enlazar los marcadores con las variables
        $validar->bindParam(':usua', $usuario);
        $validar->bindParam(':estado', $estado);
        $validar->execute(); //* Realizar la consulta


        //* Condicion para obtener el resultado de la consulta

        $contador = 0;

        foreach ($validar->fetchAll(PDO::FETCH_ASSOC) as $datos) {

            $contador += 1;

            $contrasenaBD = $datos['contraseña'];
            $_SESSION['idUsuario'] = $datos['idUsuario']; //* Guardar el id en una sesion
            $_SESSION['pNombre'] = $datos['pNombre'];
            $_SESSION['pApellido'] = $datos['pApellido'];
            $_SESSION['tipoUsuario'] = $datos['id_rol'];
            $_SESSION['usuario'] = $datos['usuario']; //* guardar el usuario en una sesion
        }

        if ($contador == 0) {
            $_SESSION['error'] = "Usuario o Contraseña Incorrecta";
            header("location: ../../vistas/login.php");
        } else {
            if (password_verify($contraseña, $contrasenaBD)) {
                header("location: ../../vistas/vistasAdmin/inicio.php");
            } else {
                $_SESSION['error'] = "Usuario o Contraseña Incorrecta";
                header("location: ../../vistas/login.php");
            }
        }
    }
} else {
    $_SESSION['error'] = "Campos Vacios";
    header("location: ../../vistas/login.php");
}
?>