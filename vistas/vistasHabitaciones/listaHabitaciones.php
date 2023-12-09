<?php

date_default_timezone_set('America/Bogota'); // Establecer la zona horaria

include_once "../../procesos/config/conex.php";
include "funcionesIconos.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../iconos/logo_icono.png">
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

    <main>

        <?php
        function mostrarTituloTipo($id, $dbh)
        {


            $sqlTipoHabitacion = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $id . " AND estado = 1"; // Capturar la informacion del tipo de la habitacion

            foreach ($dbh->query($sqlTipoHabitacion) as $row) {
        ?>
                <h1 class="tituloTipoHab"><?php echo $row['tipoHabitacion'] ?></h1>
        <?php
            }
        }

        ?>

        <?php
        function mostrarDatosHabitaciones($filtro, $id, $dbh)
        {
            $estado = 1;

            $fechaActual = date('Y-m-d');

            $fechaSiguiente = date("Y-m-d", strtotime($fechaActual . " +1 day")); // Calcular la fecha del día siguiente

            $rangoFecha = $fechaActual . " - " . $fechaSiguiente;

            if ($filtro === "ventilador") {
                $tipoServ = 1;
            } else if ($filtro === "aire") {
                $tipoServ = 2;
            }

            $sqlTipoHabitacion = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $id . " AND estado = 1"; // Capturar la informacion del tipo de la habitacion

            $sqlServicios = "SELECT habitaciones_servicios.servicio FROM habitaciones_tipos_servicios INNER JOIN habitaciones_servicios ON habitaciones_servicios.id_servicio = habitaciones_tipos_servicios.id_servicio WHERE id_hab_tipo = " . $id . " AND estado = 1"; // Capturar servicios del tipo de la habitacion

            $sqlImagenesTipoHab = "SELECT nombre, ruta, estado FROM habitaciones_imagenes WHERE estado = 1 AND id_hab_tipo = " . $id . ""; //Capturar la ruta de las imagenes de los tipos de habitaciones

            $sqlHabitacion = "SELECT id_habitacion, nHabitacion, id_hab_tipo, id_hab_estado, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE id_hab_tipo = " . $id . " AND id_servicio = " . $tipoServ . " AND id_hab_estado = 1 AND estado = 1"; // Capturar toda la informacion de la habitacion

            $sqlPrecios = $dbh->prepare("SELECT htp.id_tipo_servicio, htp.precio, htp.estado, habitaciones_servicios.servicio FROM habitaciones_tipos_precios htp INNER JOIN habitaciones_tipos_servicios hts ON hts.id_tipo_servicio = htp.id_tipo_servicio INNER JOIN habitaciones_servicios ON habitaciones_servicios.id_servicio = hts.id_servicio WHERE hts.id_hab_tipo = :idTipo AND hts.id_servicio = :idServ AND htp.estado = :estado");

            $sqlElementosHab = $dbh->prepare("SELECT habitaciones_elementos.elemento FROM habitaciones_elementos_selec INNER JOIN habitaciones_elementos ON habitaciones_elementos.id_hab_elemento = habitaciones_elementos_selec.id_hab_elemento WHERE id_habitacion = :idHab AND estado = :estado");

            $row = $dbh->query($sqlTipoHabitacion)->fetch(); // Obtener datos

            if ($filtro == "ventilador") {

                $verntilador = 1;
        ?>
                <section class="container seccionHabitaciones">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="informacionList">

                                <h2 class="fs-4 mt-4 mb-4 text-center">Habitaciones con ventilador</h2>

                                <div class="imgTipo">
                                    <div id="carruselImagenesTipoHab" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php
                                            $primeraImg = true;

                                            $resultImg = $dbh->query($sqlImagenesTipoHab);
                                            foreach ($resultImg as $rowImg) :
                                                $claseActive = $primeraImg ? 'active' : '';
                                            ?>
                                                <div class="carousel-item <?php echo $claseActive ?> coverImg" data-bs-interval="5000">
                                                    <a href="../../imgServidor/<?php echo $rowImg['ruta'] ?>" data-lightbox="fotosHotel">
                                                        <img src="../../imgServidor/<?php echo $rowImg['ruta'] ?>" alt="Fotos de <?php echo $row['tipoHabitacion'] ?>" class="img-fluid rounded mx-auto d-block mb-4">
                                                    </a>
                                                </div>

                                            <?php
                                                $primeraImg = false;
                                            endforeach;
                                            ?>
                                        </div>
                                        <?php

                                        if ($resultImg->rowCount() > 1) :
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

                                <p class="ms-3 mt-3">Precio por día:
                                    <?php
                                    $sqlPrecios->bindParam(':idTipo', $id);
                                    $sqlPrecios->bindParam(':idServ', $verntilador);
                                    $sqlPrecios->bindParam(':estado', $estado);
                                    $sqlPrecios->execute();
                                    $resulPrecio = $sqlPrecios->fetch();
                                    echo number_format($resulPrecio['precio'], 0, ",", ".") ?> + IVA
                                </p>

                                <ul class="listServicios">
                                    <li><?php echo $row['cantidadCamas'] ?> Cama sencilla o doble</li>
                                    <?php
                                    foreach ($dbh->query($sqlServicios) as $row2) :
                                        if (strtolower($row2['servicio']) != "aire acondicionado") :
                                    ?>
                                            <li><?php echo $row2['servicio'] ?></li>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>

                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="listadoHab">
                                <?php

                                $resulFilasHabitaciones = $dbh->query($sqlHabitacion);
                                if ($resulFilasHabitaciones->rowCount() > 0) :
                                    foreach ($resulFilasHabitaciones as $row3) :
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
                                            <a href="formularioReservas.php?idHabitacion=<?php echo $row3['id_habitacion'] ?>&idTipoHab=<?php echo $id ?>&fechasRango=<?php echo $rangoFecha ?>" class="btnSelecHab">Reservar</a>
                                        </div>
                                    <?php
                                    endforeach;
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
                </section>
            <?php
            } else if ($filtro == "aire") {
                $aire = 2;
            ?>
                <section class="container seccionHabitaciones">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="informacionList">

                                <h2 class="fs-4 mt-4 mb-4 text-center">Habitaciones con aire acondicionado</h2>

                                <div class="imgTipo">
                                    <div id="carruselImagenesTipoHab2" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php
                                            $primeraImg = true;
                                            $resultImg = $dbh->query($sqlImagenesTipoHab);
                                            foreach ($resultImg as $rowImg) :
                                                $claseActive = $primeraImg ? 'active' : '';
                                            ?>
                                                <div class="carousel-item <?php echo $claseActive ?> coverImg" data-bs-interval="5000">
                                                    <a href="../../imgServidor/<?php echo $rowImg['ruta'] ?>" data-lightbox="fotosHotel<?php echo $id ?>">
                                                        <img src="../../imgServidor/<?php echo $rowImg['ruta'] ?>" alt="Fotos de las habitaciones del tipo seleccionado" class="img-fluid rounded mx-auto d-block mb-4">
                                                    </a>
                                                </div>

                                            <?php
                                                $primeraImg = false;
                                            endforeach;
                                            ?>
                                        </div>
                                        <?php
                                        if ($resultImg->rowCount() > 1) :
                                        ?>
                                            <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenesTipoHab2" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenesTipoHab2" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                        <?php
                                        endif;
                                        ?>

                                    </div>
                                </div>

                                <p class="ms-3 mt-3">Precio por día:
                                    <?php
                                    $sqlPrecios->bindParam(':idTipo', $id);
                                    $sqlPrecios->bindParam(':idServ', $aire);
                                    $sqlPrecios->bindParam(':estado', $estado);
                                    $sqlPrecios->execute();
                                    $resulPrecio = $sqlPrecios->fetch();
                                    echo number_format($resulPrecio['precio'], 0, ",", ".") ?> + IVA
                                </p>

                                <ul class="listServicios">
                                    <li><?php echo $row['cantidadCamas'] ?> Cama sencilla o doble</li>
                                    <?php
                                    foreach ($dbh->query($sqlServicios) as $row2) :
                                        if (strtolower($row2['servicio']) != "ventilador") :
                                    ?>
                                            <li><?php echo $row2['servicio'] ?></li>
                                    <?php
                                        endif;
                                    endforeach;
                                    ?>
                                </ul>

                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="listadoHab">
                                <?php

                                $resulFilasHabitaciones = $dbh->query($sqlHabitacion);
                                if ($resulFilasHabitaciones->rowCount() > 0) :
                                    foreach ($resulFilasHabitaciones as $row3) :
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
                                            <a href="formularioReservas.php?idHabitacion=<?php echo $row3['id_habitacion'] ?>&idTipoHab=<?php echo $id ?>&fechasRango=<?php echo $rangoFecha ?>" class="btnSelecHab">Reservar</a>
                                        </div>
                                    <?php

                                    endforeach;
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
                </section>
        <?php
            }
        }
        ?>
    </main>

</body>

</html>