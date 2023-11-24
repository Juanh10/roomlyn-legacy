<?php

session_start();

include_once "../../procesos/config/conex.php";
include "funcionesIconos.php";

$fechaRango = $_GET['fechasRango'];
$huespedes = $_GET['huespedes'];
$sisClimatizacion = $_GET['selectClima'];

$arrayFechas = explode(" - ", $fechaRango); // separar los rangos de fecha segun el caracter "-"

$numeroHuespedes = preg_replace('/\D/', '', $huespedes); // Eliminar todos los caracteres no numericos

$checkin = $arrayFechas[0];

$checkout = $arrayFechas[1];

//Consultas SQL de las habitaciones segun lo que el usuario escogio en el filtro

$sqlHabitaciones = "SELECT id_habitacion, id_hab_estado, id_servicio, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE cantidadPersonasHab = " . $numeroHuespedes . " AND id_servicio = " . $sisClimatizacion . " AND id_hab_estado = 1 AND estado = 1";

$resultHabitacion = $dbh->query($sqlHabitaciones);

if ($resultHabitacion) {

    // Inicializar un arreglo para almacenar los tipos de habitación
    $arregloTipo = array();

    // Recorrer los resultados de la consulta sobre las habitaciones
    while ($datosHabitacion = $resultHabitacion->fetch(PDO::FETCH_ASSOC)) {

        // Consulta SQL para obtener información sobre los tipos de habitaciones según la habitación seleccionada

        $sqlIdTipoHabitacion = "SELECT id_hab_tipo FROM habitaciones_tipos WHERE id_hab_tipo = " . $datosHabitacion['id_hab_tipo'] . " AND estado = 1";

        $datosTipos = $dbh->query($sqlIdTipoHabitacion)->fetch();

        // Verificar si el tipo de habitación ya existe en el arreglo
        if (!isset($arregloTipo[$datosTipos['id_hab_tipo']])) {
            // Agregar el tipo de habitación al arreglo
            $arregloTipo[$datosTipos['id_hab_tipo']] = $datosTipos['id_hab_tipo'];
        }
    }
}

$ventilador = 1;
$aire = 2;
$estado = 1;

//! CONSULTAS DE LA BASE DE DATOS PARA LA INFORMACION DE LOS TIPOS DE HABITACIONES

$sqlTipoHabitaciones = $dbh->prepare("SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, estado FROM habitaciones_tipos WHERE id_hab_tipo = :idTipo AND estado = 1"); // Capturar la informacion del tipo de la habitacion

$sqlImagenesTipoHab = $dbh->prepare("SELECT nombre, ruta, estado FROM habitaciones_imagenes WHERE estado = 1 AND id_hab_tipo = :idTipoImg"); //Capturar la ruta de las imagenes de los tipos de habitaciones

$sqlServicios = $dbh->prepare("SELECT habitaciones_servicios.servicio FROM habitaciones_tipos_servicios INNER JOIN habitaciones_servicios ON habitaciones_servicios.id_servicio = habitaciones_tipos_servicios.id_servicio WHERE id_hab_tipo = :idTipoServ AND estado = 1"); // Capturar servicios del tipo de la habitacion

$sqlHabitacionesTi = $dbh->prepare("SELECT id_habitacion, id_hab_estado, id_servicio, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE cantidadPersonasHab = " . $numeroHuespedes . " AND id_servicio = " . $sisClimatizacion . " AND id_hab_tipo = :idTipoHab AND id_hab_estado = 1 AND estado = 1");

$sqlPrecios = $dbh->prepare("SELECT htp.id_tipo_servicio, htp.precio, htp.estado, habitaciones_servicios.servicio FROM habitaciones_tipos_precios htp INNER JOIN habitaciones_tipos_servicios hts ON hts.id_tipo_servicio = htp.id_tipo_servicio INNER JOIN habitaciones_servicios ON habitaciones_servicios.id_servicio = hts.id_servicio WHERE hts.id_hab_tipo = :idTipo AND hts.id_servicio = :idServ AND htp.estado = :estado");

$sqlElementosHab = $dbh->prepare("SELECT habitaciones_elementos.elemento FROM habitaciones_elementos_selec INNER JOIN habitaciones_elementos ON habitaciones_elementos.id_hab_elemento = habitaciones_elementos_selec.id_hab_elemento WHERE id_habitacion = :idHab AND estado = :estado");

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

    <header class="cabeceraHab">
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


