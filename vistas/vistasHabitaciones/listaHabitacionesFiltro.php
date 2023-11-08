<?php

session_start();

include_once "../../procesos/config/conex.php";
include "funcionesIconos.php";

$fechaRango = $_GET['fechasRango'];
$huespedes = $_GET['huespedes'];
$sisClimatizacion = $_GET['selectClima'];

$arrayFechas = explode(" - ", $fechaRango);

$numeroHuespedes = preg_replace('/\D/', '', $huespedes);

$checkin = $arrayFechas[0];

$checkout = $arrayFechas[1];

$sqlHabitaciones = "SELECT id_habitaciones, id_hab_estado, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, tipoServicio, observacion, estado FROM habitaciones WHERE cantidadPersonasHab = " . $numeroHuespedes . " AND tipoServicio = " . $sisClimatizacion . " AND id_hab_estado = 1 AND estado = 1";

$resultHabitacion = $dbh->query($sqlHabitaciones);

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

    <!--     <header class="cabeceraHab">
        <div class="contenedorHab navContenedorHab">
            <div class="logoPlahotHab">
                <a href="../../index.php"><img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
            </div>
            <nav class="navegacionHab">
                <ul>
                    <li id="activoBucador">
                        <div class="buscador">
                            <div class="btnBuscar">
                                <i class="bi bi-search"></i>
                            </div>
                            <div class="inputBuscador">
                                <label for="buscador">Buscar</label>
                                <input type="text" id="buscador" placeholder="Buscar habitación">
                            </div>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>
 -->

</body>


<?php

if ($resultHabitacion->rowCount() > 0) {
    $datosHabitacion = $dbh->query($sqlHabitaciones)->fetch();

    if ($sisClimatizacion == 0) :
?>
        <main>
            <section class="container seccionHabitaciones">
                <div class="row">
                    <div class="col-15">
                        <?php

                        foreach ($resultHabitacion as $datosHabitacion) :

                            $idTipoHab = $datosHabitacion["id_hab_tipo"];

                            $sqlTipoHab = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, precioVentilador, precioAire, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $idTipoHab . " AND estado = 1";

                            $rowTipo = $dbh->query($sqlTipoHab)->fetch();

                            $sqlServicios = "SELECT habitaciones_elementos.elemento FROM habitaciones_tipos_elementos INNER JOIN habitaciones_elementos ON habitaciones_elementos.id_hab_elemento = habitaciones_tipos_elementos.id_hab_elemento WHERE id_hab_tipo = " . $idTipoHab . " AND estado = 1"; // Capturar servicios del tipo de la habitacion

                            $sqlImagenesTipoHab = "SELECT nombre, ruta, estado FROM habitaciones_imagenes WHERE estado = 1 AND id_hab_tipo = " . $idTipoHab . ""; //Capturar la ruta de las imagenes de los tipos de habitaciones

                        ?>

                            <div class="cardHabitaciones">
                            <div class="row">
                            <div class="col-3 responsive-img">
                                <div class="imagenesTipoHabitacion">
                                    <img src="../../img/1camaAire2.webp" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="informacionHabitacion">
                                    <div class="habitacionTitulo">
                                        <h1>Habitación 1</h1>
                                    </div>
                                    <div class="serviciosPrecio">
                                        <p>
                                            <span>Tipo de cama: doble</span>
                                        </p>
                                        <p>
                                            <span>Capacidad: 2 personas</span> 
                                        </p>
                                    </div>
                                    <div class="servicios">

                                    </div>
                                    <div class="descripcionHabitacion">
                                        <p>Muy comodo</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                            </div>


                        <?php
                        endforeach;
                        ?>
                    </div>
            </section>
        </main>
<?php
    endif;
} else {
    $_SESSION['msjError'] = "No se encontraron habitaciones disponibles";
    header("location: ../pagHabitaciones.php");
}
?>

</html>