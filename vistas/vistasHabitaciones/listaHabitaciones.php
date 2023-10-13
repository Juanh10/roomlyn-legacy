<?php

include_once "../../procesos/config/conex.php";
include "funcionesIconos.php";
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../iconos/logo_icono.png">
    <link rel="stylesheet" href="../../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../librerias/lightbox2/dist/css/lightbox.css">
    <link rel="stylesheet" href="../../librerias/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/estilosListaHabitaciones.css">
    <link rel="stylesheet" href="../../css/estilosPrincipales.css">
    <title>Habitaciones</title>
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
                <a href="../../index.html"><img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
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
                    <!--  <li>
                        <div class="btnFiltro">
                            <a class="filtro" href="#filtro"><i class="bi bi-funnel"></i></a>
                        </div>
                    </li> -->
                </ul>
            </nav>
        </div>
    </header>

    <main>

        <?php
        function mostrarTituloTipo($id, $dbh)
        {
            $sqlTipoHabitacion = "SELECT id, tipoHabitacion, cantidadCamas, precioVentilador, precioAire, estado FROM habitaciones_tipos WHERE id = " . $id . " AND estado = 1"; // Capturar la informacion del tipo de la habitacion

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

            if ($filtro === "ventilador") {
                $tipoServ = 0;
            } else if ($filtro === "aire") {
                $tipoServ = 1;
            }

            $sqlTipoHabitacion = "SELECT id, tipoHabitacion, cantidadCamas, precioVentilador, precioAire, estado FROM habitaciones_tipos WHERE id = " . $id . " AND estado = 1"; // Capturar la informacion del tipo de la habitacion

            $sqlServicios = "SELECT habitaciones_elementos.elemento FROM habitaciones_tipos_elementos INNER JOIN habitaciones_elementos ON habitaciones_elementos.id = habitaciones_tipos_elementos.id_elemento WHERE id_habitacion_tipo = " . $id . " AND estado = 1"; // Capturar servicios del tipo de la habitacion

            $sqlImagenesTipoHab = "SELECT nombre, ruta, estado FROM habitaciones_imagenes WHERE estado = 1 AND idTipoHabitacion = " . $id . ""; //Capturar la ruta de las imagenes de los tipos de habitaciones

            $sqlHabitacion = "SELECT id_habitaciones, nHabitacion, id_tipo, id_hab_estado, tipoCama, cantidadPersonasHab, tipoServicio, observacion, estado FROM habitaciones WHERE id_tipo = " . $id . " AND tipoServicio = " . $tipoServ . ""; // Capturar toda la informacion de la habitacion


            $row = $dbh->query($sqlTipoHabitacion) -> fetch(); // Obtener datos

            if ($filtro === "ventilador") {
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
                                            foreach ($dbh->query($sqlImagenesTipoHab) as $rowImg) :
                                                $claseActive = $primeraImg ? 'active' : '';
                                            ?>
                                                <div class="carousel-item <?php echo $claseActive ?> coverImg" data-bs-interval="5000">
                                                    <a href="../../imgServidor/<?php echo $rowImg['ruta'] ?>" data-lightbox="fotosHotel">
                                                        <img src="../../imgServidor/<?php echo $rowImg['ruta'] ?>" alt="Fotos de las habitaciones del tipo seleccionado" class="img-fluid rounded mx-auto d-block mb-4">
                                                    </a>
                                                </div>

                                            <?php
                                                $primeraImg = false;
                                            endforeach;
                                            ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>

                                <p class="ms-3 mt-3">Precio por día: <?php echo number_format($row['precioVentilador'], 0, ",", ".") ?> + IVA</p>

                                <ul class="listServicios">
                                    <li><?php echo $row['cantidadCamas'] ?> Cama sencilla o doble</li>
                                    <?php
                                    foreach ($dbh->query($sqlServicios) as $row2) :
                                        if (strtolower($row2['elemento']) != "aire acondicionado") :
                                    ?>
                                            <li><?php echo $row2['elemento'] ?></li>
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
                                foreach ($dbh->query($sqlHabitacion) as $row3) :
                                    $capacidadPerson = $row3['cantidadPersonasHab'];
                                    $tipoCama = $row3['tipoCama'];
                                    if ($row3['estado'] == 1 && $row3['id_hab_estado'] == 1) :
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
                                                <p><?php echo $row3['observacion'] ?></p>
                                            </div>
                                            <a href="#" class="btnSelecHab">Seleccionar</a>
                                        </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                </section>
            <?php
            } else if ($filtro === "aire") {
            ?>
                <section class="container seccionHabitaciones">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="informacionList">

                                <h2 class="fs-4 mt-4 mb-4 text-center">Habitaciones con aire acondicionado</h2>

                                <div class="imgTipo">
                                    <div id="carruselImagenesTipoHab" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php
                                            $primeraImg = true;
                                            foreach ($dbh->query($sqlImagenesTipoHab) as $rowImg) :
                                                $claseActive = $primeraImg ? 'active' : '';
                                            ?>
                                                <div class="carousel-item <?php echo $claseActive ?> coverImg" data-bs-interval="5000">
                                                    <a href="../../imgServidor/<?php echo $rowImg['ruta'] ?>" data-lightbox="fotosHotel">
                                                        <img src="../../imgServidor/<?php echo $rowImg['ruta'] ?>" alt="Fotos de las habitaciones del tipo seleccionado" class="img-fluid rounded mx-auto d-block mb-4">
                                                    </a>
                                                </div>

                                            <?php
                                                $primeraImg = false;
                                            endforeach;
                                            ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>

                                <p class="ms-3 mt-3">Precio por día: <?php echo number_format($row['precioAire'], 0, ",", ".") ?> + IVA</p>

                                <ul class="listServicios">
                                    <li><?php echo $row['cantidadCamas'] ?> Cama sencilla o doble</li>
                                    <?php
                                    foreach ($dbh->query($sqlServicios) as $row2) :
                                        if (strtolower($row2['elemento']) != "ventilador") :
                                    ?>
                                            <li><?php echo $row2['elemento'] ?></li>
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
                                foreach ($dbh->query($sqlHabitacion) as $row3) :
                                    $capacidadPerson = $row3['cantidadPersonasHab'];
                                    $tipoCama = $row3['tipoCama'];
                                    if ($row3['estado'] == 1 && $row3['id_hab_estado'] == 1) :
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
                                                <p><?php echo $row3['observacion'] ?></p>
                                            </div>
                                            <a href="#" class="btnSelecHab">Seleccionar</a>
                                        </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                </section>
            <?php
            } else {
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
                                            foreach ($dbh->query($sqlImagenesTipoHab) as $rowImg) :
                                                $claseActive = $primeraImg ? 'active' : '';
                                            ?>
                                                <div class="carousel-item <?php echo $claseActive ?> coverImg" data-bs-interval="5000">
                                                    <a href="../../imgServidor/<?php echo $rowImg['ruta'] ?>" data-lightbox="fotosHotel">
                                                        <img src="../../imgServidor/<?php echo $rowImg['ruta'] ?>" alt="Fotos de las habitaciones del tipo seleccionado" class="img-fluid rounded mx-auto d-block mb-4">
                                                    </a>
                                                </div>

                                            <?php
                                                $primeraImg = false;
                                            endforeach;
                                            ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>

                                <p class="ms-3 mt-3">Precio por día: <?php echo number_format($row['precioVentilador'], 0, ",", ".") ?> + IVA</p>

                                <ul class="listServicios">
                                    <li><?php echo $row['cantidadCamas'] ?> Cama sencilla o doble</li>
                                    <?php
                                    foreach ($dbh->query($sqlServicios) as $row2) :
                                        if (strtolower($row2['elemento']) != "aire acondicionado") :
                                    ?>
                                            <li><?php echo $row2['elemento'] ?></li>
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
                                foreach ($dbh->query($sqlHabitacion) as $row3) :
                                    $capacidadPerson = $row3['cantidadPersonasHab'];
                                    $tipoCama = $row3['tipoCama'];
                                    if ($row3['estado'] == 1 && $row3['id_hab_estado'] == 1) :
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
                                                <p><?php echo $row3['observacion'] ?></p>
                                            </div>
                                            <a href="#" class="btnSelecHab">Seleccionar</a>
                                        </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                </section>

                <section class="container seccionHabitaciones">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="informacionList">

                                <h2 class="fs-4 mt-4 mb-4 text-center">Habitaciones con aire acondicionado</h2>

                                <div class="imgTipo">
                                    <div id="carruselImagenesTipoHab" class="carousel slide" data-bs-ride="carousel">
                                        <div class="carousel-inner">
                                            <?php
                                            $primeraImg = true;
                                            foreach ($dbh->query($sqlImagenesTipoHab) as $rowImg) :
                                                $claseActive = $primeraImg ? 'active' : '';
                                            ?>
                                                <div class="carousel-item <?php echo $claseActive ?> coverImg" data-bs-interval="5000">
                                                    <a href="../../imgServidor/<?php echo $rowImg['ruta'] ?>" data-lightbox="fotosHotel">
                                                        <img src="../../imgServidor/<?php echo $rowImg['ruta'] ?>" alt="Fotos de las habitaciones del tipo seleccionado" class="img-fluid rounded mx-auto d-block mb-4">
                                                    </a>
                                                </div>

                                            <?php
                                                $primeraImg = false;
                                            endforeach;
                                            ?>
                                        </div>
                                        <button class="carousel-control-prev" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Previous</span>
                                        </button>
                                        <button class="carousel-control-next" type="button" data-bs-target="#carruselImagenesTipoHab" data-bs-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="visually-hidden">Next</span>
                                        </button>
                                    </div>
                                </div>

                                <p class="ms-3 mt-3">Precio por día: <?php echo number_format($row['precioAire'], 0, ",", ".") ?> + IVA</p>

                                <ul class="listServicios">
                                    <li><?php echo $row['cantidadCamas'] ?> Cama sencilla o doble</li>
                                    <?php
                                    foreach ($dbh->query($sqlServicios) as $row2) :
                                        if (strtolower($row2['elemento']) != "ventilador") :
                                    ?>
                                            <li><?php echo $row2['elemento'] ?></li>
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
                                foreach ($dbh->query($sqlHabitacion) as $row3) :
                                    $capacidadPerson = $row3['cantidadPersonasHab'];
                                    $tipoCama = $row3['tipoCama'];
                                    if ($row3['estado'] == 1 && $row3['id_hab_estado'] == 1) :
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
                                                <p><?php echo $row3['observacion'] ?></p>
                                            </div>
                                            <a href="#" class="btnSelecHab">Seleccionar</a>
                                        </div>
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        </div>
                </section>

        <?php
            }
        }
        ?>
    </main>


    <script src="../../librerias/jquery-3.7.0.min.js"></script>
    <script src="../../librerias/bootstrap5/js/bootstrap.min.js"></script>
    <script src="../../librerias/lightbox2/dist/js/lightbox.js"></script>
    <script src="../../librerias/scrollreveal.js"></script>
    <script src="../../js/scriptHabitaciones.js"></script>
</body>

</html>