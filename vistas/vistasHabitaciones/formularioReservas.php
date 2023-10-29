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

        <main class="container">
            <div class="row rowPrincipal">
                <div class="col-8 col-informacion">
                    <div class="card-infor-reserva">
                        <div class="row">
                            <div class="col-4">
                                <div class="imagenes">
                                    <img src="../../imgServidor/1camaAire2.jpg" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="informacion">
                                    <div class="habitacion">
                                        <h1>Habitación 1 | Habitaciones individuales</h1>
                                    </div>
                                    <div class="servicios">
                                        <p>
                                            <span>Tipo de cama:</span> 1 simple
                                        </p>
                                        <p>
                                            <span>Capacidad:</span> 1 persona
                                        </p>
                                    </div>
                                    <div class="descripcion">
                                        <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Magnam neque</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="formularioReserva">
                        <form action="">
                            <h1>HOLA</h1>
                            Lorem ipsum dolor, sit amet consectetur adipisicing elit. Commodi, animi! Neque praesentium rerum odit ex eveniet voluptatibus, odio debitis! Quibusdam, minus. Voluptate impedit consectetur qui illum alias iure nihil dolorem!
                            Eveniet cumque aliquid dolorum laborum excepturi quidem repudiandae consectetur impedit rerum labore eius explicabo odio, provident sit nesciunt. Perspiciatis laborum harum ea illum quaerat dolore qui ipsa nemo aperiam minus?
                            Porro reprehenderit repudiandae harum, ullam eaque necessitatibus illum placeat explicabo veniam enim at cum animi commodi provident perspiciatis dolorum adipisci saepe libero ratione! Alias ut, aperiam minus saepe officia molestiae.
                            Nisi a, ducimus beatae quisquam quod autem enim maxime quos, tempore ut distinctio possimus ipsum dolores libero odit ad aperiam quam fuga atque totam! Molestiae cumque est expedita! Fuga, voluptatibus.
                            Ipsa, perferendis veniam eum temporibus aperiam tenetur cum quis velit debitis ullam maiores distinctio? Ipsam perspiciatis ipsa dolorum veritatis alias, totam blanditiis minus impedit facere commodi tenetur architecto. Veritatis, impedit?Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam, blanditiis ab. Minus beatae ducimus odit quia explicabo unde, eveniet delectus magni tenetur fugit eaque, at temporibus fuga eius. Minus, quam.
                            Veritatis quae repellendus architecto quod. Quos sunt ipsum culpa repudiandae dolorum ipsam voluptatibus modi ipsa tempora aperiam? Error sapiente officia iusto reiciendis ab necessitatibus numquam repudiandae, facilis vero omnis maiores.
                            Fugit adipisci, illum sunt voluptas a praesentium incidunt excepturi pariatur quibusdam sapiente quis nobis cupiditate sit voluptatum id nihil? Itaque magnam, corporis natus neque ipsum commodi deserunt officiis molestiae quas?
                            Cumque vitae amet a dolore voluptatibus non! Necessitatibus quos magnam nostrum velit qui libero optio fugit id, veniam dolore quia maiores unde dolorum vero culpa hic consequatur molestiae ipsam aliquid.
                            Rerum, dolorem minus! Cumque numquam vel id aperiam assumenda amet excepturi eveniet, corrupti, deserunt voluptas quam odio eos ad ipsa magni facilis, atque praesentium. Reiciendis itaque unde non placeat temporibus.
                        </form>
                    </div>
                </div>
                <div class="col col-factura">
                    <div class="facturaReserva">
                        <div class="totalReserva">
                            <span class="precioTotal">202.000 COP</span>
                            <div class="fechaHospedaje">
                                <p>10/10/2023 - 10/10/2023</p>
                                <p>1 día</p>
                            </div>
                        </div>
                        <div class="detallesFactura">
                            <div class="btnAbrirDetalles">
                                <span class="btnAbrirDet">Detalles de la estancia <i class="bi bi-caret-down-fill flechaDetalles"></i></span>
                            </div>
                            <div class="inforDetalles">
                                <div class="fechasCheck">
                                    <p>Entrada: 29/10/2023</p>
                                    <p>Salida: 30/10/2023</p>
                                </div>
                                <div class="inforHab">
                                    <p>
                                        <span>Habitación 1 | 1 día</span>
                                        <span>170.000</span>
                                    </p>
                                    <p>
                                        <span>IVA </span>
                                        <span>32.000</span>
                                    </p>
                                </div>
                                <div class="totalFactura">
                                    <p>
                                        <span>TOTAL </span>
                                        <span>202.000</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

    <?php
    endif;

    ?>


</body>

</html>