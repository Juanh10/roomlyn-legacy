<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sqlHab = "SELECT hb.id_habitacion, hb.id_hab_estado, hb.nHabitacion, hb.tipoCama, hb.cantidadPersonasHab, hb.estado, hbt.tipoHabitacion, hbe.estado_habitacion, hbs.servicio, hbe.estado_habitacion FROM habitaciones AS hb INNER JOIN habitaciones_tipos AS hbt ON hbt.id_hab_tipo = hb.id_hab_tipo INNER JOIN habitaciones_estado AS hbe ON hbe.id_hab_estado = hb.id_hab_estado INNER JOIN habitaciones_servicios hbs ON hbs.id_servicio = hb.id_servicio  WHERE hb.estado = 1";

// Definir colores según el estado
$colores = array(
    'Disponible' => 'green',
    'Limpieza' => 'blue',
    'Mantenimiento' => 'orange',
    'Ocupado' => 'red',
    'Reservada' => 'yellow'
);

// Definir iconos según el estado
$iconos = array(
    'Disponible' => 'bed',
    'Limpieza' => 'cleaning_services',
    'Mantenimiento' => 'construction',
    'Ocupado' => 'do_not_disturb_on',
    'Reservada' => 'calendar_add_on'
);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "menuAdmin.php"; ?>
    <title>Inicio</title>
</head>

<style>
        /* Estilos CSS para los colores definidos en PHP */
        .disponible { background-color: <?php echo $colores['Disponible']; ?>; }
        .limpieza { background-color: <?php echo $colores['Limpieza']; ?>; }
        .mantenimiento { background-color: <?php echo $colores['Mantenimiento']; ?>; }
        .ocupado { background-color: <?php echo $colores['Ocupado']; ?>; }
        .reservada { background-color: <?php echo $colores['Reservada']; ?>; }
    </style>

<body>

    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>RECEPCIÓN</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <main class="contenido">
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="contenedorHab">
                        <?php
                        foreach ($dbh->query($sqlHab) as $rowHab) :
                            // Obtener el color y el icono según el estado
                            $estadoColor = strtolower(trim($rowHab['estado_habitacion']));
                            $estadoIcono =  strtolower(trim($rowHab['estado_habitacion']));
                        ?>
                            <div class="cardHabitaciones <?php echo $estadoColor; ?>">
                                <div class="informacionHab">
                                    <div class="numHabitacion">
                                        <span><?php echo $rowHab['nHabitacion'] ?></span>
                                        <i class="material-symbols-outlined"><?php echo $estadoIcono ?></i>
                                    </div>
                                    <div class="inforHab">
                                        <span><?php echo $rowHab['tipoHabitacion'] ?></span>
                                        <span><?php echo $rowHab['servicio'] ?></span>
                                        <span><?php echo $rowHab['tipoCama'] ?></span>
                                    </div>
                                </div>
                                <div class="btnEstado">
                                    <span><?php echo $rowHab['estado_habitacion'] ?></span>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- PIE DE PAGINA -->
    <footer class="pie-de-pagina">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>

</body>

</html>