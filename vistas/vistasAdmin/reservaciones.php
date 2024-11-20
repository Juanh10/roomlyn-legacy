<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";
include_once "../../procesos/funciones/formatearFechas.php";

$sqlReservas = "SELECT r.id_reserva, r.id_cliente, r.id_habitacion, r.id_estado_reserva, r.fecha_ingreso, r.fecha_salida, r.total_reserva, r.monto_abonado, r.saldo_pendiente, r.estado, DATE(r.fecha_sys) AS fecha_sys, info.nombres, info.apellidos, info.documento, es.nombre_estado, h.nHabitacion FROM reservas AS r INNER JOIN estado_reservas AS es ON es.id_estado_reserva = r.id_estado_reserva INNER JOIN habitaciones AS h ON h.id_habitacion = r.id_habitacion INNER JOIN info_clientes AS info ON info.id_info_cliente = r.id_cliente WHERE 1 ORDER BY r.id_reserva DESC";

$sqlTotal = "SELECT SUM(total_reserva) AS ingresos_totales FROM reservas WHERE id_estado_reserva = 4 AND MONTH(fecha_sys) = MONTH(CURRENT_DATE())";
$resultTotal = $dbh->query($sqlTotal)->fetch();

$sqlEstados = "SELECT er.nombre_estado, COUNT(*) AS cantidad_reservas FROM reservas r JOIN estado_reservas er ON r.id_estado_reserva = er.id_estado_reserva GROUP BY r.id_estado_reserva";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "menuAdmin.php"; ?>
    <title>Reservas</title>
</head>

