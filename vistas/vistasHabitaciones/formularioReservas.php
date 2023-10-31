<?php

session_start();

date_default_timezone_set('America/Bogota'); // Establecer la zona horaria

include_once "../../procesos/config/conex.php";
include "funcionesIconos.php";

$estadoId = false;
$pagFiltro = false;

if (!empty($_GET['idHabitacion']) && !empty($_GET['idTipoHab'])) { // Condicion para saber si los campos no estan vacios

    $habitacion = $_GET['idHabitacion']; // capturar por medio de GET
    $tipoHabitacion = $_GET['idTipoHab'];

    $url = "";

    if (!empty($_GET['filtro'])) {
        $pagFiltro = true;
        $fechaRango = $_GET['fechasRango'];
        $huespedes = $_GET['huespedes'];
        $sisClimatizacion = $_GET['sisClimatizacion'];

        $arrayFechas = explode(" - ", $fechaRango);

        $checkin = $arrayFechas[0];

        $checkin = str_replace("/", "-", $checkin); // Reemplazamos "/" por "-"

        $checkout = $arrayFechas[1];

        $checkout = str_replace("/", "-", $checkout); // Reemplazamos "/" por "-"

        $url .= "listaHabitacionesFiltro.php?fechasRango=" . $fechaRango . "&huespedes=" . $huespedes . "&selectClima=" . $sisClimatizacion . "";
    } else {

        $fechaRango = $_GET['fechasRango'];
        $arrayFechas = explode(" - ", $fechaRango);
        $checkin = $arrayFechas[0];
        $checkout = $arrayFechas[1];
        
        $url .= "mostrarListaHabitaciones.php?idTipoHab=" . $tipoHabitacion . "";
    }

    $sqlHabitacion = "SELECT id_habitaciones, id_hab_estado, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, tipoServicio, observacion, estado FROM habitaciones WHERE id_habitaciones = " . $habitacion . " AND estado = 1";

    $rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

    $sqlTipoHab = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, precioVentilador, precioAire, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $tipoHabitacion . " AND estado = 1";

    $rowTipoHab = $dbh->query($sqlTipoHab)->fetch();

    $sqlimagenesTipoHab = "SELECT nombre, ruta, estado FROM habitaciones_imagenes WHERE estado = 1 AND id_hab_tipo = " . $tipoHabitacion . "";

    $rowImgTipoHab = $dbh->query($sqlimagenesTipoHab)->fetch();

    $estadoId = true;
} else {
    echo "Ocurrió un error";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "dependecias.php" ?>
    <title>Habitaciones | Hotel Colonial City</title>
</head>

<body>

    <?php

    if ($estadoId) :
    ?>

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

        <header class="cabeceraHab">
            <div class="contenedorHab navContenedorHab">
                <div class="logoPlahotHab">
                    <a href="../../index.html"><img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
                </div>
                <nav class="navegacionHab">
                    <ul>
                        <li id="vinculoVolver">
                            <?php

                            if ($pagFiltro) :
                            ?>
                                <a href="<?php echo $url ?>">Volver</a>
                            <?php
                            else :
                            ?>
                                <a href="<?php echo $url ?>">Volver</a>
                            <?php
                            endif;
                            ?>
                        </li>
                    </ul>
                </nav>
            </div>
        </header>

        <main class="container">
            <div class="row rowPrincipal">
                <div class="col-8 col-informacion">
                    <div class="card-infor-reserva">
                        <div class="row">
                            <div class="col-4">
                                <div class="imagenes">
                                    <img src="../../imgServidor/<?php echo $rowImgTipoHab['ruta'] ?>" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="informacion">
                                    <div class="habitacion">
                                        <h1>Habitación <?php echo $rowHabitacion['nHabitacion'] ?> | <?php echo $rowTipoHab['tipoHabitacion'] ?></h1>
                                    </div>
                                    <div class="servicios">
                                        <p>
                                            <span>Tipo de cama:</span> <?php iconCantidadCama($rowHabitacion['tipoCama']) ?>
                                        </p>
                                        <p>
                                            <span>Capacidad:</span> <?php echo iconCapacidad($rowHabitacion['cantidadPersonasHab']) ?>
                                        </p>
                                    </div>
                                    <div class="descripcion">
                                        <p><?php echo $rowHabitacion['observacion']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="formularioReserva">
                        <h2>Datos</h2>
                        <form action="" method="post">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="Nombres">
                                        <label for="floatingInput">Nombres</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <?php
                                        if ($pagFiltro) :
                                        ?>
                                            <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin ?>">
                                        <?php
                                        else :
                                        ?>
                                            <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin?>">
                                        <?php
                                        endif;
                                        ?>
                                        <label for="fechaEntrada">Fecha de llegada</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="Nombres">
                                        <label for="floatingInput">Documento</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="Nombres">
                                        <label for="floatingInput">Sexo</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="Nombres">
                                        <label for="floatingInput">Ciudad de origen</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="Nombres">
                                        <label for="floatingInput">Apellidos</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                    <?php
                                        if ($pagFiltro) :
                                        ?>
                                            <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>">
                                        <?php
                                        else :
                                        ?>
                                            <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>">
                                        <?php
                                        endif;
                                        ?>
                                        <label for="fechaSalida">Fecha de salida</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="Nombres">
                                        <label for="floatingInput">Teléfono</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="Nombres">
                                        <label for="floatingInput">Nacionalidad</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="floatingInput" placeholder="Nombres">
                                        <label for="floatingInput">Email</label>
                                    </div>
                                </div>
                            </div>
                            <div class="btnReservar">
                                <input type="submit" name="btnReservar" value="Reservar">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col col-factura">
                   <?php include "reservas/facturaReserva.php"; ?>
                </div>
            </div>
        </main>

    <?php
    endif;

    ?>


</body>

</html>