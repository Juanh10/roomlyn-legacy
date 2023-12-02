<?php
session_start();

$seleccion = $_POST['seleccion'];

date_default_timezone_set('America/Bogota');

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$fechaActual = date('Y-m-d');

$fechaSiguiente = date("Y-m-d", strtotime($fechaActual . " +1 day")); // Calcular la fecha del día siguiente

$rangoFecha = $fechaActual . " - " . $fechaSiguiente;

$sqlHab = "SELECT hb.id_habitacion, hb.id_hab_tipo, hb.id_hab_estado, hb.nHabitacion, hb.tipoCama, hb.cantidadPersonasHab, hb.estado, hbt.tipoHabitacion, hbe.estado_habitacion, hbs.servicio, hbe.estado_habitacion FROM habitaciones AS hb INNER JOIN habitaciones_tipos AS hbt ON hbt.id_hab_tipo = hb.id_hab_tipo INNER JOIN habitaciones_estado AS hbe ON hbe.id_hab_estado = hb.id_hab_estado INNER JOIN habitaciones_servicios hbs ON hbs.id_servicio = hb.id_servicio  WHERE hb.estado = 1 AND hbe.id_hab_estado = " . $seleccion . " ORDER BY hb.nHabitacion ASC ";

// Definir colores según el estado
$colores = array(
    'disponible' => '#28a64b',
    'limpieza' => '#18a2b8',
    'mantenimiento' => '#fc7f1c',
    'ocupado' => '#dd3546',
    'pendiente' => '#497db5',
    'reservada' => '#006cd6'
);

// Definir iconos según el estado
$iconos = array(
    'disponible' => 'bed',
    'limpieza' => 'cleaning_services',
    'mantenimiento' => 'construction',
    'ocupado' => 'do_not_disturb_on',
    'pendiente' => 'schedule',
    'reservada' => 'calendar_add_on'
);

?>

<div class="btnVolverFiltro">
    <span>
        < Volver</span>
</div>

<?php
$resultConsulta = $dbh->query($sqlHab);

if ($resultConsulta->rowCount() > 0) :
?>
    <div class="contenedorHab">
        <?php
        foreach ($dbh->query($sqlHab) as $rowHab) :
            // Obtener el color y el icono según el estado
            $idTipo = $rowHab['id_hab_tipo'];
            $estadoColor = strtolower(trim($rowHab['estado_habitacion']));
            $estadoIcono = isset($iconos[$estadoColor]) ? $iconos[$estadoColor] : '';
            $colorEstado = isset($colores[$estadoColor]) ? $colores[$estadoColor] : '';
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
                <?php
                if ($rowHab['id_hab_estado'] == 1) :
                ?>
                    <div class="btnEstado btnDisponible" data-bs-toggle="modal" data-bs-target="#modalDisponible" id="<?php echo $rowHab['id_habitacion'] ?>">
                        <span id="<?php echo $rangoFecha ?>"><?php echo $rowHab['estado_habitacion'] ?></span>
                        <span id="<?php echo $idTipo ?>"></span>
                    </div>
                <?php
                elseif ($rowHab['id_hab_estado'] == 2) :
                ?>
                    <div class="btnEstado btnCambiarEstado" data-bs-toggle="modal" data-bs-target="#modalEstado" id="<?php echo $rowHab['id_habitacion'] ?>">
                        <span><?php echo $rowHab['estado_habitacion'] ?></span>
                    </div>
                <?php
                elseif ($rowHab['id_hab_estado'] == 3) :
                ?>
                    <div class="btnEstado btnCambiarEstado" data-bs-toggle="modal" data-bs-target="#modalEstado" id="<?php echo $rowHab['id_habitacion'] ?>">
                        <span><?php echo $rowHab['estado_habitacion'] ?></span>
                    </div>
                <?php
                elseif ($rowHab['id_hab_estado'] == 4) :
                ?>
                    <div class="btnEstado btnOcupado" data-bs-toggle="modal" data-bs-target="#ModalOcupado" id="<?php echo $rowHab['id_habitacion'] ?>">
                        <span><?php echo $rowHab['estado_habitacion'] ?></span>
                    </div>
                <?php
                elseif ($rowHab['id_hab_estado'] == 5) :
                ?>
                    <div class="btnEstado btnPendiente" data-bs-toggle="modal" data-bs-target="#ModalPendiente" id="<?php echo $rowHab['id_habitacion'] ?>">
                        <span><?php echo $rowHab['estado_habitacion'] ?></span>
                    </div>
                <?php

                elseif ($rowHab['id_hab_estado'] == 6) :
                ?>
                    <div class="btnEstado btnReservada" data-bs-toggle="modal" data-bs-target="#Modalreservada" id="<?php echo $rowHab['id_habitacion'] ?>">
                        <span><?php echo $rowHab['estado_habitacion'] ?></span>
                    </div>
                <?php
                endif;
                ?>
            </div>
        <?php
        endforeach;
        ?>
    </div>
<?php
else :
?>
    <span>No hay habitaciones disponibles en ese estado.</span>
<?php

endif;

?>

<script>
    $('.btnInforCli').click(function() {
        let idCLiente = $(this).attr('id');
        let contenido = $('#contenidoInforCliente');

        fetch(`../vistasAdmin/inforClienteReserva.php?id=${idCLiente}`)
            .then(res => res.text())
            .then(datos => contenido.html(datos))
            .catch();
    });

    $('.btnVolverFiltro').click(function() {
        location.reload();
    });
</script>