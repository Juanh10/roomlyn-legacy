<?php

session_start();

include_once "../config/conex.php";

if (!empty($_POST['primerNombre']) && !empty($_POST['primerApellido']) && !empty($_POST['tipoDocumento']) && !empty($_POST['primerApellido']) && !empty($_POST['documento']) && !empty($_POST['celular']) && !empty($_POST['email']) && !empty($_POST['tipoUsuario']) && !empty($_POST['usuario']) && !empty($_POST['contraseña'])) {

    // Datos de los inputs

    $primerNombre = $_POST['primerNombre'];
    $segundoNombre = $_POST['segundoNombre'];
    $primerApellido = $_POST['primerApellido'];
    $segundoApellido = $_POST['segundoApellido'];
    $tipoDocumento = $_POST['tipoDocumento'];
    $documento = $_POST['documento'];
    $celular = $_POST['celular'];
    $email = $_POST['email'];
    $tipoUsuario = $_POST['tipoUsuario'];
    $usuario = $_POST['usuario'];
    $contraseña = $_POST['contraseña'];

    $contraEncriptada = password_hash($contraseña, PASSWORD_DEFAULT);


    //* INSERTAR LA INFORMACION DEL USUARIO
    $insertarInforUsuarios = "INSERT INTO info_empleados(id_tipoDocumento, documento, pNombre, sNombre, pApellido, sApellido, celular, email) VALUES (:tDoc,:doc,:pn,:sn,:pa,:sa,:cel,:em)";

    //* INSERTAR EL USUARIO
    $insertarUsuarios = "INSERT INTO empleados(id_info_empleado, id_rol, usuario, contrasena, estado, fecha_reg, hora_reg, fecha_update) VALUES (:idInfo,:tUsu,:usu,:contra, :estado,:fecha,:hora,now())";


    //*CONSULTA DEL USUARIO

    $consultaRegUsuario = $dbh->prepare("SELECT usuario FROM empleados WHERE 1");

    $consultaRegUsuario->execute();

    $consultaUsuario = $dbh->prepare("SELECT usuario FROM empleados WHERE usuario = :usuario"); // preparar la consulta sobre el usuario para que no haya duplicados
    $consultaUsuario->bindParam(':usuario', $usuario); // enlazar marcador con la variable
    $consultaUsuario->execute(); // realiza la consulta

    //* CONSULTA TIPO ROL
    $consultarTipoUsuario = $dbh->prepare("SELECT id_rol FROM empleados WHERE id_rol = :tipoUsuario"); // preparar la consulta para comparar si ya existe un usuario como administrador
    $marcTipoUsuario = 1;
    $consultarTipoUsuario->bindParam(':tipoUsuario', $marcTipoUsuario);
    $consultarTipoUsuario->execute(); // realiza la consulta

    $tipoUsuario2 = 0;

    if ($consultaRegUsuario->rowCount() > 0) {

        $tipoUsuario2 = 2;


        if ($consultaUsuario->fetch()) {
            $_SESSION['msjError'] = "Este usuario ya está registrado, Intenta con otro";
            header("location: ../../vistas/registroUsuarios.php");
            exit;
        } else {

            //Preparar la consulta
            $insertInfor = $dbh->prepare($insertarInforUsuarios);

            $estado = 1;

            // enlazar los marcadores con las variables
            $insertInfor->bindParam(':tDoc', $tipoDocumento);
            $insertInfor->bindParam(':doc', $documento);
            $insertInfor->bindParam(':pn', $primerNombre);
            $insertInfor->bindParam(':sn', $segundoNombre);
            $insertInfor->bindParam(':pa', $primerApellido);
            $insertInfor->bindParam(':sa', $segundoApellido);
            $insertInfor->bindParam(':cel', $celular);
            $insertInfor->bindParam(':em', $email);

            if ($insertInfor->execute()) { // ejecutar la consulta

                $ultID = $dbh->lastInsertId('infousuarios'); // obtener el ultimo ID de la tabla infoUsuarios

                date_default_timezone_set('America/Bogota'); // Establecer la zona horaria

                $fecha = date('Y-m-d'); // Obtener la fecha actual

                $hora = date('H:i:s'); // obtener la hora actual

                // preparar la consulta
                $insertUsu = $dbh->prepare($insertarUsuarios);

                //enlazar los marcadores con las variables
                $insertUsu->bindParam(':idInfo', $ultID);
                $insertUsu->bindParam(':usu', $usuario);
                $insertUsu->bindParam(':contra', $contraEncriptada);
                $insertUsu->bindParam(':tUsu', $tipoUsuario2);
                $insertUsu->bindParam(':estado', $estado);
                $insertUsu->bindParam(':fecha', $fecha);
                $insertUsu->bindParam(':hora', $hora);

                if ($insertUsu->execute()) { // ejecutar la consulta
                    if ($consultarTipoUsuario->fetch()) {
                        $_SESSION['msjExito'] = "Usuario creado";
                        header("location: ../../vistas/vistasAdmin/usuarios.php");
                        exit;
                    } else {
                        $_SESSION['msjExito'] = "Usuario creado";
                        header("location: ../../vistas/login.php"); // me redirige al login ya que se crea el administrador o el primer registro
                        exit;
                    }
                } else {
                    $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                    header("location: ../../vistas/registroUsuarios.php");
                    exit;
                }
            } else {
                $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("location: ../../vistas/registroUsuarios.php");
                exit;
            }
        }
    } else {

        $tipoUsuario2 = "1";

        if ($consultaUsuario->fetch()) {
            $_SESSION['msjError'] = "Este usuario ya está registrado, Intenta con otro";
            header("location: ../../vistas/registroUsuarios.php");
            exit;
        } else {

            //Preparar la consulta
            $insertInfor = $dbh->prepare($insertarInforUsuarios);

            $estado = 1;

            // enlazar los marcadores con las variables
            $insertInfor->bindParam(':tDoc', $tipoDocumento);
            $insertInfor->bindParam(':doc', $documento);
            $insertInfor->bindParam(':pn', $primerNombre);
            $insertInfor->bindParam(':sn', $segundoNombre);
            $insertInfor->bindParam(':pa', $primerApellido);
            $insertInfor->bindParam(':sa', $segundoApellido);
            $insertInfor->bindParam(':cel', $celular);
            $insertInfor->bindParam(':em', $email);

            if ($insertInfor->execute()) { // ejecutar la consulta

                $ultID = $dbh->lastInsertId('info_empleados'); // obtener el ultimo ID de la tabla infoUsuarios

                date_default_timezone_set('America/Bogota'); // Establecer la zona horaria

                $fecha = date('Y-m-d'); // Obtener la fecha actual

                $hora = date('H:i:s'); // obtener la hora actual

                // preparar la consulta
                $insertUsu = $dbh->prepare($insertarUsuarios);

                //enlazar los marcadores con las variables
                $insertUsu->bindParam(':idInfo', $ultID);
                $insertUsu->bindParam(':usu', $usuario);
                $insertUsu->bindParam(':contra', $contraEncriptada);
                $insertUsu->bindParam(':tUsu', $tipoUsuario2);
                $insertUsu->bindParam(':estado', $estado);
                $insertUsu->bindParam(':fecha', $fecha);
                $insertUsu->bindParam(':hora', $hora);

                if ($insertUsu->execute()) { // ejecutar la consulta
                    if ($consultarTipoUsuario->fetch()) {
                        $_SESSION['msjExito'] = "Usuario creado";
                        header("location: ../../vistas/vistasAdmin/usuarios.php");
                        exit;
                    } else {
                        $_SESSION['msjExito'] = "Usuario creado";
                        header("location: ../../vistas/login.php"); // me redirige al login ya que se crea el administrador o el primer registro
                        exit;
                    }
                } else {
                    $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                    header("location: ../../vistas/registroUsuarios.php");
                    exit;
                }
            } else {
                $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
                header("location: ../../vistas/registroUsuarios.php");
                exit;
            }
        }
    }
} else {
    $_SESSION['msjError'] = "Campos vacíos. por favor llena todos los campos.";
    header("location: ../../vistas/registroUsuarios.php");
    exit;
}
?>