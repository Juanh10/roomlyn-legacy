<?php

session_start();

include_once "../config/conex.php";

if(!empty($_POST['primerNombre']) && !empty($_POST['primerApellido']) && !empty($_POST['tipoDocumento']) && !empty($_POST['primerApellido']) && !empty($_POST['documento']) && !empty($_POST['celular']) && !empty($_POST['email']) && !empty($_POST['tipoUsuario']) && !empty($_POST['usuario']) && !empty($_POST['contraseña']) ){

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


    //* INSERTAR LA INFORMACION DEL USUARIO
    $insertarInforUsuarios = "INSERT INTO infousuarios(tipoDocumento, documento, pNombre, sNombre, pApellido, sApellido, celular, email) VALUES (:tDoc,:doc,:pn,:sn,:pa,:sa,:cel,:em)";

    //* INSERTAR EL USUARIO
    $insertarUsuarios = "INSERT INTO usuarios(id_infoUsuario, usuario, contraseña, tipoUsuario, estado, fecha, hora, fecha_sys) VALUES (:idInfo,:usu,:contra,:tUsu,:estado,:fecha,:hora,now())";

   
   //*CONSULTA DEL USUARIO
   $consultaUsuario = $dbh -> prepare("SELECT usuario FROM usuarios WHERE usuario = :usuario"); // preparar la consulta sobre el usuario para que no haya duplicados
   $consultaUsuario -> bindParam(':usuario', $usuario);// enlazar marcador con la variable
   $consultaUsuario -> execute(); // realiza la consulta

    //* CONSULTA TIPO USUARIO
   $consultarTipoUsuario = $dbh -> prepare("SELECT tipoUsuario FROM usuarios WHERE tipoUsuario = :tipoUsuario"); // preparar la consulta para comparar si ya existe un usuario como administrador
   $marcTipoUsuario = 'Administrador';
   $consultarTipoUsuario -> bindParam(':tipoUsuario', $marcTipoUsuario);
   $consultarTipoUsuario -> execute(); // realiza la consulta




   if($consultaUsuario -> fetch()){ // si ya existe un tipo de usuario como administrador no deja registrar
        ?>
            <script>
                alert("Este usuario ya está registrado, Intenta con otro");
                window.location.href = '../../vistas/registroUsuarios.php';
            </script>
        <?php
   }else{

    //Preparar la consulta
    $insertInfor = $dbh -> prepare($insertarInforUsuarios);

    $estado = 1;
    
    // enlazar los marcadores con las variables
    $insertInfor -> bindParam(':tDoc', $tipoDocumento);
    $insertInfor -> bindParam(':doc', $documento);
    $insertInfor -> bindParam(':pn', $primerNombre);
    $insertInfor -> bindParam(':sn', $segundoNombre);
    $insertInfor -> bindParam(':pa', $primerApellido);
    $insertInfor -> bindParam(':sa', $segundoApellido);
    $insertInfor -> bindParam(':cel', $celular);
    $insertInfor -> bindParam(':em', $email);

    if($insertInfor -> execute()){ // ejecutar la consulta

        $ultID = $dbh -> lastInsertId('infousuarios'); // obtener el ultimo ID de la tabla infoUsuarios

        date_default_timezone_set('America/Bogota'); // Establecer la zona horaria

        $fecha = date('Y-m-d'); // Obtener la fecha actual

        $hora = date('H:i:s'); // obtener la hora actual

        // preparar la consulta
        $insertUsu = $dbh -> prepare($insertarUsuarios);

        //enlazar los marcadores con las variables
        $insertUsu -> bindParam(':idInfo',$ultID);
        $insertUsu -> bindParam(':usu',$usuario);
        $insertUsu -> bindParam(':contra',$contraseña);
        $insertUsu -> bindParam(':tUsu',$tipoUsuario);
        $insertUsu -> bindParam(':estado',$estado);
        $insertUsu -> bindParam(':fecha',$fecha);
        $insertUsu -> bindParam(':hora',$hora);

        if($insertUsu -> execute()){ // ejecutar la consulta
            if($consultarTipoUsuario -> fetch()){
                ?>
                <script>
                    alert("Usuario creado");
                    window.location.href = '../../vistas/vistasAdmin/usuarios.php'; // me redirige a la plataforma del administrador
                </script>
            <?php
            }else{
                ?>
                <script>
                    alert("Usuario creado");
                    window.location.href = '../../vistas/login.php'; // me redirige al login ya que se crea el administrador o el primer registro
                </script>
            <?php
            }
        }else{
            echo "ERROR";
        }

    }else{
        echo "ERROR";
    }
    
   }

}else{
    echo "Campos vacios";
}



?>
