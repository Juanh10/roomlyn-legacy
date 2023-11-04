<?php

session_start();

include_once "../procesos/config/conex.php";
include "vistasHabitaciones/funcionesIconos.php";

$sqlTiposHab = "SELECT habitaciones_tipos.id_hab_tipo, habitaciones_tipos.tipoHabitacion, habitaciones_tipos.cantidadCamas, habitaciones_tipos.capacidadPersonas, habitaciones_tipos.precioVentilador, habitaciones_tipos.precioAire, habitaciones_tipos.estado, habitaciones_imagenes.ruta FROM habitaciones_tipos INNER JOIN habitaciones_imagenes ON habitaciones_imagenes.id_hab_tipo = habitaciones_tipos.id_hab_tipo WHERE 1 GROUP BY habitaciones_imagenes.id_hab_tipo";



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
    <link rel="stylesheet" href="../librerias/datarangepicker/css/daterangepicker.css">
    <link rel="stylesheet" href="../css/estilosPrincipales.css">
    <link rel="stylesheet" href="../css/estilosPaginaHabitaciones.css">
    <link rel="stylesheet" href="../librerias/sweetAlert2/css/sweetalert2.min.css">
    <script src="../librerias/sweetAlert2/js/sweetalert2.all.min.js"></script>
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

            <div class="filtros-habitaciones">
                <div class="filtros-fecha-huespedes">
                    <form action="vistasHabitaciones/listaHabitacionesFiltro.php" method="get">
                        <div class="fechas">
                            <div class="grupo-rango-fechas">
                                <input type="text" name="fechasRango" id="rangoFechas" readonly>
                                <label for="rangoFechas" class="label-fechas">Seleccionar fechas</label>
                            </div>
                        </div>
                        <div class="huespedes">
                            <div class="grupo-huespedes">
                                <label for="inputHuespedes" class="label-huespedes">Seleccionar cantidad de huéspedes</label>
                                <input type="text" name="huespedes" id="inputHuespedes" value="1 huésped" readonly>
                            </div>
                            <div class="modalHuespedes">
                                <div class="infor-modal-huespedes">
                                    <div class="filtro-huespedes">
                                        <span>Habitación 1</span>
                                        <div class="grupo-cantidad-huespedes">
                                            <label for="inputCantHuespedes" class="cant-huespedes">Huéspedes</label>
                                            <input type="number" name="cantHuespedes" id="inputCantHuespedes" min="0" max="6" value="1">
                                        </div>
                                    </div>
                                    <div class="btn-añadir-guardar">
                                        <span class="btn-cancelar-habitacion">Cancelar</span>
                                        <span class="btn-aplicar-cambios">Aplicar</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tipo-climatizacion">
                            <div class="grupo-climatizacion">
                                <label for="selectClima" class="label-huespedes">Seleccionar el sistema de climatización</label>

                                <select name="selectClima" id="selectClima">
                                    <option value="0">Ventilador</option>
                                    <option value="1">Aire acondicionado</option>
                                </select>

                            </div>
                        </div>

                        <div class="botones-filtro">
                            <input type="submit" value="Buscar" class="btn-buscar-filtro">
                        </div>
                    </form>
                </div>
            </div>

            <div class="contCardHab">

                <?php

                foreach ($dbh->query($sqlTiposHab) as $row) :
                    $cantCama = $row['cantidadCamas'];
                    $capacidadPerson = $row['capacidadPersonas'];
                    if ($row['estado'] == 1) :
                ?>
                        <div class="cardHab">
                            <div class="imgCard">
                                <img src="../imgServidor/<?php echo $row['ruta'] ?>" alt="Imagen del tipo de habitación">
                            </div>

                            <div class="contenidoCard">

                                <div class="tituloHab">
                                    <h2><?php echo $row['tipoHabitacion'] ?></h2>
                                    <a class="btnImgHab" href="../imgServidor/<?php echo $row['ruta'] ?>" data-lightbox="image-<?php echo $row['id_hab_tipo'] ?>" title="Ver imagen"><i class="bi bi-image"></i></a>
                                </div>

                                <div class="infoCard">
                                    <p><span>Cantidad de camas: </span><?php echo $cantCama; ?></p>
                                    <p><span>Capacidad máxima: </span><?php iconCapacidad($capacidadPerson); ?></pass=>
                                    <form action="vistasHabitaciones/mostrarListaHabitaciones.php" method="get">
                                        <input type="hidden" value="<?php echo $row['id_hab_tipo'] ?>" name="idTipoHab">
                                        <p class="selFiltro">Seleccione: </p>
                                        <ul class="filtrosHab">
                                            <li>
                                                <input type="checkbox" name="opServicios[]" value="ventilador" id="checkVentilador<?php echo $row['id_hab_tipo'] ?>" class="check">
                                                <label for="checkVentilador<?php echo $row['id_hab_tipo'] ?>">Ventilador</label>
                                            </li>
                                            <li>
                                                <input type="checkbox" name="opServicios[]" value="aire" id="checkAire<?php echo $row['id_hab_tipo'] ?>" class="check">
                                                <label for="checkAire<?php echo $row['id_hab_tipo'] ?>">Aire acondicionado</label>
                                            </li>
                                        </ul>
                                        <div class="btnInfo">
                                            <button type="submit" class="btnVermas" title="Ver lista de las habitaciones"> Ver más </button>
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

    <!-- ALERTAS -->

    <?php
    if (isset($_SESSION['msjError'])) {
    ?>

        <script>
            Swal.fire('<?php echo $_SESSION['msjError']; ?>')
        </script>

    <?php
        unset($_SESSION['msjError']);
    }

    ?>

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
                <div class="redes-sociales">
                    <ul>
                        <li><a href="https://www.facebook.com/profile.php?id=61550262616792" class="face" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/hotelcolonialci2/" class="insta" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com/@colonialespinal2023" class="what" target="_blank" title="Whatsapp"><i class="bi bi-whatsapp"></i></a></li>
                        <li><a href="https://www.tiktok.com/@colonialespinal2023" class="tiktok" target="_blank" title="Tik tok"><i class="bi bi-tiktok"></i></a></li>
                    </ul>
                </div>
                <a href="../comoFunciona.html">Como funciona ROOMLYN</a>
                <a href="#">Politicas de privacidad</a>
            </div>
        </div>
    </footer>

    <script src="../librerias/jquery-3.7.0.min.js"></script>
    <script src="../librerias/lightbox2/dist/js/lightbox.js"></script>
    <script src="../librerias/scrollreveal.js"></script>
    <script src="../librerias/datarangepicker/js/moment.min.js"></script>
    <script src="../librerias/datarangepicker/js/daterangepicker.js"></script>
    <script src="../js/scriptHabitaciones.js"></script>
    


</body>

</html>