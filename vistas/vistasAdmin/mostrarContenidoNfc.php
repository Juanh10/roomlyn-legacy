<?php

include_once "../../procesos/config/conex.php";
include_once "../../procesos/funciones/formatearFechas.php";
include_once "../../procesos/funciones/convertirFechasDias.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $codigo = $_GET['codigo'];
    $sqlHabitaciones = $dbh->prepare("SELECT hb.id_habitacion, hb.id_hab_tipo, hb.id_hab_estado, hbs.id_servicio, hb.nHabitacion, hb.tipoCama, hb.cantidadPersonasHab, hb.estado, hbt.tipoHabitacion, hbe.estado_habitacion, hbs.servicio FROM habitaciones AS hb INNER JOIN habitaciones_tipos AS hbt ON hbt.id_hab_tipo = hb.id_hab_tipo INNER JOIN habitaciones_estado AS hbe ON hbe.id_hab_estado = hb.id_hab_estado INNER JOIN habitaciones_servicios hbs ON hbs.id_servicio = hb.id_servicio INNER JOIN llaveros_nfc AS ll ON hb.id_codigo_nfc = ll.id_codigo_nfc WHERE hb.estado = 1 AND ll.codigo = :codigo ORDER BY hb.nHabitacion ASC");
    $sqlHabitaciones->bindParam(':codigo', $codigo);
    $sqlHabitaciones->execute();
    $resultado = $sqlHabitaciones->fetch(\PDO::FETCH_ASSOC);

    $idHab = $resultado['id_habitacion'];
    $idEstadoHab = $resultado['id_hab_estado'];
    $tipoHab = $resultado['id_hab_tipo'];
    $servHabitacion = $resultado['id_servicio'];

    if ($idEstadoHab == 4 || $idEstadoHab == 5 || $idEstadoHab == 6) {

        $sqlReserva = $dbh->prepare("SELECT res.id_reserva, res.id_cliente, res.id_habitacion, res.id_estado_reserva, res.fecha_ingreso, res.fecha_salida, res.total_reserva, res.estado, info.nombres, info.apellidos, info.documento, info.celular, info.email FROM reservas AS res INNER JOIN info_clientes AS info ON info.id_info_cliente = res.id_cliente WHERE res.id_habitacion = :idHab AND res.id_estado_reserva != 4 AND res.id_estado_reserva != 3");
        $sqlReserva->bindParam(':idHab', $idHab);
        $sqlReserva->execute();
        $resultadoReserva = $sqlReserva->fetch(\PDO::FETCH_ASSOC);

        $checkin = $resultadoReserva['fecha_ingreso'];
        $checkout = $resultadoReserva['fecha_salida'];

        $diferenciaDias = convertirDias($checkin, $checkout);

        $sqlPrecioHab = $dbh->prepare("SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON hts.id_tipo_servicio = htp.id_tipo_servicio WHERE hts.id_hab_tipo = :tipoHab AND hts.id_servicio = :servicioHab AND htp.estado = 1 AND hts.estado = 1");
        $sqlPrecioHab->bindParam(':tipoHab', $tipoHab);
        $sqlPrecioHab->bindParam(':servicioHab', $servHabitacion);
        $sqlPrecioHab->execute();
        $resultadoPrecioHab = $sqlPrecioHab->fetch(\PDO::FETCH_ASSOC);

        $precioHabitacion = $resultadoPrecioHab['precio'];

        $facturaReserva = facturaReserva($precioHabitacion, $diferenciaDias);

        $sqlResHab = $dbh->prepare("SELECT res.id_reserva, res.id_cliente, res.id_habitacion, res.id_estado_reserva, res.fecha_ingreso, res.fecha_salida, res.total_reserva, res.estado, info.nombres, info.apellidos, info.documento, info.celular FROM reservas AS res INNER JOIN info_clientes AS info ON info.id_info_cliente = res.id_cliente WHERE res.id_habitacion = :idHab AND res.id_estado_reserva = :idEstadoRes");

        switch ($idEstadoHab) {
            case 4:
                $idEstadoHabitacion = 2;
                $sqlResHab->bindParam(':idHab', $idHab);
                $sqlResHab->bindParam(':idEstadoRes', $idEstadoHabitacion);
                break;

            case 5:
                $idEstadoHabitacion = 1;
                $sqlResHab->bindParam(':idHab', $idHab);
                $sqlResHab->bindParam(':idEstadoRes', $idEstadoHabitacion);
                break;

            case 6:
                $idEstadoHabitacion = 2;
                $sqlResHab->bindParam(':idHab', $idHab);
                $sqlResHab->bindParam(':idEstadoRes', $idEstadoHabitacion);
                break;

            default:
                echo "Pcurrió un error";
                break;
        }

        $sqlResHab->execute();
        $resultadoResHab = $sqlResHab->fetch(\PDO::FETCH_ASSOC);

        $idRes = $resultadoResHab['id_reserva'];
    }
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <title>Document</title>
</head>

<body>

    <div class="btnVolverFiltro ms-5">
        <span>
            < Volver
                </span>
    </div>

    <?php
    if ($idEstadoHab == 4 || $idEstadoHab == 5 || $idEstadoHab == 6):
        include "cardsNfc/cardNfcCliente.php";

    else:
    ?>
        <div id="contenidoHab" data-label="<?php echo $idHab ?>"></div>
    <?php
    endif;
    ?>


    <!-- MODAL DISPONIBLE -->
    <div class="modal fade" id="modalDisponible" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Disponible</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="btnOpciones">
                        <button id="cambiarEstadoDispo" data-bs-toggle="modal" data-bs-target="#modalEstadoDispo">Cambiar estado de la habitación</button>
                        <button id="btnReservarRecepcion">Reservar habitación</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ESTADO -->
    <div class="modal fade" id="modalEstado" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Cambiar estado</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contentCamEstadoDi"></div>
            </div>
        </div>
    </div>


    <script src="../../js/scriptCardNfc.js"></script>

    <script>
        $('.btnVolverFiltro').click(function() {
            location.reload();
        });
    </script>

</body>


</html>