</body>


<?php

if ($resultHabitacion->rowCount() > 0) {



    if ($sisClimatizacion == 1) :
?>
        <main>

            <?php

            foreach ($arregloTipo as $datosTipo) :

                $sqlTipoHabitaciones->bindParam(':idTipo', $datosTipo);
                $sqlImagenesTipoHab->bindParam(':idTipoImg', $datosTipo);
                $sqlServicios->bindParam(':idTipoServ', $datosTipo);

                $sqlTipoHabitaciones->execute();

                while ($rowTipo = $sqlTipoHabitaciones->fetch(PDO::FETCH_ASSOC)) :
                    $idTipoHab = $rowTipo['id_hab_tipo'];
            ?>
                    <h1 class="tituloTipoHab"><?php echo $rowTipo['tipoHabitacion'] ?></h1>
                    <section class="container seccionHabitaciones">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="informacionList">
                                    <h2 class="fs-4 mt-4 mb-4 text-center">Habitaciones con ventilador</h2>

                                    <div class="imgTipo">
                                        <div id="carruselImagenesTipoHab" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php
                                                $sqlImagenesTipoHab->execute();
                                                $primeraImg = true;
                                                while ($rowImg = $sqlImagenesTipoHab->fetch(PDO::FETCH_ASSOC)) :
                                                    $claseActive = $primeraImg ? 'active' : '';
                                                ?>
                                                    <div class="carousel-item <?php echo $claseActive ?> coverImg" data-bs-interval="5000">
                                                        <a href="../../imgServidor/<?php echo $rowImg['ruta'] ?>" data-lightbox="fotosHotel<?php echo $datosTipo ?>">
                                                            <img src="../../imgServidor/<?php echo $rowImg['ruta'] ?>" alt="Fotos de <?php echo $rowTipo['tipoHabitacion'] ?>" class="img-fluid rounded mx-auto d-block mb-4">
                                                        </a>
                                                    </div>

                                                <?php
                                                    $primeraImg = false;

                                                endwhile;
                                                ?>
                                            </div>
                                            <?php

                                            if ($sqlImagenesTipoHab->rowCount() > 1) :
                                            ?>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                    </div>

                                    <p class="ms-3 mt-3">

                                        Precio por día: <?php

                                                        $sqlPrecios->bindParam(':idTipo', $idTipoHab);
                                                        $sqlPrecios->bindParam(':idServ', $ventilador);
                                                        $sqlPrecios->bindParam(':estado', $estado);
                                                        $sqlPrecios->execute();
                                                        $resulPrecio = $sqlPrecios->fetch();
                                                        echo number_format($resulPrecio['precio'], 0, ",", ".")

                                                        ?> + IVA
                                    </p>

                                    <ul class="listServicios">
                                        <li><?php echo $rowTipo['cantidadCamas'] ?> Cama sencilla o doble</li>
                                        <?php
                                        $sqlServicios->execute();

                                        while ($row2 = $sqlServicios->fetch(PDO::FETCH_ASSOC)) :
                                            if (strtolower($row2['servicio']) != "aire acondicionado") :
                                        ?>
                                                <li><?php echo $row2['servicio'] ?></li>
                                        <?php
                                            endif;
                                        endwhile;
                                        ?>
                                    </ul>

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="listadoHab">
                                    <?php

                                    $sqlHabitacionesTi->bindParam(':idTipoHab', $datosTipo);

                                    $sqlHabitacionesTi->execute();
                                    if ($sqlHabitacionesTi->rowCount() > 0) :
                                        while ($row3 = $sqlHabitacionesTi->fetch(PDO::FETCH_ASSOC)) :
                                            $capacidadPerson = $row3['cantidadPersonasHab'];
                                            $tipoCama = $row3['tipoCama'];
                                            $idHab = $row3['id_habitacion'];
                                            $sqlElementosHab->bindParam(':idHab', $idHab);
                                            $sqlElementosHab->bindParam(':estado', $estado);
                                            $sqlElementosHab->execute();

                                    ?>
                                            <div class="cardHabitaciones">
                                                <div class="inforHabitacion">
                                                    <h3>Habitación <?php echo $row3['nHabitacion'] ?></h3>
                                                    <div class="datosHabitacion">
                                                        <p>
                                                            <span>Tipo de cama:</span>
                                                            <?php iconCantidadCama($tipoCama); ?>
                                                        </p>

                                                        <p title="Capacidad para <?php echo ($capacidadPerson > 1) ? $capacidadPerson . " personas" : $capacidadPerson . " persona" ?>">
                                                            <span>Capacidad:</span>
                                                            <?php iconCapacidad($capacidadPerson) ?>
                                                        </p>
                                                    </div>
                                                    <div class="elementos">
                                                        <p>
                                                            <?php
                                                            $rowCount = $sqlElementosHab->rowCount(); // Obtén el número total de filas
                                                            $currentRow = 0; // Inicializa el contador de filas

                                                            while ($resElemento = $sqlElementosHab->fetch(PDO::FETCH_ASSOC)) :
                                                                // Imprime el elemento actual
                                                                echo $resElemento['elemento'];

                                                                // Incrementa el contador de filas
                                                                $currentRow++;

                                                                // Si no es la última fila, agrega un guion
                                                                if ($currentRow < $rowCount) {
                                                                    echo ' - ';
                                                                }
                                                            endwhile;
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <p><?php echo $row3['observacion'] ?></p>
                                                </div>
                                                <a href="formularioReservas.php?idHabitacion=<?php echo $row3['id_habitacion'] ?>&idTipoHab=<?php echo $datosTipo ?>&fechasRango=<?php echo $fechaRango ?>&filtro=true&huespedes=<?php echo $huespedes ?>&sisClimatizacion=<?php echo $sisClimatizacion ?>&filtro=true" class="btnSelecHab">Seleccionar</a>
                                            </div>
                                        <?php

                                        endwhile;
                                    else :
                                        ?>
                                        <div class="hab-no-disponibles">
                                            <span>No se encontraron habitaciones disponibles</span>
                                        </div>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php
                endwhile;

                ?>
            <?php
            endforeach;

            ?>

        </main>
    <?php

    else :

    ?>
        <main>

            <?php

            foreach ($arregloTipo as $datosTipo) :

                $sqlTipoHabitaciones->bindParam(':idTipo', $datosTipo);
                $sqlImagenesTipoHab->bindParam(':idTipoImg', $datosTipo);
                $sqlServicios->bindParam(':idTipoServ', $datosTipo);

                $sqlTipoHabitaciones->execute();

                while ($rowTipo = $sqlTipoHabitaciones->fetch(PDO::FETCH_ASSOC)) :
                    $idTipoHab = $rowTipo['id_hab_tipo'];
            ?>
                    <h1 class="tituloTipoHab"><?php echo $rowTipo['tipoHabitacion'] ?></h1>
                    <section class="container seccionHabitaciones">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="informacionList">
                                    <h2 class="fs-4 mt-4 mb-4 text-center">Habitaciones con aire acondicionado</h2>

                                    <div class="imgTipo">
                                        <div id="carruselImagenesTipoHab" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <?php
                                                $sqlImagenesTipoHab->execute();
                                                $primeraImg = true;
                                                while ($rowImg = $sqlImagenesTipoHab->fetch(PDO::FETCH_ASSOC)) :
                                                    $claseActive = $primeraImg ? 'active' : '';
                                                ?>
                                                    <div class="carousel-item <?php echo $claseActive ?> coverImg" data-bs-interval="5000">
                                                        <a href="../../imgServidor/<?php echo $rowImg['ruta'] ?>" data-lightbox="fotosHotel<?php echo $datosTipo ?>">
                                                            <img src="../../imgServidor/<?php echo $rowImg['ruta'] ?>" alt="Fotos de <?php echo $rowTipo['tipoHabitacion'] ?>" class="img-fluid rounded mx-auto d-block mb-4">
                                                        </a>
                                                    </div>

                                                <?php
                                                    $primeraImg = false;

                                                endwhile;
                                                ?>
                                            </div>
                                            <?php

                                            if ($sqlImagenesTipoHab->rowCount() > 1) :
                                            ?>
                                                <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Previous</span>
                                                </button>
                                                <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="visually-hidden">Next</span>
                                                </button>
                                            <?php
                                            endif;
                                            ?>
                                        </div>
                                    </div>

                                    <p class="ms-3 mt-3">

                                        Precio por día: <?php

                                                        $sqlPrecios->bindParam(':idTipo', $idTipoHab);
                                                        $sqlPrecios->bindParam(':idServ', $aire);
                                                        $sqlPrecios->bindParam(':estado', $estado);
                                                        $sqlPrecios->execute();
                                                        $resulPrecio = $sqlPrecios->fetch();
                                                        echo number_format($resulPrecio['precio'], 0, ",", ".")

                                                        ?> + IVA
                                    </p>

                                    <ul class="listServicios">
                                        <li><?php echo $rowTipo['cantidadCamas'] ?> Cama sencilla o doble</li>
                                        <?php
                                        $sqlServicios->execute();

                                        while ($row2 = $sqlServicios->fetch(PDO::FETCH_ASSOC)) :
                                            if (strtolower($row2['servicio']) != "ventilador") :
                                        ?>
                                                <li><?php echo $row2['servicio'] ?></li>
                                        <?php
                                            endif;
                                        endwhile;
                                        ?>
                                    </ul>

                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="listadoHab">
                                    <?php

                                    $sqlHabitacionesTi->bindParam(':idTipoHab', $datosTipo);

                                    $sqlHabitacionesTi->execute();
                                    if ($sqlHabitacionesTi->rowCount() > 0) :
                                        while ($row3 = $sqlHabitacionesTi->fetch(PDO::FETCH_ASSOC)) :
                                            $capacidadPerson = $row3['cantidadPersonasHab'];
                                            $tipoCama = $row3['tipoCama'];
                                            $idHab = $row3['id_habitacion'];
                                            $sqlElementosHab->bindParam(':idHab', $idHab);
                                            $sqlElementosHab->bindParam(':estado', $estado);
                                            $sqlElementosHab->execute();
                                    ?>
                                            <div class="cardHabitaciones">
                                                <div class="inforHabitacion">
                                                    <h3>Habitación <?php echo $row3['nHabitacion'] ?></h3>
                                                    <div class="datosHabitacion">
                                                        <p>
                                                            <span>Tipo de cama:</span>
                                                            <?php iconCantidadCama($tipoCama); ?>
                                                        </p>

                                                        <p title="Capacidad para <?php echo ($capacidadPerson > 1) ? $capacidadPerson . " personas" : $capacidadPerson . " persona" ?>">
                                                            <span>Capacidad:</span>
                                                            <?php iconCapacidad($capacidadPerson) ?>
                                                        </p>
                                                    </div>
                                                    <div class="elementos">
                                                        <p>
                                                            <?php
                                                            $rowCount = $sqlElementosHab->rowCount(); // Obtén el número total de filas
                                                            $currentRow = 0; // Inicializa el contador de filas

                                                            while ($resElemento = $sqlElementosHab->fetch(PDO::FETCH_ASSOC)) :
                                                                // Imprime el elemento actual
                                                                echo $resElemento['elemento'];

                                                                // Incrementa el contador de filas
                                                                $currentRow++;

                                                                // Si no es la última fila, agrega un guion
                                                                if ($currentRow < $rowCount) {
                                                                    echo ' - ';
                                                                }
                                                            endwhile;
                                                            ?>
                                                        </p>
                                                    </div>
                                                    <p><?php echo $row3['observacion'] ?></p>
                                                </div>
                                                <a href="formularioReservas.php?idHabitacion=<?php echo $row3['id_habitacion'] ?>&idTipoHab=<?php echo $datosTipo ?>&fechasRango=<?php echo $fechaRango ?>&filtro=true&huespedes=<?php echo $huespedes ?>&sisClimatizacion=<?php echo $sisClimatizacion ?>&filtro=true" class="btnSelecHab">Seleccionar</a>
                                            </div>
                                        <?php
                                        endwhile;
                                    else :
                                        ?>
                                        <div class="hab-no-disponibles">
                                            <span>No se encontraron habitaciones disponibles</span>
                                        </div>
                                    <?php
                                    endif;
                                    ?>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php
                endwhile;

                ?>
            <?php
            endforeach;

            ?>

        </main>
<?php



    endif;
} else {
    $_SESSION['msjError'] = "No se encontraron habitaciones disponibles";
    header("location: ../pagHabitaciones.php");
}
?>

</html>