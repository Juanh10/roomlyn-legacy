<?php

use PHPMailer\PHPMailer\PHPMailer;

include_once "../config/conex.php";
session_start();

if (isset($_POST["btnUsuario"])) { //esta funcion sirve para saber si se preciono el boton

    if (!empty($_POST["usuario"]) && !empty($_POST["documento"])) { // esta funcion es para saber si los campos estan vacios
        
        include "../../vistas/inicioSesion/msjCorreo.php";

        include "../../librerias/phpMailer/PHPMailer.php"; 
        include "../../librerias/phpMailer/SMTP.php";

        $emailUser = "juanchohernandez200518@gmail.com";
        $emailContra = "3183683155Juan";
        $msj = "HOLA MUNDO";
        $emailEnvio = "juanchohernandez200518@gmail.com";
        $fromName = 'CHAO MUNDO';
        
        $phpmailer = new PHPMailer();
        $phpmailer -> Username = $emailUser;
        $phpmailer -> Password = $emailContra;
        $phpmailer -> SMTPSecure = 'ssl';
        $phpmailer -> Host = '';
        $phpmailer -> Port = 465;
        $phpmailer -> isSMTP();
        $phpmailer -> SMTPAuth = true;
        $phpmailer -> setFrom($phpmailer->Username,$fromName);
        $phpmailer -> addAddress($emailEnvio);
        $phpmailer -> FromName = "HOLA A TODOS";
        $phpmailer -> Subject = $msj;
        $phpmailer -> Body .= $mensaje_correo;
        $phpmailer -> isHTML(true);

        if(!$phpmailer->send()){
            echo "ERROR";
        }else{
            echo "OK";
        }


        

    } else {
        header("location: ../../vistas/login.php");
        $_SESSION['mjsError'] = "Campos vacios";
    }
}

?>