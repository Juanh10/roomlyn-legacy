<?php

include_once "../../procesos/config/conex.php";

$estadoTipo = 1;

$idCliente = $_POST['idCliente'];
$seleccion = $_POST['seleccion'];

$sql = "SELECT reservas.id_reserva, reservas.id_cliente, reservas.id_estado_reserva, reservas.fecha_ingreso, reservas.fecha_salida, reservas.total_reserva, reservas.estado, reservas.fecha_sys, habitaciones.id_habitacion, habitaciones.nHabitacion, habitaciones.cantidadPersonasHab, habitaciones.observacion, habitaciones_tipos.id_hab_tipo, habitaciones_tipos.tipoHabitacion, estado_reservas.nombre_estado FROM reservas INNER JOIN clientes_registrados ON reservas.id_cliente = clientes_registrados.id_cliente_registrado INNER JOIN habitaciones ON habitaciones.id_habitacion = reservas.id_habitacion INNER JOIN habitaciones_tipos ON habitaciones_tipos.id_hab_tipo = habitaciones.id_hab_tipo INNER JOIN estado_reservas ON estado_reservas.id_estado_reserva = reservas.id_estado_reserva WHERE reservas.id_cliente = ".$idCliente." AND reservas.id_estado_reserva = ".$seleccion."";

$sqlImagenes = $dbh->prepare("SELECT nombre, MIN(ruta) AS ruta, estado FROM habitaciones_imagenes WHERE id_hab_tipo = :idTipo AND estado = :estado");

$rowConsulta = $dbh->query($sql);

?>

<span class="btnVolverFiltro">Volver</span>
<?php

if ($rowConsulta->rowCount() > 0) :
?>

    <div class="cotenedorCard">
        <?php
        foreach ($dbh->query($sql) as $row) :

            $idHabitacion = $row['id_habitacion'];
            $idReserva = $row['id_reserva'];
            $idTipo = $row['id_hab_tipo'];
            $checkIn = $row['fecha_ingreso'];
            $checkOut = $row['fecha_salida'];
            $totalReserva = $row['total_reserva'];
            $habitacion = $row['nHabitacion'];
            $tipoHabitacion = $row['tipoHabitacion'];
            $idEstado = $row['id_estado_reserva'];
            $estado = $row['nombre_estado'];
            $fechaRegistro = $row['fecha_sys'];

            $sqlImagenes->bindParam(':idTipo', $idTipo);
            $sqlImagenes->bindParam(':estado', $estadoTipo);

            $sqlImagenes->execute();

            $resulImg = $sqlImagenes->fetch(PDO::FETCH_ASSOC);
        ?>
            <div class="cardReserva">
                <div class="imgHabitacion">
                    <img src="../../imgServidor/<?php echo $resulImg['ruta']; ?>" alt="Foto del tipo de habitación">
                </div>
                <div class="informacionCard">
                    <div class="inforHabitacion">
                        <h2>Habitación <?php echo $habitacion . "|" . $tipoHabitacion; ?></h2>
                        <span>Tipo: 1 simple</span>
                        <span>Capacidad: 1 persona</span>
                        <span>Descripción: Primer piso</span>
                    </div>
                    <div class="inforReserva">
                        <span>Entrada: <?php echo $checkIn ?></span>
                        <span>Salida: <?php echo $checkOut ?></span>
                        <div class="totalReserva">
                            <span>TOTAL: <?php echo number_format($totalReserva, 0, ',', '.') ?> COP</span>
                        </div>
                        <div class="estadoReserva">
                            <span>Estado de la reserva: <?php echo $estado ?></span>
                        </div>
                    </div>
                    <?php
                    if ($idEstado != 4 && $idEstado != 3) :
                    ?>
                        <div class="botonCancelReserva">
                            <form action="../../procesos/registroReservas/conCancelarReserva.php" method="post" class="formCancelarReserva">
                                <input type="hidden" name="idReserva" value="<?php echo $idReserva ?>">
                                <input type="hidden" name="idHabitacion" value="<?php echo $idHabitacion ?>">
                                <input type="submit" class="btnCancel" name="btnCancel" value="Cancelar reserva">
                            </form>
                        </div>
                    <?php
                    endif;
                    ?>
                </div>
            </div>
        <?php
        endforeach;
        ?>
    </div>
<?php
else :
?>
    <p class="msjError">No se encontraron registros.</p>
<?php
endif;

?>

<script src="../../js/scriptConfiguracion.js"></script>