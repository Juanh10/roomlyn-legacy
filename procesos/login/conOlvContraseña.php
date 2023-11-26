<?php

use PHPMailer\PHPMailer\PHPMailer;

include_once "../config/conex.php";
session_start();

if (isset($_POST["btnUsuario"])) { //esta funcion sirve para saber si se precionó el boton

    if (!empty($_POST["usuario"]) && !empty($_POST["documento"])) { // esta funcion es para saber si los campos estan vacios

        $usuario = $_POST['usuario'];
        $documento = $_POST['documento'];
        $estado = 1;
        $email = "";

        $sqlCliente = $dbh->prepare("SELECT clr.id_cliente_registrado, clr.id_info_cliente, clr.id_rol, clr.usuario, clr.contrasena, clr.estado, ic.email FROM clientes_registrados AS clr INNER JOIN info_clientes AS ic ON ic.id_info_cliente = clr.id_info_cliente WHERE ic.documento = :documento AND clr.usuario = :usuario AND clr.estado = :estado");

        $sqlEmpleado = $dbh->prepare("SELECT em.id_empleado, em.id_empleado, em.id_rol, em.usuario, em.contrasena, em.estado FROM empleados AS em INNER JOIN info_empleados AS ie ON ie.id_info_empleado = em.id_empleado WHERE ie.documento = :documento AND em.usuario = :usuario AND em.estado = :estado");

        $sqlCliente->bindParam(':documento', $documento);
        $sqlCliente->bindParam(':usuario', $usuario);
        $sqlCliente->bindParam(':estado', $estado);

        $sqlCliente->execute();


        if ($sqlCliente->rowCount() > 0) {

            $result = $sqlCliente->fetch();
            $email = $result['email'];
        } else {

            $sqlEmpleado->bindParam(':documento', $documento);
            $sqlEmpleado->bindParam(':usuario', $usuario);
            $sqlEmpleado->bindParam(':estado', $estado);

            $sqlEmpleado->execute();

            if ($sqlEmpleado->rowCount() > 0) {
                $result = $sqlCliente->fetch();
                $email = $result['email'];
            } else {
                $_SESSION['msjError'] = "Usuario no encontrado.";
                header("location: ../../vistas/olvConrtraseña.php");
                exit;
             }
        }

        include "../../vistas/inicioSesion/msjCorreo.php";

        include "../../librerias/phpMailer/PHPMailer.php";
        include "../../librerias/phpMailer/SMTP.php";

        $emailUser = "useroomlyn@roomlyn.com.co";
        $emailContra = "3106046654Juan";
        $msj = "Recuperar contraseña";
        $emailEnvio = $email;
        $fromName = 'No responder este correo';

        $phpmailer = new PHPMailer();
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
        $phpmailer->Body .= $mensaje_correo;
        $phpmailer->isHTML(true);

        if (!$phpmailer->send()) {
            $_SESSION['msjError'] = "Ocurrio un error.";
            header("location: ../../vistas/login.php");
            exit;
        } else {
            $_SESSION['msjExito'] = "Hemos enviado un enlace a tu correo electrónico para que puedas cambiar la contraseña.";
            header("location: ../../vistas/olvConrtraseña.php");
            exit;
        }
    } else {
        header("location: ../../vistas/olvConrtraseña.php");
        $_SESSION['mjsError'] = "Campos vacios";
        exit;
    }
}
?>