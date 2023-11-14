<?php

session_start();

include_once "../../procesos/config/conex.php";

if (empty($_SESSION['id_cliente_registrado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

$idCliente = $_SESSION['id_cliente_registrado'];
$nombres = explode(" ", $_SESSION['nombres']);
$apellidos = explode(" ", $_SESSION['apellidos']);

$primerNombre = $nombres[0];
$primerApellido = $apellidos[0];

$sql = "SELECT reservas.id_reserva, reservas.id_cliente, reservas.id_estado_reserva, reservas.fecha_ingreso, reservas.fecha_salida, reservas.total_reserva, reservas.estado, reservas.fecha_sys, habitaciones.nHabitacion, habitaciones_tipos.tipoHabitacion, estado_reservas.nombre_estado FROM reservas INNER JOIN clientes_registrados ON reservas.id_cliente = clientes_registrados.id_cliente_registrado INNER JOIN habitaciones ON habitaciones.id_habitaciones = reservas.id_habitaciones INNER JOIN habitaciones_tipos ON habitaciones_tipos.id_hab_tipo = habitaciones.id_hab_tipo INNER JOIN estado_reservas ON estado_reservas.id_estado_reserva = reservas.id_estado_reserva WHERE id_cliente = " . $idCliente . "";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "dependencias.php" ?>
    <title>Configuración</title>
</head>

<body>


    <!--* PRELOADER CARGAR PAGINA WEB -->

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


    <header class="cabecera">
        <div class="contenedor navContenedor">
            <div class="logoPlahot">
                <a href="../../index.php"><img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
            </div>
            <div class="menuRespon">
                <div class="icono">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <nav class="navegacion">
                <ul>
                    <li class="inicioSesionCliente" title="Conectado">
                        <a href="configuracionCuenta.php" class="inicioSesion"><span class="conexion"></span><?php echo $primerNombre . " " . $primerApellido ?></a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <h1>Resumen de las reservas</h1>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover table-borderless text-center mt-3" id="tablaReservasRealizadas">
                            <thead class="tabla-background">
                                <tr>
                                    <th>#</th>
                                    <th>Check in</th>
                                    <th>Check out</th>
                                    <th>Habitación</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Fecha de la reserva</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
    
                                foreach ($dbh->query($sql) as $row) :
    
                                    $idReserva = $row['id_reserva'];
                                    $checkIn = $row['fecha_ingreso'];
                                    $checkOut = $row['fecha_salida'];
                                    $totalReserva = $row['total_reserva'];
                                    $habitacion = $row['nHabitacion'];
                                    $tipoHabitacion = $row['tipoHabitacion'];
                                    $idEstado = $row['id_estado_reserva'];
                                    $estado = $row['nombre_estado'];
                                    $fechaRegistro = $row['fecha_sys'];
    
                                ?>
    
                                    <tr>
                                        <td><?php echo $idReserva ?></td>
                                        <td><?php echo $checkIn ?></td>
                                        <td><?php echo $checkOut ?></td>
                                        <td>Habitación <?php echo $habitacion ?> - <?php echo $tipoHabitacion ?></td>
                                        <td><?php echo $totalReserva ?></td>
                                        <td><?php echo $estado ?></td>
                                        <td><?php echo $fechaRegistro ?></td>
                                        <?php
                                        if ($idEstado != 4 && $idEstado != 3) :
                                        ?>
                                            <td>
                                                <form action="../../procesos/registroReservas/conCancelarReserva.php" method="post" class="formCancelarReserva">
                                                    <input type="hidden" name="idReserva" value="<?php echo $idReserva ?>">
                                                    <button type="submit" class="btn btn-danger btn-sm eliminarbtn" title="Cancelar reserva">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        <?php
                                        else :
                                        ?>
                                            <td></td>
                                        <?php
                                        endif;
                                        ?>
                                    </tr>
    
                                <?php
                                endforeach;
    
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <?php

    if (isset($_SESSION['msjCn'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '<?php echo $_SESSION['msjCn']; ?>',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    <?php
        unset($_SESSION['msjCn']);
    endif;

    ?>

</body>

</html>