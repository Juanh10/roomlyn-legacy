<?php

include_once "../procesos/config/conex.php";
include "vistasHabitaciones/funcionesIconos.php";

$sqlTiposHab = "SELECT habitaciones_tipos.id, habitaciones_tipos.tipoHabitacion, habitaciones_tipos.cantidadCamas, habitaciones_tipos.capacidadPersonas, habitaciones_tipos.precioVentilador, habitaciones_tipos.precioAire, habitaciones_tipos.estado, habitaciones_imagenes.ruta FROM habitaciones_tipos INNER JOIN habitaciones_imagenes ON habitaciones_imagenes.idTipoHabitacion = habitaciones_tipos.id WHERE 1 GROUP BY habitaciones_imagenes.idTipoHabitacion";



?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../iconos/logo_icono.png">
    <link rel="stylesheet" href="../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../librerias/lightbox2/dist/css/lightbox.css">
    <link rel="stylesheet" href="../css/estilosPrincipales.css">
    <link rel="stylesheet" href="../css/estilosPaginaHabitaciones.css">
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
                <a href="../index.html"><img src="../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
            </div>
            <nav class="navegacionHab">
                <ul>
                    <!-- <li id="activoBucador">
                        <div class="buscador">
                            <div class="btnBuscar">
                                <i class="bi bi-search"></i>
                            </div>
                            <div class="inputBuscador">
                                <label for="buscador" class="buscadorHidden">Buscar</label>
                                <input type="text" id="buscador" placeholder="Buscar tipo de habitación">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="btnFiltro">
                            <a class="filtro" href="#filtro"><i class="bi bi-funnel"></i></a>
                        </div>
                    </li> -->
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="resHabitaciones">
            <h1>HABITACIONES</h1>

            <div class="contCardHab">

                <?php

                foreach ($dbh->query($sqlTiposHab) as $row) :
                    $cantCama = $row['cantidadCamas'];
                    $capacidadPerson = $row['capacidadPersonas'];
                    if ($row['estado'] === 1) :
                ?>
                        <div class="cardHab">
                            <div class="imgCard">
                                <img src="../imgServidor/<?php echo $row['ruta'] ?>" alt="Imagen del tipo de habitación">
                            </div>

                            <div class="contenidoCard">

                                <div class="tituloHab">
                                    <h2><?php echo $row['tipoHabitacion'] ?></h2>
                                    <a class="btnImgHab" href="../imgServidor/<?php echo $row['ruta'] ?>" data-lightbox="image-<?php echo $row['id'] ?>" title="Ver imagen"><i class="bi bi-image"></i></a>
                                </div>

                                <div class="infoCard">
                                    <p><span>Cantidad de camas: </span><?php echo $cantCama; ?></p>
                                    <p><span>Capacidad máxima: </span><?php iconCapacidad($capacidadPerson); ?></pass=>
                                    <form action="vistasHabitaciones/mostrarListaHabitaciones.php" method="post">
                                        <input type="hidden" value="<?php echo $row['id'] ?>" name="idTipoHab">
                                        <p class="selFiltro">Seleccione: </p>
                                        <ul class="filtrosHab">
                                            <li>
                                                <input type="checkbox" name="opServicios[]" value="ventilador" id="checkVentilador<?php echo $row['id'] ?>" class="check">
                                                <label for="checkVentilador<?php echo $row['id'] ?>">Ventilador</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="opServicios[]" value="aire" id="checkAire<?php echo $row['id'] ?>" class="check">
                                                <label for="checkAire<?php echo $row['id'] ?>">Aire acondicionado</label>
                                            </li>
                                        </ul>
                                        <div class="btnInfo">
                                            <button type="submit" class="btnVermas" title="Ver lista de las habitaciones" name="btnVerInfor"> Ver más </button>
                                        </div>
                                    </form>
                                </div>


                                <div class="precios">
                                    <div class="precioVent">
                                        <p>Precio por dia con ventilador</p>
                                        <span>COP <?php echo number_format($row['precioVentilador'], 0, ',', '.') ?> + IVA</span>
                                    </div>
                                    <div class="precioAire">
                                        <p>Precio por dia con aire acondicionado</p>
                                        <span>COP <?php echo number_format($row['precioAire'], 0, ',', '.') ?> + IVA</span>
                                    </div>
                                </div>

                            </div>

                        </div>

                <?php
                    endif;
                endforeach;

                ?>

            </div>
        </section>
    </main>

    <!--* LOGO WHATSAPP  -->

    <div class="logoWhat">
        <a href="https://wa.me/573132219883" target="_blank" class="btnWha" title="WhatsApp"><i class="bi bi-whatsapp"></i></a>
    </div>

    <!--* PIE DE PAGINA -->

    <footer>
        <div class="piePagina">
            <div class="copyPiePagina">
                <div class="logoPiePagina">
                    <img src="../iconos/logoPlahot2.png" alt="Logo de la plataforma web">
                </div>
                <p>Copyright 2023 PLAHOT | Todos los derechos reservados</p>
            </div>
            <div class="contenidoPiePagina">
                <a href="https://wa.link/3qaw9d">Contacto</a>
                <a href="#hola">Como funciona ROOMLYN</a>
                <a href="#">Politicas de privacidad</a>
            </div>
        </div>
    </footer>


    <script src="../librerias/jquery-3.7.0.min.js"></script>
    <script src="../librerias/lightbox2/dist/js/lightbox.js"></script>
    <script src="../librerias/scrollreveal.js"></script>
    <script src="../js/scriptHabitaciones.js"></script>


</body>

</html>