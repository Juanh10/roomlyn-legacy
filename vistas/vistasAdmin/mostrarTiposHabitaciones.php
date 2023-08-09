<?php

include "../../procesos/config/conex.php";

$id = $_GET['id'];

$sql = "";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
</head>

<body>

    <section class="contenidoTipoHab">
        <h1 class="nombreTipo">Habitación tipo <?php echo $id?></h1>
        <h2>Información</h2>
        <div class="inforTipHo">
            <p>Cantidad de camas: 1</p>
            <p>Cantidad maxima de huespedes: 2</p>
        </div>
        <div class="precioTipo">
            <p>Costo con ventilador: 28000</p>
            <p>Costo con aire acondicionado: 50000</p>
        </div>

        <h2>Servicios</h2>
        <ul class="serviciosTipo">
            <li>Ventilador</li>
            <li>Baño</li>
            <li>Mesa</li>
            <li>Cafe</li>
            <li>Piscina</li>
        </ul>

        <h2>Fotos</h2>
        <div class="imagenesTipos">
            <div class="listImg">
                <img src="../../img/1camaAire2.webp" alt="">
            </div>
            <div class="listImg">
            <img src="../../img/1camaAire2.webp" alt="">
            </div>
            <div class="listImg">
            <img src="../../img/1camaAire2.webp" alt="">
            </div>

        </div>
    </section>

</body>

</html>