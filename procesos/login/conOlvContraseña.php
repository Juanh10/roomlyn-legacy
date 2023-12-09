<?php

use PHPMailer\PHPMailer\PHPMailer;

include_once "../config/conex.php";
session_start();

if (isset($_POST["btnUsuario"])) { //Validar si el botón se precionó

    if (!empty($_POST["usuario"]) && !empty($_POST["documento"])) { // validar si los campos estan vacios

        $usuario = $_POST['usuario'];
        $documento = $_POST['documento'];
        $estado = 1;
        $email = "";

        //Preparar las consultas
        $sqlCliente = $dbh->prepare("SELECT clr.id_cliente_registrado, clr.id_info_cliente, clr.id_rol, clr.usuario, clr.contrasena, clr.estado, ic.email FROM clientes_registrados AS clr INNER JOIN info_clientes AS ic ON ic.id_info_cliente = clr.id_info_cliente WHERE ic.documento = :documento AND clr.usuario = :usuario AND clr.estado = :estado");

        $sqlEmpleado = $dbh->prepare("SELECT em.id_empleado, em.id_rol, em.usuario, em.estado, ie.email FROM empleados AS em INNER JOIN info_empleados AS ie ON ie.id_info_empleado = em.id_empleado WHERE ie.documento = :documento AND em.usuario = :usuario AND em.estado = :estado");

        $sqlCliente->bindParam(':documento', $documento);
        $sqlCliente->bindParam(':usuario', $usuario);
        $sqlCliente->bindParam(':estado', $estado);

        $sqlCliente->execute();

        if ($sqlCliente->rowCount() > 0) { // validar si hay registros en la consulta del cliente
            // guardar la informacion en variables
            $result = $sqlCliente->fetch();
            $idUsuario = $result['id_cliente_registrado'];
            $email = $result['email'];
            $estadousu = 1;

            $token = bin2hex(random_bytes(32)); // crear un token para la recuperacion de la contraseña

            $sqlInsertToken = $dbh->prepare("INSERT INTO tokens_recuperacion (id_empleado, id_cliente_registrado, token, estado_usuario, fecha_expiracion) VALUES (NULL, :id_usuario, :token, :estado, DATE_ADD(NOW(), INTERVAL 1 HOUR))"); // insertar el registro en la BD
            $sqlInsertToken->bindParam(':id_usuario', $idUsuario);
            $sqlInsertToken->bindParam(':token', $token);
            $sqlInsertToken->bindParam(':estado', $estadousu);
            $sqlInsertToken->execute();
        } else {
            $estadousu = 0;

            $sqlEmpleado->bindParam(':documento', $documento);
            $sqlEmpleado->bindParam(':usuario', $usuario);
            $sqlEmpleado->bindParam(':estado', $estado);

            $sqlEmpleado->execute();

            if ($sqlEmpleado->rowCount() > 0) { // validar si hay registros en la consulta del empleado
                //Guardar informacion en variables
                $result = $sqlEmpleado->fetch();
                $idUsuario = $result['id_empleado'];
                $email = $result['email'];
                $token = bin2hex(random_bytes(32)); // crear un token para la recuperacion de la contraseña

                $sqlInsertToken = $dbh->prepare("INSERT INTO tokens_recuperacion (id_empleado, id_cliente_registrado, token, estado_usuario, fecha_expiracion) VALUES (:id_usuario, NULL, :token, :estado, DATE_ADD(NOW(), INTERVAL 1 HOUR))"); // insertar el registro en la BD
                $sqlInsertToken->bindParam(':id_usuario', $idUsuario);
                $sqlInsertToken->bindParam(':token', $token);
                $sqlInsertToken->bindParam(':estado', $estadousu);
                $sqlInsertToken->execute();
            } else {
                $_SESSION['msjError'] = "Usuario no encontrado.";
                header("location: ../../vistas/olvConrtraseña.php");
                exit;
            }
        }

        // Codigo para enviar correos electronicos
        include "../../vistas/inicioSesion/msjCorreo.php";

        include "../../librerias/phpMailer/PHPMailer.php";
        include "../../librerias/phpMailer/SMTP.php";

        $emailUser = "useroomlyn@roomlyn.com.co";
        $emailContra = "3106046654Juan";
        $msj = "Recuperar contraseña";
        $emailEnvio = $email;
        $fromName = 'No responder este correo';

        $phpmailer = new PHPMailer();
        $phpmailer->CharSet = 'UTF-8';
        $phpmailer->Username = $emailUser;
        $phpmailer->Password = $emailContra;
        $phpmailer->SMTPSecure = 'ssl';
        $phpmailer->Host = 'mail.roomlyn.com.co';
        $phpmailer->Port = 465;
        $phpmailer->isSMTP();
        $phpmailer->SMTPAuth = true;
        $phpmailer->setFrom($phpmailer->Username, $fromName);
        $phpmailer->addAddress($emailEnvio);
        $phpmailer->FromName = $fromName;
        $phpmailer->Subject = $msj;
        $phpmailer->Body = $mensaje_correo;
        $phpmailer->isHTML(true);

        if (!$phpmailer->send()) {
            $_SESSION['msjError'] = "Ocurrió un error al enviar el correo electrónico.";
            header("location: ../../vistas/login.php");
            exit;
        } else {
            $_SESSION['msjExito'] = "Hemos enviado un enlace a tu correo electrónico para que puedas cambiar la contraseña.";
            header("location: ../../vistas/login.php");
            exit;
        }
    } else {
        header("location: ../../vistas/olvConrtraseña.php");
        $_SESSION['mjsError'] = "Campos vacios";
        exit;
    } 
}
?>