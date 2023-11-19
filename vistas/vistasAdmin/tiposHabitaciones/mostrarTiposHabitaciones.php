<?php

session_start();

include_once "../../../procesos/config/conex.php";

$id = $_GET['id']; // recibimos por medio de fetch el id

$sql = "SELECT tipoHabitacion, cantidadCamas, capacidadPersonas FROM habitaciones_tipos WHERE id_hab_tipo = " . $id . ""; // sql de la tabla habitaciones_tipos

$sqlPrecios = "SELECT htp.id_tipo_servicio, htp.precio, htp.estado, habitaciones_servicios.servicio FROM habitaciones_tipos_precios htp INNER JOIN habitaciones_tipos_servicios hts ON hts.id_tipo_servicio = htp.id_tipo_servicio INNER JOIN habitaciones_servicios ON habitaciones_servicios.id_servicio = hts.id_servicio WHERE hts.id_hab_tipo = " . $id . " AND htp.estado = 1";

$sqlServi = "SELECT habitaciones_tipos_servicios.id_hab_tipo, habitaciones_servicios.servicio, habitaciones_tipos_servicios.estado FROM habitaciones_tipos_servicios INNER JOIN habitaciones_servicios ON habitaciones_tipos_servicios.id_servicio = habitaciones_servicios.id_servicio WHERE habitaciones_tipos_servicios.estado = 1 AND habitaciones_tipos_servicios.id_hab_tipo = " . $id . ""; // sql de los servicios de los tipos de habitaciones

$sqlImg = "SELECT nombre, ruta, estado FROM habitaciones_imagenes WHERE id_hab_tipo = " . $id . ""; // sql de las imagenes de los tipos de habitaciones

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
</head>

<body>

    <section class="contenidoTipoHab">

        <?php

        //! MOSTRAR DATOS DE LA BD DE LA INFORMACION DE LOS TIPOS DE HABITACIONES

        foreach ($dbh->query($sql) as $row) :
        ?>
            <h1 class="nombreTipo"><?php echo $row['tipoHabitacion'] ?></h1>

            <h2>Información</h2>
            <div class="inforTipHo">
                <p>Cantidad de camas: <?php echo $row['cantidadCamas'] ?></p>
                <p>Cantidad maxima de huespedes: <?php echo $row['capacidadPersonas'] ?> </p>
            </div>
            <div class="precioTipo">
                <?php

                foreach ($dbh->query($sqlPrecios) as $rowPrecios) :
                ?>
                    <p>Costo con <?php echo $rowPrecios['servicio'] . ": " . number_format($rowPrecios['precio'], 0, ',', '.') ?></p>

                <?php
                endforeach;
                ?>
            </div>

            <h2>Servicios</h2>
            <ul class="serviciosTipo">
                <?php
                foreach ($dbh->query($sqlServi) as $rowSer) :
                ?>
                    <li><?php echo $rowSer['servicio'] ?></li>
                <?php
                endforeach;
                ?>
            </ul>

            <h2>Fotos</h2>
            <div class="imagenesTipos">
                <?php
                foreach ($dbh->query($sqlImg) as $rowImg) :
                    if ($rowImg['estado'] == 1) :
                ?>
                        <div class="listImg">
                            <img src="../../imgServidor/<?php echo $rowImg['ruta'] ?>" alt="Imagenes de las habitaciones">
                        </div>
                <?php
                    endif;
                endforeach;
                ?>
            </div>
        <?php
        endforeach;
        ?>
    </section>

</body>

</html>