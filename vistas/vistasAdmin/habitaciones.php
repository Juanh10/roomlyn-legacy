<?php
session_start();

if(empty($_SESSION['idUsuario'])){ //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

/* echo $_SESSION['idUsuario'];
echo $_SESSION['pNombre'];
echo $_SESSION['pApellido'];
echo $_SESSION['tipoUsuario']; */

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "menuAdmin.php"; ?>
    <title>Habitaciones</title>
</head>
<body>

<div class="contenido">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <button class="btn btn-outline-dark p-2 m-2" id="serviciosBtn">Servicios</button>
                <button class="btn btn-outline-dark p-2 m-2" id="tipoHabitacionesBtn">Tipo Habitaciones</button>
                <button class="btn btn-outline-dark p-2 m-2" id="habitacionesBtn">Habitaciones</button>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="servicios"></div>
                <div id="tipoHabitaciones"></div>
                <div id="habitaciones"></div>
            </div>
        </div>
    </div>
</div>



<!--* SECCION PARA LAS ALERTAS  -->

<?php

if(isset($_SESSION['msjRegistradoServicio'])){
    ?>
    <script>
        Swal.fire({
            position: '',
            icon: 'success',
            title: '<?php echo $_SESSION['msjRegistradoServicio']; ?>',
            showConfirmButton: false,
            timer: 1000
        });;
    </script>
<?php
    unset($_SESSION['msjRegistradoServicio']);
}

if(isset($_SESSION['msjActualizadoServicio'])){
    ?>
    <script>
        Swal.fire({
            position: '',
            icon: 'success',
            title: '<?php echo $_SESSION['msjActualizadoServicio']; ?>',
            showConfirmButton: false,
            timer: 1000
        });;
    </script>
<?php
    unset($_SESSION['msjActualizadoServicio']);
}

if(isset($_SESSION['msjRegistradoTipoH'])){
    ?>
    <script>
        Swal.fire({
            position: '',
            icon: 'success',
            title: '<?php echo $_SESSION['msjRegistradoTipoH']; ?>',
            showConfirmButton: false,
            timer: 1000
        });;
    </script>
<?php
    unset($_SESSION['msjRegistradoTipoH']);
}

?>
    
</body>
</html>