<body>

    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>HISTORIAL DE RESERVACIONES</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <main class="contenido">
        <div class="container" id="contenedorIniReservaciones">
            <div class="filtrarFechas">
                <button class="btn botonFiltrarFecha mb-3" id="btnRegRes" data-bs-toggle="modal" data-bs-target="#modalRegReserva">Agregar reserva</button>
                <button class="btn botonFiltrarFecha mb-3" id="btnFiltrar" data-bs-toggle="modal" data-bs-target="#modalFiltrarFecha">Filtrar reservas</button>
            </div>

            <div class="container mb-3">
                <div class="row">
                    <span class="desplegarInformacionRecep">Mostrar información</span>
                    <?php
                    if ($_SESSION['tipoUsuario'] == 1):
                    ?>

                        <div class="col-md-3 mb-3">
                            <div class="card cardInformacion tarjeta">
                                <h4 style="text-align: center; margin: 8px;" class="numero-cant">$<?php echo number_format($resultTotal['ingresos_totales'], 0, ',', '.') ?></h4>
                                <p style="font-size: 12px; text-align: center;" class="card-text">Ingresos mensuales</p>
                            </div>
                        </div>

                    <?php
                    endif;
                    ?>
                    <?php

                    foreach ($dbh->query($sqlEstados) as $rowEstado) :
                    ?>
                        <div class="col-md-3 mb-3">
                            <div class="card cardInformacion tarjeta">
                                <h4 style="text-align: center; margin: 8px;" class="numero-cant"><?php echo $rowEstado['cantidad_reservas'] ?></h4>
                                <p style="font-size: 12px; text-align: center;" class="card-text">Reservas <?php echo $rowEstado['nombre_estado'] ?></p>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col contenidoPrincipal">
                    <div class="table-responsive tabla-reservas">
                        <table class="table table-hover table-borderless text-center tableAdmin" id="tablaReservas" aria-label="Reservaciones">
                            <thead class="tabla-background">
                                <tr>
                                    <th>Habitación</th>
                                    <th>Cliente</th>
                                    <th>Documento</th>
                                    <th>Fecha ingreso</th>
                                    <th>Fecha salida</th>
                                    <th>Estado</th>
                                    <th>Total</th>
                                    <th>Monto abonado</th>
                                    <th>Saldo Pendiente</th>
                                    <th class="no-export">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($dbh->query($sqlReservas) as $row) :

                                    $id = $row['id_reserva'];
                                    $idHab = $row['id_habitacion'];
                                    $habitacion = $row['nHabitacion'];
                                    $idCliente = $row['id_cliente'];
                                    $nombres = $row['nombres'];
                                    $apellidos = $row['apellidos'];
                                    $documento = $row['documento'];
                                    $fechaIngreso = formatearFecha($row['fecha_ingreso']);
                                    $fechaSalida = formatearFecha($row['fecha_salida']);
                                    $idEstado = $row['id_estado_reserva'];
                                    $estado = $row['nombre_estado'];
                                    $total = $row['total_reserva'];
                                    $monto = $row['monto_abonado'];
                                    $saldo = $row['saldo_pendiente'];
                                    $fechaSys = formatearFecha($row['fecha_sys']);
                                ?>

                                    <tr class="filas filasUsuario">
                                        <td class="datos"><?php echo $habitacion ?></td>
                                        <td class="datos"><?php echo $nombres . " " . $apellidos ?></td>
                                        <td class="datos"><?php echo $documento ?></td>
                                        <td class="datos"><?php echo $fechaIngreso ?></td>
                                        <td class="datos"><?php echo $fechaSalida ?></td>
                                        <td class="datos"><?php echo $estado ?></td>
                                        <td class="datos"><?php echo number_format($total, 0, ',', '.') ?></td>
                                        <td class="datos"><?php echo number_format($monto, 0, ',', '.') ?></td>
                                        <td class="datos"><?php echo number_format($saldo, 0, ',', '.') ?></td>
                                        <td>
                                            <div class="accion">
                                                <span class="bi bi-search btn btn-primary btn-sm mx-2 btnInforCli" data-bs-toggle="modal" data-bs-target="#modalVerInformacion" title="Ver información del cliente" id="<?php echo $idCliente ?>"></span>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="paginacionTabla">
                        <div class="inforPaginacion">
                            <span id="totalRegistro"></span>
                            <span id="pagActual"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="contenedorFilReservaciones"></div>
    </main>


    <!-- PIE DE PAGINA -->
    <footer class="pie-de-pagina">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>

    <!-- MODAL VER INFORMACION DEL CLIENTE -->

    <div class="modal fade" id="modalVerInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Información</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contenidoInforCliente"></div>
            </div>
        </div>
    </div>

    <!-- MODAL FILTRAR FECHAS -->
    <div class="modal fade" id="modalFiltrarFecha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filtrar reservas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formFiltrarFecha">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="fechaInicio" placeholder="Fecha Inicio" required>
                            <label for="fechaInicio">Fecha inicio</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="fechaFinal" placeholder="Fecha Inicio" required>
                            <label for="fechaFinal">Fecha final</label>
                        </div>

                        <div class="form-floating mb-3">
                            <select name="selectFiltro" class="form-select" id="selectFiltroEstado">
                                <option value="0" selected>Todos</option>
                                <?php
                                $sqlEstados = "SELECT id_estado_reserva, nombre_estado FROM estado_reservas WHERE 1";

                                foreach ($dbh->query($sqlEstados) as $rowEstado) :
                                ?>
                                    <option value="<?php echo $rowEstado['id_estado_reserva'] ?>"><?php echo $rowEstado['nombre_estado'] ?></option>
                                <?php
                                endforeach;
                                ?>
                            </select>
                            <label for="selectFiltro">Estado de la reserva</label>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <button type="button" class="btn boton-guardar" id="filtroBtnFechaRes">Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL REGISTRAR RESERVA -->
    <div class="modal fade" id="modalRegReserva" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar reserva</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formHistorialReserva" class="formReservasClienteNoReg">
                        <select class="form-select mb-3" id="habitacion" name="habitacion" required>
                            <option disabled selected value="">Número de habitación</option>
                            <?php
                            $sqlNacionalidad = "SELECT id_habitacion, nHabitacion FROM habitaciones WHERE estado = 1 ORDER BY nHabitacion ASC";

                            foreach ($dbh->query($sqlNacionalidad) as $rowNacionalidad) :
                            ?>
                                    <option value="<?php echo $rowNacionalidad['id_habitacion'] ?>"><?php echo 'Habitación '.$rowNacionalidad['nHabitacion'] ?></option>
                            <?php
                            endforeach;
                            ?>
                        </select>
                        <div class="row">
                            <div class="col-6 responsive-col-form">

                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombres" required>
                                    <p></p>
                                    <label for="nombres">Nombres</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fechaEntradaRes" placeholder="Nombres" name="checkIn" required>
                                    <p></p>
                                    <label for="fechaEntrada">Fecha de llegada</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="documento" class="form-control" id="documento" placeholder="Documento" required>
                                    <p></p>
                                    <label for="documento">Documento</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="email" name="email" class="form-control" id="email" placeholder="Email" required>
                                    <p></p>
                                    <label for="email">Email</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" name="nacionalidad" id="nacionalidad" required>
                                        <option selected disabled value="">Escoja una opción</option>
                                        <?php
                                        $sqlNacionalidad = "SELECT id_nacionalidad, nacionalidad FROM nacionalidades WHERE 1";

                                        foreach ($dbh->query($sqlNacionalidad) as $rowNacionalidad) :
                                            if ($rowNacionalidad['id_nacionalidad'] != 1) :
                                        ?>
                                                <option value="<?php echo $rowNacionalidad['id_nacionalidad'] ?>"><?php echo $rowNacionalidad['nacionalidad'] ?></option>
                                        <?php
                                            endif;
                                        endforeach;

                                        ?>
                                    </select>
                                    <label for="nacionalidad">Nacionalidad</label>
                                </div>

                                <div class="form-floating mb-3" id="selectCiudad">
                                    <select class="form-select" name="ciudad" id="ciudad" required>

                                    </select>
                                    <label for="ciudad">Ciudad de origen</label>
                                </div>

                            </div>
                            <div class="col-6">

                                <div class="form-floating mb-3">
                                    <input type="text" name="apellidos" class="form-control" id="apellidos" placeholder="Apellidos" required>
                                    <p></p>
                                    <label for="apellidos">Apellidos</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="date" class="form-control" id="fechaSalidaRes" placeholder="Nombres" name="checkOut" required>
                                    <p></p>
                                    <label for="fechaSalida">Fecha de salida</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Teléfono" required>
                                    <p></p>
                                    <label for="telefono">Teléfono</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <select class="form-select" name="sexo" id="sexo" required>
                                        <option selected disabled value="">Escoja una opción</option>
                                        <option value="Masculino">Masculino</option>
                                        <option value="Femenino">Femenino</option>
                                    </select>
                                    <p></p>
                                    <label for="sexo">Sexo</label>
                                </div>

                                <div class="form-floating mb-3" id="selectDepartamento">
                                    <select class="form-select" name="departamento" id="departamento" required>

                                    </select>
                                    <label for="departamento">Departamento</label>
                                </div>

                                <div class="form-floating mb-3">
                                    <!-- select -->
                                    <input type="text" class="form-control" id="totalReserva" name="totalReserva" placeholder="Cantidad a abonar">
                                    <p></p>
                                    <label for="montoReserva">Total de la reserva</label>
                                </div>

                            </div>
                        </div>
                        <div class="formularioMensaje">
                            <p><i class="bi bi-exclamation-circle-fill"></i>¡Por favor rellene los campos correctamente!</p>
                        </div>

                        <div class="btnReservar d-flex justify-content-center">
                            <input type="submit" class="btn" style="background-color: #9d8076; font-weight: bold;" name="btnReservar" value="Agregar reserva" id="btnResClnNoReg">
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>
    </div>

    <!-- ALERTAS -->

    <?php

    if (isset($_SESSION['msjExito'])) :
    ?>
        <div class="alert alert-success alerta" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i><?php echo $_SESSION['msjExito'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjExito']);
    endif;

    if (isset($_SESSION['msjError'])) :
    ?>
        <div class="alert alert-danger alerta" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i><?php echo $_SESSION['msjError'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjError']);
    endif;

    if (isset($_SESSION['msjReservasExito'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '¡RESERVA REGISTRADA!',
                html: '',
                showConfirmButton: true
            });
        </script>
    <?php
        unset($_SESSION['msjReservasExito']);
    endif;

    ?>

    <script src="../../js/scriptHistorialReservaciones.js"></script>

</body>

</html>