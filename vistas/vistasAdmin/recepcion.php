<?php
session_start();

date_default_timezone_set('America/Bogota');

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$fechaActual = date('Y-m-d');

$fechaSiguiente = date("Y-m-d", strtotime($fechaActual . " +1 day")); // Calcular la fecha del día siguiente

$rangoFecha = $fechaActual . " - " . $fechaSiguiente;

$sqlHab = "SELECT hb.id_habitacion, hb.id_hab_tipo, hb.id_hab_estado, hb.nHabitacion, hb.tipoCama, hb.cantidadPersonasHab, hb.estado, hbt.tipoHabitacion, hbe.estado_habitacion, hbs.servicio, hbe.estado_habitacion FROM habitaciones AS hb INNER JOIN habitaciones_tipos AS hbt ON hbt.id_hab_tipo = hb.id_hab_tipo INNER JOIN habitaciones_estado AS hbe ON hbe.id_hab_estado = hb.id_hab_estado INNER JOIN habitaciones_servicios hbs ON hbs.id_servicio = hb.id_servicio  WHERE hb.estado = 1 ORDER BY hb.nHabitacion ASC";

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
    .disponible {
        background-color: <?php echo $colores['disponible']; ?>;
    }

    .disponible .btnEstado {
        background-color: #269642
    }

    .limpieza {
        background-color: <?php echo $colores['limpieza']; ?>;
    }

    .limpieza .btnEstado {
        background-color: #1491a3;
    }

    .mantenimiento {
        background-color: <?php echo $colores['mantenimiento']; ?>;
    }

    .mantenimiento .btnEstado {
        background-color: #d56b15;
    }

    .ocupado {
        background-color: <?php echo $colores['ocupado']; ?>;
    }

    .ocupado .btnEstado {
        background-color: #b62b39;
    }

    .pendiente {
        background-color: <?php echo $colores['pendiente']; ?>;
    }

    .pendiente .btnEstado {
        background-color: #3b6b9f;
    }

    .reservada {
        background-color: <?php echo $colores['reservada']; ?>;
    }

    .reservada .btnEstado {
        background-color: #0253a7;
    }
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
        <div class="container lisTiposHb">
            <h1 class="mb-3">Habitaciones</h1>
            <div class="row">
                <div class="col contenidoPrincipal">
                    <div class="d-flex flex-wrap justify-content-between align-items-center filtroYBuscador">
                        <div class="filtroSelect d-flex">
                            <span class="desplegarFiltroSelect"></span>
                            <form id="formSelectFiltro">
                                <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $idCliente ?>">
                                <div class="form-floating mb-3">
                                    <select name="selectFiltro" class="form-select" id="selectFiltro">
                                        <option selected disabled>Estado</option>
                                        <?php
                                        $sqlEstados = "SELECT id_hab_estado, estado_habitacion FROM habitaciones_estado WHERE 1";

                                        foreach ($dbh->query($sqlEstados) as $rowEstado) :
                                        ?>
                                            <option value="<?php echo $rowEstado['id_hab_estado'] ?>"><?php echo $rowEstado['estado_habitacion'] ?></option>
                                        <?php
                                        endforeach;
                                        ?>
                                    </select>
                                    <label for="selectFiltro">Estado habitación</label>
                                </div>
                            </form>
                            <div class="buscadorNfc ms-4" data-bs-toggle="modal" data-bs-target="#modal-buscadorNfc">
                                <button class="btn-buscadorNfc"><span>Buscar con NFC</span> <i class="bi bi-broadcast icon-buscadorNfc"></i></button>
                            </div>
                        </div>


                        <div class="buscadorFiltro">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="buscadorHab" placeholder="Buscar una habitación">
                                <label for="buscadorHab">Buscar habitación</label>
                            </div>
                        </div>

                    </div>

                    <div class="contenedorHab" id="contenedorCardInicial">
                        <div id="mensajeNoResultados" style="display: none;">No se encontraron habitaciones.</div>
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

                    <div id="contenedorCardFiltro"></div>
                </div>
            </div>
        </div>
        <div id="contenido-buscadorNfc"></div>
    </main>

    
    
    <!-- PIE DE PAGINA -->
    <footer class="pie-de-pagina">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>
    
    <!-- MODAL PARA BUSCAR CON NFC -->
    <div class="modal fade" id="modal-buscadorNfc" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="llaveroNfc">
                        <label for="codNfc">Acerque el llavero al sensor</label>
                        <input type="text" id="codNfc" name="codigoNfc" autocomplete="off">
                        <div class="icono-llaveroNfc">
                            <img src="../../iconos/iconoNfc.png" alt="Icono de llavero NFC">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODALES DE ESTADO -->

    <!-- MODAL DISPONIBLE -->
    <div class="modal fade" id="modalDisponible" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Disponible</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="btnOpciones">
                        <button id="cambiarEstadoDispo" data-bs-toggle="modal" data-bs-target="#modalEstadoDispo">Cambiar estado de la habitación</button>
                        <button id="btnReservarRecepcion">Reservar habitación</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- MODAL ESTADO DISPONIBLE -->
    <div class="modal fade" id="modalEstadoDispo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar estado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contentCamEstadoDis"></div>
            </div>
        </div>
    </div>


    <!-- MODAL ESTADO -->
    <div class="modal fade" id="modalEstado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar estado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contentCamEstadoDi"></div>
            </div>
        </div>
    </div>

    <!-- MODAL PENDIENTE -->
    <div class="modal fade" id="ModalPendiente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Reserva pendiente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="inforClientePendiente">

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL RESERVADA -->
    <div class="modal fade" id="Modalreservada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Reservada</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="inforClienteConfir">

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL OCUPADO -->
    <div class="modal fade" id="ModalOcupado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Ocupado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="inforClienteOcupado">

                </div>
            </div>
        </div>
    </div>

    <!-- ALERTAS -->

    <?php

    if (isset($_SESSION['msjExito'])) :
    ?>
        <div class="alert alert-success alerta" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i><?php echo $_SESSION['msjExito'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjExito']);
    endif;

    if (isset($_SESSION['msjError'])) :
    ?>
        <div class="alert alert-danger alerta" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i><?php echo $_SESSION['msjError'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjError']);
    endif;

    if (isset($_SESSION['msjReservasExito'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '¡RESERVA REGISTRADA!',
                html: '',
                showConfirmButton: true
            });
        </script>
    <?php
        unset($_SESSION['msjReservasExito']);
    endif;

    ?>


    <script src="../../js/scriptSelectRecepcion.js"></script>

    <script>
        $('#modal-buscadorNfc').on('shown.bs.modal', function() {
            $('#codNfc').focus();
        });
    </script>

</body>

</html>