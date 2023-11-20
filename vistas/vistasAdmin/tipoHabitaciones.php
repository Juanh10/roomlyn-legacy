<?php

session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sql = "SELECT habitaciones_tipos.id_hab_tipo, habitaciones_tipos.tipoHabitacion, habitaciones_tipos.estado AS estadoTipo, MIN(habitaciones_imagenes.ruta) AS ruta, MIN(habitaciones_imagenes.estado) AS estadoImg FROM habitaciones_tipos INNER JOIN habitaciones_imagenes ON habitaciones_tipos.id_hab_tipo = habitaciones_imagenes.id_hab_tipo WHERE habitaciones_imagenes.estado = 1 AND habitaciones_tipos.estado = 1 GROUP BY habitaciones_tipos.id_hab_tipo, habitaciones_tipos.tipoHabitacion, habitaciones_tipos.estado";

$sqlPrecios = "SELECT htp.id_tipo_servicio, htp.precio, htp.estado, habitaciones_servicios.servicio FROM habitaciones_tipos_precios htp INNER JOIN habitaciones_tipos_servicios hts ON hts.id_tipo_servicio = htp.id_tipo_servicio INNER JOIN habitaciones_servicios ON habitaciones_servicios.id_servicio = hts.id_servicio WHERE htp.estado = 1";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <?php require_once "menuAdmin.php"; ?>
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

    <main class="contenido">
        <div class="container lisTiposHb">
            <h1>Tipos de habitaciones</h1>
            <div class="row">
                <div class="col">
                    <div class="cardHabitacion">

                        <?php
                        foreach ($dbh->query($sql) as $row) :
                        ?>
                                <div class="cardHab">
                                    <?php
                                    ?>
                                        <div class="imgHab">
                                            <img src="../../imgServidor/<?php echo $row['ruta'] ?>" alt="">
                                        </div>
                                    <?php
                                    ?>
                                    <div class="tipoHab">
                                        <span class="nombreTipo"><?php echo $row['tipoHabitacion'] ?></span>
                                        <button data-id="<?php echo $row['id_hab_tipo']; ?>" data-bs-toggle="modal" data-bs-target="#modalInfor">Ver más</button>
                                    </div>
                                </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- Modal -->
    <div class="modal fade" id="modalInfor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contenidoDelCrud">

                </div>
                <div class="modal-footer">
                    <form action="../../procesos/registroHabitaciones/registroTipos/conEliminarTipo.php" method="post" id="formularioElimarTipo">
                        <input type="hidden" value="" name="idTipoHab" id="idTipoHabElm">
                        <input type="submit" value="Deshabilitar" name="btnDeshabilitar" id="btnDeshabilitar" class="btn btn-danger">
                    </form>
                    <a href="" id="editTipo" class="btn btn-warning">Editar </a>
                </div>
            </div>
        </div>
    </div>

      <!-- PIE DE PAGINA -->
      <footer class="pie-de-pagina">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>


    <!-- ALERTAS  -->

    <?php
    if (isset($_SESSION['msjError'])) :
    ?>
        <div class="alert alert-danger alerta" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i><?php echo $_SESSION['msjError'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjError']);
    endif;

    if (isset($_SESSION['msjExito'])) :
    ?>
        <div class="alert alert-success alerta" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i><?php echo $_SESSION['msjExito'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjExito']);
    endif;
    ?>

</body>

</html>