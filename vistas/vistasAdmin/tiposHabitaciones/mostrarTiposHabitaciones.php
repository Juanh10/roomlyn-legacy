<?php

session_start();

include_once "../../../procesos/config/conex.php";

$id = $_GET['id']; // recibimos por medio de fetch el id

$sql = "SELECT tipoHabitacion, cantidadCamas, capacidadPersonas, precioVentilador, precioAire FROM habitaciones_tipos WHERE id_hab_tipo = " . $id . ""; // sql de la tabla habitaciones_tipos

$sqlServi = "SELECT habitaciones_tipos_elementos.id_hab_tipo, habitaciones_elementos.elemento, habitaciones_tipos_elementos.estado FROM habitaciones_tipos_elementos INNER JOIN habitaciones_elementos ON habitaciones_tipos_elementos.id_hab_elemento = habitaciones_elementos.id_hab_elemento WHERE habitaciones_tipos_elementos.id_hab_tipo = " . $id . ""; // sql de los servicios de los tipos de habitaciones

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
                <p>Costo con ventilador: <?php echo number_format($row['precioVentilador'], 0, ',', '.') // formatear el numero para que aparezca con los puntos de miles 
                                            ?></p>
                <p>Costo con aire acondicionado: <?php echo number_format($row['precioAire'], 0, ',', '.') ?></p>
            </div>

            <h2>Servicios</h2>
            <ul class="serviciosTipo">
                <?php
                foreach ($dbh->query($sqlServi) as $rowSer) :
                    if($rowSer['estado'] === 1):
                ?>
                    <li><?php echo $rowSer['elemento'] ?></li>
                <?php
                endif;
                endforeach;
                ?>
            </ul>

            <h2>Fotos</h2>
            <div class="imagenesTipos">
                <?php
                foreach ($dbh->query($sqlImg) as $rowImg) :
                    if($rowImg['estado'] == 1):
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