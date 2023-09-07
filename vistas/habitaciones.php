<?php

include_once "../procesos/config/conex.php";

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
                    <li id="activoBucador">
                        <div class="buscador">
                            <div class="btnBuscar">
                                <i class="bi bi-search"></i>
                            </div>
                            <div class="inputBuscador">
                                <input type="text" placeholder="Buscar habitación">
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="btnFiltro">
                            <a class="filtro" href="#filtro"><i class="bi bi-funnel"></i></a>
                        </div>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <section class="resHabitaciones">
            <h1>HABITACIONES</h1>

            <div class="contCardHab">

                <div class="cardHab">
                    <div class="imgCard">
                        <img src="../img/1camaAire2.webp" alt="">
                    </div>

                    <div class="contenidoCard">
                        
                        <div class="tituloHab">
                            <h2>Habitacion 1</h2>
                            <a class="btnImgHab" href="../img/1camaAire2.webp" data-lightbox="image-1" title="Ver imagen"><i
                                    class="bi bi-image"></i></a>
                        </div>

                        <div class="infoCard">
                            <p><span>Cantidad: </span>habitacion de 1 cama</p>
                            <ul class="filtrosHab">
                                <li>Ventilador</li>
                                <li>Aire acondicionado</li>
                        </div>

                        <div class="precioInfo">
                            <div class="precios">
                                <div class="precioVent">
                                    <p>Precio por dia con ventilador</p>
                                    <span>COP 70.000 + IVA</span>
                                </div>
                                <div class="precioAire">
                                    <p>Precio por dia con aire acondicionado</p>
                                    <span>COP 70.000 + IVA</span>
                                </div>
                            </div>
                            <div class="btnInfo">
                                <a href="#" class="btnVermas" title="Ver lista de las habitaciones">Ver más</a>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="cardHab">
                    <div class="imgCard">
                        <img src="../img/1camaAire2.webp" alt="">
                    </div>

                    <div class="contenidoCard">
                        
                        <div class="tituloHab">
                            <h2>Habitacion 1</h2>
                            <a class="btnImgHab" href="../img/1camaAire2.webp" data-lightbox="image-1" title="Ver imagen"><i
                                    class="bi bi-image"></i></a>
                        </div>

                        <div class="infoCard">
                            <p><span>Cantidad: </span>habitacion de 1 cama</p>
                            <ul class="filtrosHab">
                                <li>Ventilador</li>
                                <li>Aire acondicionado</li>
                        </div>

                        <div class="precioInfo">
                            <div class="precios">
                                <div class="precioVent">
                                    <p>Precio por dia con ventilador</p>
                                    <span>COP 70.000 + IVA</span>
                                </div>
                                <div class="precioAire">
                                    <p>Precio por dia con aire acondicionado</p>
                                    <span>COP 70.000 + IVA</span>
                                </div>
                            </div>
                            <div class="btnInfo">
                                <a href="#" class="btnVermas" title="Ver lista de las habitaciones">Ver más</a>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>
    </main>

    <!--* LOGO WHATSAPP  -->

    <div class="logoWhat">
        <a href="https://wa.me/573132219883" target="_blank" class="btnWha" title="WhatsApp"><i
                class="bi bi-whatsapp"></i></a>
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
                <a href="#hola">Como funciona PLAHOT</a>
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