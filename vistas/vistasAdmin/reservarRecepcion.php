<?php

session_start();

date_default_timezone_set('America/Bogota');

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

include "../vistasHabitaciones/funcionesIconos.php";

$estadoId = false;
$pagFiltro = false;

// Obtener la URL de la pagina actual
$urlActual = $_SERVER['HTTP_REFERER'];

if (!empty($_GET['idHabitacion'])) { // Condicion para saber si los campos no estan vacios

    if(!empty($_POST['totalFactura'])){
        $totalFactura = $_POST['totalFactura'];
    }else{
        $totalFactura = 0;
    }

    $habitacion = $_GET['idHabitacion']; // capturar por medio de GET
    $tipoHabitacion = $_GET['idTipoHab'];

    $fechaRango = $_GET['fechasRango'];
    $arrayFechas = explode(" - ", $fechaRango);
    $checkin = $arrayFechas[0];
    $checkout = $arrayFechas[1];

    $sqlHabitacion = "SELECT id_habitacion, id_hab_tipo, id_hab_estado, nHabitacion, tipoCama, cantidadPersonasHab, observacion, estado FROM habitaciones WHERE id_habitacion = " . $habitacion . " AND estado = 1";

    $rowHabitacion = $dbh->query($sqlHabitacion)->fetch();

    $sqlTipoHab = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $tipoHabitacion . " AND estado = 1";

    $rowTipoHab = $dbh->query($sqlTipoHab)->fetch();

    $sqlimagenesTipoHab = "SELECT nombre, ruta, estado FROM habitaciones_imagenes WHERE estado = 1 AND id_hab_tipo = " . $tipoHabitacion . "";

    $rowImgTipoHab = $dbh->query($sqlimagenesTipoHab)->fetch();

    $estadoId = true;
} else {
    echo "Ocurrió un error";
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <?php require_once "menuAdmin.php"; ?>
</head>

<body>

    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>RESERVAR</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <main class="contenido">
        <div class="container">
            <div class="row rowPrincipal">
                <div class="col-8 col-informacion">
                    <div class="card-infor-reserva">
                        <div class="row">
                            <div class="col-4 responsive-col-img">
                                <div class="imagenes">
                                    <img src="../../imgServidor/<?php echo $rowImgTipoHab['ruta'] ?>" alt="">
                                </div>
                            </div>
                            <div class="col">
                                <div class="informacion">
                                    <div class="habitacion">
                                        <h1>Habitación <?php echo $rowHabitacion['nHabitacion'] ?> | <?php echo $rowTipoHab['tipoHabitacion'] ?></h1>
                                    </div>
                                    <div class="servicios">
                                        <p>
                                            <span>Tipo de cama:</span> <?php iconCantidadCama($rowHabitacion['tipoCama']) ?>
                                        </p>
                                        <p>
                                            <span>Capacidad:</span> <?php echo iconCapacidad($rowHabitacion['cantidadPersonasHab']) ?>
                                        </p>
                                    </div>
                                    <div class="descripcion">
                                        <p><?php echo $rowHabitacion['observacion']; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="formularioReserva">
                        <h2>Datos</h2>


                        <form action="../../procesos/registroReservas/conRegistroReservaAdmin.php" method="post" id="form" class="formReservasClienteNoReg">
                            <div class="row">
                                <div class="col-6 responsive-col-form">

                                    <input type="hidden" id="tipoHab" name="tipoHab" value="<?php echo $tipoHabitacion ?>">
                                    <input type="hidden" id="habitacion" name="habitacion" value="<?php echo $habitacion ?>">
                                    <input type="hidden" id="totalFactura" name="totalFactura" value="<?php echo $totalFactura ?>">

                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" name="nombres" id="nombres" placeholder="Nombres" required>
                                        <p></p>
                                        <label for="nombres">Nombres</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <?php
                                        if ($pagFiltro) :
                                        ?>
                                            <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin ?>" required>
                                        <?php
                                        else :
                                        ?>
                                            <input type="date" class="form-control" id="fechaEntrada" placeholder="Nombres" name="checkIn" value="<?php echo $checkin ?>" required>
                                        <?php
                                        endif;
                                        ?>
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
                                        <?php
                                        if ($pagFiltro) :
                                        ?>
                                            <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>" required>
                                        <?php
                                        else :
                                        ?>
                                            <input type="date" class="form-control" id="fechaSalida" placeholder="Nombres" name="checkOut" value="<?php echo $checkout ?>" required>
                                        <?php
                                        endif;
                                        ?>
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

                                </div>
                            </div>
                            <div class="formularioMensaje">
                                <p><i class="bi bi-exclamation-circle-fill"></i>¡Por favor rellene los campos correctamente!</p>
                            </div>

                            <div class="btnReservar">
                                <input type="submit" name="btnReservar" value="Reservar" id="btnResClnNoReg">
                            </div>

                    </div>
                </div>
                <div class="col col-factura">

                </div>
                </form>
            </div>
        </div>
    </main>

    <?php
    if (isset($_SESSION['msjError'])) :
    ?>
        <div class="alert alert-danger alerta" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i><?php echo $_SESSION['msjError'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjError']);
    endif;

    ?>

    <script src="../../js/scriptHabitacionesReservas.js"></script>
    <script src="../../js/validarRegistroReserva.js"></script>

</body>

</html>