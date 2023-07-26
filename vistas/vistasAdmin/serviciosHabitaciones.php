<?php

session_start();

if (empty($_SESSION['idUsuario'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

/* echo $_SESSION['idUsuario'];
echo $_SESSION['pNombre'];
echo $_SESSION['pApellido'];
echo $_SESSION['tipoUsuario']; */

include_once "../../procesos/config/conex.php";

$sql = "SELECT id, elemento FROM habitaciones_elementos WHERE 1";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <?php require_once "menuAdmin.php"; ?>
    <title>Servicios</title>
</head>

<body>

    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>HABITACIONES</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <div class="contenido">
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-4">
                    <h1 class="fs-2 mb-3">Registrar servicios</h1>
                    <form action="./../../procesos/registroHabitaciones/registroServicios/conRegistroServicios.php" method="post">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="floatingInput" name="servicio" placeholder="Servicio" required>
                            <label for="floatingInput">Servicio</label>
                            <input type="submit" value="Registrar" class="btn boton-guardar mt-3">
                        </div>
                    </form>
                </div>
                <div class="col-md-8 mt-4">
                    <table class="table table-hover table-borderless text-center">
                        <thead class="tabla-background">
                            <tr>
                                <th>#</th>
                                <th>Servicio</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>

                            <?php
                            foreach ($dbh->query($sql) as $row) :
                            ?>
                                <tr>
                                    <td><?php echo $row['id'] ?></td>
                                    <td><?php echo $row['elemento'] ?></td>
                                    <td><span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar" data-bs-toggle="modal" data-bs-target="#modalActualizarServicios" title="Editar"></span></td>
                                </tr>
                            <?php
                            endforeach;
                            ?>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE ACTUALIZAR -->

    <div class="modal fade" id="modalActualizarServicios" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h5 class="modal-title">Editar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="container-fluid">
                        <form action="../../procesos/registroHabitaciones/registroServicios/conActualizarServicios.php" method="post">
                            <input type="hidden" name="idServicio" id="idServicio">
                            <label for="servicio">Servicio:</label>
                            <input type="text" class="form-control mt-2" name="servicioAct" id="servicio" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</span>
                    <input type="submit" value="Actualizar" name="btnActualizar" class="btn boton-guardar">
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ALERTAS -->

    <?php

    if (isset($_SESSION['msjCamposVacios'])) :
    ?>
        <div class="alert alert-danger alerta" role="alert">
            <strong>Campo vacio</strong>
        </div>
    <?php
        unset($_SESSION['msjCamposVacios']);
    endif;


    if (isset($_SESSION['msjRegistradoServicio'])) :
    ?>
        <div class="alert alert-success alerta" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i><?php echo $_SESSION['msjRegistradoServicio'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjRegistradoServicio']);
    endif;



    if (isset($_SESSION['msjActualizadoServicio'])) :
    ?>
        <div class="alert alert-success alerta" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i><?php echo $_SESSION['msjActualizadoServicio'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjActualizadoServicio']);
    endif;

    ?>

</body>

</html>