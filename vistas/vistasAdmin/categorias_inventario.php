<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sql = "SELECT id_hab_tipo, tipoHabitacion FROM habitaciones_tipos WHERE 1 AND estado = 1"; //consulta para el modal de añadir habitaciones

$sql2 = "SELECT habitaciones.id_habitacion, habitaciones.id_servicio, habitaciones.nHabitacion, habitaciones_tipos.tipoHabitacion, habitaciones.tipoCama, habitaciones.cantidadPersonasHab, habitaciones.observacion, habitaciones.estado, habitaciones_estado.estado_habitacion FROM habitaciones INNER JOIN habitaciones_tipos ON habitaciones.id_hab_tipo = habitaciones_tipos.id_hab_tipo INNER JOIN habitaciones_estado ON habitaciones.id_hab_estado = habitaciones_estado.id_hab_estado WHERE habitaciones.estado = 1 ORDER BY habitaciones.id_habitacion"; // consulta para mostrar todos los datos relacionados con las habitacione.

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <?php require_once "menuAdmin.php"; ?>
</head>
</head>
<body>
<header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>GESTIONAR HABITACIONES</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>
    <div class="contenido">
        <h1>Categorias</h1>
    </div>
    
</body>
</html>