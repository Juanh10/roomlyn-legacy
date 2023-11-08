<?php
include_once "../config/conex.php";
date_default_timezone_set("America/Bogota");
session_start();

if (!empty($_POST['nombres']) && !empty($_POST['apellidos']) && !empty($_POST['documento']) && !empty($_POST['celular']) && !empty($_POST['email']) && !empty($_POST['sexo']) && !empty($_POST['nacionalidad']) && !empty($_POST['departamento']) && !empty($_POST['ciudad']) && $_POST['contraseña']) {

    $nombres = $_POST['nombres'];
    $apellidos = $_POST['apellidos'];
    $documento = $_POST['documento'];
    $telefono = $_POST['celular'];
    $email = $_POST['email'];
    $sexo = $_POST['sexo'];
    $nacionalidad = $_POST['nacionalidad'];
    $departamento = $_POST['departamento'];
    $ciudad = $_POST['ciudad'];
    $clave = $_POST['contraseña'];
    $estadoRegistro = 1;
    $estado = 1;
    $rol = 3;
    $fecha = date('Y-m-d'); // Obtener la fecha actual
    $hora = date('H:i:s'); // obtener la hora actual

    $contraEncriptada = password_hash($clave, PASSWORD_DEFAULT);


    // PREPARAR LOS INSERT

    $sqlInforCliente = $dbh->prepare("INSERT INTO info_clientes(id_nacionalidad, id_departamento, id_municipio, documento, nombres, apellidos, celular, sexo, email, estadoRegistro, estado, fecha, hora, fecha_sys) VALUES (:id_nacionalidad,:id_departamento,:id_municipio,:documento,:nombres,:apellidos,:celular,:sexo,:email,:estadoRegistro,:estado,:fecha,:hora,now())"); // preparar la consulta

    // ENLAZAR LOS MARCADORES CON LAS VARIABLES

    $sqlInforCliente->bindParam(':id_nacionalidad', $nacionalidad);
    $sqlInforCliente->bindParam(':id_departamento', $departamento);
    $sqlInforCliente->bindParam(':id_municipio', $ciudad);
    $sqlInforCliente->bindParam(':documento', $documento);
    $sqlInforCliente->bindParam(':nombres', $nombres);
    $sqlInforCliente->bindParam(':apellidos', $apellidos);
    $sqlInforCliente->bindParam(':celular', $telefono);
    $sqlInforCliente->bindParam(':sexo', $sexo);
    $sqlInforCliente->bindParam(':email', $email);
    $sqlInforCliente->bindParam(':estadoRegistro', $estadoRegistro);
    $sqlInforCliente->bindParam(':estado', $estado);
    $sqlInforCliente->bindParam(':fecha', $fecha);
    $sqlInforCliente->bindParam(':hora', $hora);

    $sqlCliente = $dbh->prepare("INSERT INTO clientes_registrados(id_info_cliente, id_rol, usuario, contraseña, estado, fecha_sys) VALUES (:infocliente, :rol, :usuario, :clave, :estado, now())");


    //CONSULTA DE USUARIOS

    $sqlConstUs = $dbh->prepare("SELECT usuario, estado FROM clientes_registrados WHERE usuario = :usu AND estado = 1");
    $sqlConstUs->bindParam(':usu', $email);
    $sqlConstUs->execute();
    $rowUsuarios = $sqlConstUs->fetch();

    if ($sqlConstUs->rowCount() > 0) {
        echo "El correo electronico ya está registrado" . $rowUsuarios['usuario'];
    } else {

        if ($sqlInforCliente->execute()) {
            $ultIDCliente = $dbh->lastInsertId('info_clientes'); // obtener el ultimo ID de la tabla infoClientes

            $sqlCliente->bindParam(':infocliente', $ultIDCliente);
            $sqlCliente->bindParam(':rol', $rol);
            $sqlCliente->bindParam(':usuario', $email);
            $sqlCliente->bindParam(':clave', $contraEncriptada);
            $sqlCliente->bindParam(':estado', $estado);

            if ($sqlCliente->execute()) {
                $_SESSION['msjCliente'] = "El cliente se ha registrado con éxito. Por favor, inicie sesión. <br> Usuario: ".$email;
                header("Location: ../../vistas/login.php");
                exit;
            } else {
?>
                <script>
                    alert("Ocurrió un error");
                    window.location.href = '../../vistas/registroClientes.php'; // me redirige a la plataforma del administrador
                </script>
            <?php
            }
        } else {
            ?>
            <script>
                alert("Ocurrió un error");
                window.location.href = '../../vistas/registroClientes.php'; // me redirige a la plataforma del administrador
            </script>
    <?php
        }
    }
} else {
    ?>
    <script>
        alert("Campos vacios");
        window.location.href = '../../vistas/registroClientes.php'; // me redirige a la plataforma del administrador
    </script>
<?php
}
