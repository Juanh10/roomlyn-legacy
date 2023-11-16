<?php

session_start();

include_once "../../procesos/config/conex.php";
include "funcionesIconos.php";

$fechaRango = $_GET['fechasRango'];
$huespedes = $_GET['huespedes'];
$sisClimatizacion = $_GET['selectClima'];

$arrayFechas = explode(" - ", $fechaRango); // separar los rangos de fecha segun el caracter "-"

$numeroHuespedes = preg_replace('/\D/', '', $huespedes); // Eliminar todos los caracteres no numericos

$checkin = $arrayFechas[0];

$checkout = $arrayFechas[1];

//Consultas SQL de las habitaciones segun lo que el usuario escogio en el filtro

$sqlHabitaciones = "SELECT id_habitaciones, id_hab_estado, id_hab_tipo, nHabitacion, tipoCama, cantidadPersonasHab, tipoServicio, observacion, estado FROM habitaciones WHERE cantidadPersonasHab = " . $numeroHuespedes . " AND tipoServicio = " . $sisClimatizacion . " AND id_hab_estado = 1 AND estado = 1";

$resultHabitacion = $dbh->query($sqlHabitaciones);

if ($resultHabitacion) {

    // Inicializar un arreglo para almacenar los tipos de habitación
    $arregloTipo = array();

    // Recorrer los resultados de la consulta sobre las habitaciones
    while ($datosHabitacion = $resultHabitacion->fetch(PDO::FETCH_ASSOC)) {

        // Consulta SQL para obtener información sobre los tipos de habitaciones según la habitación seleccionada

        $sqlTipoHabitacion = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, precioVentilador, precioAire, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $datosHabitacion['id_hab_tipo'] . " AND estado = 1 GROUP BY tipoHabitacion";

        $datosTipos = $dbh->query($sqlTipoHabitacion)->fetch();

        // Verificar si el tipo de habitación ya existe en el arreglo
        if (!isset($arregloTipo[$datosTipos['tipoHabitacion']])) {
            // Agregar el tipo de habitación al arreglo
            $arregloTipo[$datosTipos['tipoHabitacion']] = $datosTipos['tipoHabitacion'];
        }

    }
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

    <!--         <header class="cabeceraHab">
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
    </header> -->


</body>


<?php

if ($resultHabitacion->rowCount() > 0) {



    if ($sisClimatizacion == 0) :
?>
        <main>

            <?php

                foreach($arregloTipo as $datosTipo):
                    ?>
                    <h1 class="tituloTipoHab"><?php echo $datosTipo ?></h1>
                        <section class="container seccionHabitaciones">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="informacionList">
    
                                <h2 class="fs-4 mt-4 mb-4 text-center">Habitaciones con ventilador</h2>
    
    
          
    
                            </div>
                        </div>
    
                        <div class="col-md-8">
                            <div class="listadoHab">
                                
                            </div>
                        </div>
                </section>
                    <?php
                endforeach;

            ?>

        </main>
<?php
    endif;
} else {
    $_SESSION['msjError'] = "No se encontraron habitaciones disponibles";
    header("location: ../pagHabitaciones.php");
}
?>

</html>