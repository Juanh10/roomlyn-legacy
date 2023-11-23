<?php

session_start();

include_once "../../procesos/config/conex.php";

if (empty($_SESSION['id_cliente_registrado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

$estadoTipo = 1;

$idCliente = $_SESSION['id_cliente_registrado'];
$nombres = explode(" ", $_SESSION['nombres']);
$apellidos = explode(" ", $_SESSION['apellidos']);

$primerNombre = $nombres[0];
$primerApellido = $apellidos[0];

$sql = "SELECT reservas.id_reserva, reservas.id_cliente, reservas.id_estado_reserva, reservas.fecha_ingreso, reservas.fecha_salida, reservas.total_reserva, reservas.estado, reservas.fecha_sys, habitaciones.id_habitacion, habitaciones.nHabitacion, habitaciones.cantidadPersonasHab, habitaciones.observacion, habitaciones_tipos.id_hab_tipo, habitaciones_tipos.tipoHabitacion, estado_reservas.nombre_estado FROM reservas INNER JOIN clientes_registrados ON reservas.id_cliente = clientes_registrados.id_cliente_registrado INNER JOIN habitaciones ON habitaciones.id_habitacion = reservas.id_habitacion INNER JOIN habitaciones_tipos ON habitaciones_tipos.id_hab_tipo = habitaciones.id_hab_tipo INNER JOIN estado_reservas ON estado_reservas.id_estado_reserva = reservas.id_estado_reserva WHERE id_cliente = " . $idCliente . "";

$sqlImagenes = $dbh->prepare("SELECT nombre, MIN(ruta) AS ruta, estado FROM habitaciones_imagenes WHERE id_hab_tipo = :idTipo AND estado = :estado");

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "dependencias.php" ?>
    <title>Configuración</title>
</head>

<body>


    <!--* PRELOADER CARGAR PAGINA WEB -->

    <div class="contenedorPreloader" id="onload">
        <div class="lds-default">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>


    <header class="cabecera">
        <div class="contenedor navContenedor">
            <div class="logoPlahot">
                <a href="../../index.php"><img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
            </div>
            <div class="menuRespon">
                <div class="icono">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <nav class="navegacion">
                <ul>
                    <li class="inicioSesionCliente" title="Conectado">
                        <a href="configuracionCuenta.php" class="inicioSesion"><span class="conexion"></span><?php echo $primerNombre . " " . $primerApellido ?></a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container contenedorPrincipal">
            <h1>RESERVAS REALIZADAS</h1>

            <div class="row">
                <div class="col">
                    <div class="filtrosReserva">
                        <div class="colFechaFiltro">
                        <div class="desplegarFecha">
                            <span class="desplegarFiltroFecha">Filtrar por fecha</span>
                        </div>
                            <form id="formFiltroFecha">
                                <input type="hidden" id="idCliente" value="<?php echo $idCliente ?>">
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fechaInicio" required>
                                    <label for="fechaInicio">Fecha inicial</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fechaFinal" required>
                                    <label for="fechaFinal">Fecha final</label>
                                </div>
                                <div class="colBotonFiltro">
                                    <button type="button" class="btn btnFitrarFecha" id="filtroBtnFecha">Filtrar</button>
                                </div>
                            </form>
                        </div>
                        <div class="filtroSelect">
                            <span class="desplegarFiltroSelect">Filtrar por estado de la reserva</span>
                            <form id="formSelectFiltro">
                                <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $idCliente ?>">
                                <div class="form-floating mb-3">
                                    <select name="selectFiltro" class="form-select" id="selectFiltro">
                                        <option selected disabled>Estado</option>
                                        <option value="1">Pendiente</option>
                                        <option value="2">Confirmada</option>
                                        <option value="3">Cancelada</option>
                                        <option value="4">Finalizada</option>
                                    </select>
                                    <label for="selectFiltro">Reservas</label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="cotenedorCard" id="contenedorCardInicial">
                        <?php
                        foreach ($dbh->query($sql) as $row) :

                            $idHabitacion = $row['id_habitacion'];
                            $idReserva = $row['id_reserva'];
                            $idTipo = $row['id_hab_tipo'];
                            $checkIn = $row['fecha_ingreso'];
                            $checkOut = $row['fecha_salida'];
                            $totalReserva = $row['total_reserva'];
                            $habitacion = $row['nHabitacion'];
                            $tipoHabitacion = $row['tipoHabitacion'];
                            $idEstado = $row['id_estado_reserva'];
                            $estado = $row['nombre_estado'];
                            $fechaRegistro = $row['fecha_sys'];

                            $sqlImagenes->bindParam(':idTipo', $idTipo);
                            $sqlImagenes->bindParam(':estado', $estadoTipo);

                            $sqlImagenes->execute();

                            $resulImg = $sqlImagenes->fetch(PDO::FETCH_ASSOC);
                        ?>
                            <div class="cardReserva">
                                <div class="imgHabitacion">
                                    <img src="../../imgServidor/<?php echo $resulImg['ruta']; ?>" alt="Foto del tipo de habitación">
                                </div>
                                <div class="informacionCard">
                                    <div class="inforHabitacion">
                                        <h2>Habitación <?php echo $habitacion . "|" . $tipoHabitacion; ?></h2>
                                        <span>Tipo: 1 simple</span>
                                        <span>Capacidad: 1 persona</span>
                                        <span>Descripción: Primer piso</span>
                                    </div>
                                    <div class="inforReserva">
                                        <span>Entrada: <?php echo $checkIn ?></span>
                                        <span>Salida: <?php echo $checkOut ?></span>
                                        <div class="totalReserva">
                                            <span>TOTAL: <?php echo number_format($totalReserva, 0, ',', '.') ?> COP</span>
                                        </div>
                                        <div class="estadoReserva">
                                            <span>Estado de la reserva: <?php echo $estado ?></span>
                                        </div>
                                    </div>
                                    <?php
                                    if ($idEstado != 4 && $idEstado != 3) :
                                    ?>
                                        <div class="botonCancelReserva">
                                            <form action="../../procesos/registroReservas/conCancelarReserva.php" method="post" class="formCancelarReserva">
                                                <input type="hidden" name="idReserva" value="<?php echo $idReserva ?>">
                                                <input type="hidden" name="idHabitacion" value="<?php echo $idHabitacion ?>">
                                                <input type="submit" class="btnCancel" name="btnCancel" value="Cancelar reserva">
                                            </form>
                                        </div>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                    <div id="contenedorCardFiltro"></div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <div class="piePagina">
            <div class="copyPiePagina">
                <div class="logoPiePagina">
                    <img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web">
                </div>
                <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
            </div>
            <div class="contenidoPiePagina">
                <div class="redes-sociales">
                    <ul>
                        <li><a href="https://www.facebook.com/profile.php?id=61550262616792" class="face" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/hotelcolonialci2/" class="insta" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com/@colonialespinal2023" class="what" target="_blank" title="Whatsapp"><i class="bi bi-whatsapp"></i></a></li>
                        <li><a href="https://www.tiktok.com/@colonialespinal2023" class="tiktok" target="_blank" title="Tik tok"><i class="bi bi-tiktok"></i></a></li>
                    </ul>
                </div>
                <div class="contPreguntas">
                    <a href="../../comoFunciona.html">Como funciona ROOMLYN</a>
                    <a href="#">Politicas de privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <?php

    if (isset($_SESSION['msjCn'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '<?php echo $_SESSION['msjCn']; ?>',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    <?php
        unset($_SESSION['msjCn']);
    endif;

    ?>

</body>

</html>