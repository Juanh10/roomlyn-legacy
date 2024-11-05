<!DOCTYPE html>
<html lang="es">

<body>
    <div class="seccion-factura">
        <div class="contenedor-card-nfc">
            <div class="card-nfc">
                <div class="card-nfc-informacion">
                    <div class="card-nfc-numhab">
                        <span><strong><?php echo $resultado['nHabitacion'] ?></strong></span>
                        <span class="card-nfc-icon"><i class="bi bi-cart4"></i></span>
                    </div>
                    <div class="card-nfc-datpers"> <!-- DATOS PERSONALES -->
                        <span><strong><?php echo $resultadoReserva['documento'] ?></strong></span>
                        <span><strong><?php echo $resultadoReserva['nombres'] . " " . $resultadoReserva['apellidos'] ?></strong></span>
                        <div class="card-nfc-factura">
                            <span>Habitación</span> <span><?php echo number_format($precioHabitacion, 0, ',', '.') ?></span>
                            <span>IVA</span> <span><?php echo number_format($facturaReserva['iva'], 0, ',', '.') ?></span>
                            <span>Consumo(P)</span> <span><?php echo number_format($facturaReserva['iva'], 0, ',', '.') ?></span>
                            <span><strong>TOTAL</strong></span> <span><strong><?php echo number_format($resultadoReserva['total_reserva'], 0, ',', '.') ?> COP</strong></span>
                        </div>
                        <div class="card-nfc-fechas">
                            <span class="card-nfc-factura-estancia"><strong>Estancia: </strong><?php echo $diferenciaDias . ' ' . ($diferenciaDias > 1 ? "días" : "día"); ?></span>
                            <span><strong>Entrada: </strong><?php echo formatearFecha($resultadoReserva['fecha_ingreso']) ?></span>
                            <span><strong>Salida: </strong><?php echo formatearFecha($resultadoReserva['fecha_salida']) ?></span>
                        </div>
                    </div>
                    <div class="card-nfc-boton">
                        <?php
                        switch ($idEstadoHab) {
                            case 4:
                        ?>
                                <form action="../../procesos/registroReservas/conCheck.php" method="post" class="mx-2" id="formsalRes">
                                    <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                                    <input type="hidden" name="idRes" value="<?php echo $idRes ?>">
                                    <input type="hidden" name="checkOut" value="checkOut">
                                    <input type="submit" class="btn boton-guardar" name="checkOut" value="Registrar Salida">
                                </form>
                            <?php
                                break;

                            case 5:
                            ?>
                                <div class="card-nfc-btn-grupo">
                                    <form action="../../procesos/registroReservas/conCancelarResAdmin.php" method="post" class="mx-2" id="formCancelarRes">
                                        <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                                        <input type="hidden" name="idRes" value="<?php echo $idRes ?>">
                                        <input type="hidden" name="cancelReserva" value="cancelReserva">
                                        <input type="submit" class="btn btn-danger" name="cancelReserva" value="Cancelar">
                                    </form>
                                    <form action="../../procesos/registroReservas/conCancelarResAdmin.php" method="post" class="mx-2" id="formConfirmRes">
                                        <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                                        <input type="hidden" name="idRes" value="<?php echo $idRes ?>">
                                        <input type="hidden" name="confirmReserva" value="confirmReserva">
                                        <input type="submit" class="btn btn-success" name="confirmReserva" value="Confirmar">
                                    </form>
                                </div>
                            <?php
                                break;

                            case 6:
                            ?>
                                <div>
                                    <form action="../../procesos/registroReservas/conCheck.php" method="post" class="mx-2" id="formCancelarRes">
                                        <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                                        <input type="hidden" name="idRes" value="<?php echo $idRes ?>">
                                        <input type="hidden" name="checkIn" value="checkIn">
                                        <input type="submit" class="btn boton-guardar" name="checkIn" value="Registrar Llegada">
                                    </form>
                                </div>
                        <?php
                                break;

                            default:
                                echo "Estado invalido" . $idEstadoHab;
                                break;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="seccion-infor-general">
            <div>
                <h2 class="seccion-titulo">Información del Cliente</h2>
                <div class="informacion-cliente">
                    <span data-label="Nombre"><?php echo $resultadoReserva['nombres'] . " " . $resultadoReserva['apellidos'] ?></span>
                    <span data-label="Documento"><?php echo $resultadoReserva['documento'] ?></span>
                    <span data-label="Número"><?php echo $resultadoReserva['celular'] ?></span>
                    <span data-label="Email"><?php echo $resultadoReserva['email'] ?></span>
                </div>
            </div>
            <div>
                <h2 class="seccion-titulo">Información de la Habitación</h2>
                <div class="informacion-habitacion">
                    <span data-label="Tipo Habitación"><?php echo $resultado['tipoHabitacion'] ?></span>
                    <span data-label="Número habitación"><?php echo $resultado['nHabitacion'] ?></span>
                    <span data-label="Sistema de climatización"><?php echo $resultado['servicio'] ?></span>
                    <span data-label="Cantidad de camas"><?php echo $resultado['tipoCama'] ?></span>
                    <span data-label="Estado Habitación"><?php echo $resultado['estado_habitacion'] ?></span>
                </div>
            </div>

            <?php
            if ($idEstadoHab == 4):
            ?>
                <div>
                    <h2 class="seccion-titulo">Información del Consumo</h2>
                    <table class="tabla-consumo">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Coca Cola</td>
                                <td>2</td>
                                <td>$10,000</td>
                                <td>$20,000</td>
                            </tr>
                            <tr>
                                <td>Papas Fritas</td>
                                <td>3</td>
                                <td>$5,000</td>
                                <td>$15,000</td>
                            </tr>
                            <tr>
                                <td>Café Premium</td>
                                <td>5</td>
                                <td>$5,000</td>
                                <td>$25,000</td>
                            </tr>
                            <tr class="fila-total">
                                <td colspan="3">Total</td>
                                <td>$60,000</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            endif;

            ?>



        </div>

        <script src="../../js/scriptAltertasConfirmacionNfc.js"></script>
</body>

</html>