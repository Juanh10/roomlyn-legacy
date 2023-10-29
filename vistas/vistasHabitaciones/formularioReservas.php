<?php

session_start();

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

        $url .= "listaHabitacionesFiltro.php?fechasRango=" . $fechaRango . "&huespedes=" . $huespedes . "&selectClima=" . $sisClimatizacion . "";
    } else {
        $url .= "mostrarListaHabitaciones.php?idTipoHab=" . $tipoHabitacion . "";
    }

    $sqlHabitacion = "";
    $sqlTipoHab = "";

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

    <?php
    endif;

    ?>


</body>

</html>