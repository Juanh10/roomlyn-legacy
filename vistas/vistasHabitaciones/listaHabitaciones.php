<?php

include_once "../../procesos/config/conex.php";

?>

<!DOCTYPE html>
<html lang="en">

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
                                <input type="text" id="buscador" placeholder="Buscar tipo de habitación">
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
        function mostrarDatosHabitaciones($filtro, $id)
        {
        ?>
            <h1 class="tituloTipoHab">Habitaciones tipo <?php echo $id ?></h1>
            <?php
            if ($filtro === "ventilador") {
            ?>
                <section class="container seccionHabitaciones">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="informacionList">
                                <h2 class="fs-4 mt-4 mb-4 text-center">Habitaciones con ventilador</h2>
                                <div class="imgTipo">
                                    <img src="../../img/1camaAire2.webp" alt="" class="img-fluid rounded mx-auto d-block mb-4">
                                </div>
                                <p class="ms-3">Precio por día: 170.000 + IVA</p>
                                <ul class="listServicios">
                                    <li>Ventilador</li>
                                    <li>1 Cama sencilla o doble</liass=>
                                    <li>Televisor</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="listadoHab">
                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>
                            </div>
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
                                    <img src="../../img/1camaAire2.webp" alt="" class="img-fluid rounded mx-auto d-block mb-4">
                                </div>
                                <p class="ms-3">Precio por día: 170.000 + IVA</p>
                                <ul class="listServicios">
                                    <li>Ventilador</li>
                                    <li>1 Cama sencilla o doble</liass=>
                                    <li>Televisor</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="listadoHab">
                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>
                            </div>
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
                                    <img src="../../img/1camaAire2.webp" alt="" class="img-fluid rounded mx-auto d-block mb-4">
                                </div>
                                <p class="ms-3">Precio por día: 170.000 + IVA</p>
                                <ul class="listServicios">
                                    <li>Ventilador</li>
                                    <li>1 Cama sencilla o doble</liass=>
                                    <li>Televisor</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="listadoHab">
                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

                <section class="container seccionHabitaciones">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="informacionList">
                                <h2 class="fs-4 mt-4 mb-4 text-center">Habitaciones con aire acondicionado</h2>
                                <div class="imgTipo">
                                    <img src="../../img/1camaAire2.webp" alt="" class="img-fluid rounded mx-auto d-block mb-4">
                                </div>
                                <p class="ms-3">Precio por día: 170.000 + IVA</p>
                                <ul class="listServicios">
                                    <li>Ventilador</li>
                                    <li>1 Cama sencilla o doble</liass=>
                                    <li>Televisor</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <div class="listadoHab">
                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>

                                <div class="cardHabitaciones">
                                    <div class="inforHabitacion">
                                        <h3>Habitación 1</h3>
                                        <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Recusandae, nam mollitia.</p>
                                    </div>
                                    <a href="#" class="btnSelecHab">Seleccionar</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>
        <?php
            }
        }
        ?>
    </main>


    <script src="../../librerias/jquery-3.7.0.min.js"></script>
    <script src="../../librerias/lightbox2/dist/js/lightbox.js"></script>
    <script src="../../librerias/scrollreveal.js"></script>
    <script src="../../js/scriptHabitaciones.js"></script>
</body>

</html>