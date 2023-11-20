<?php

session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$idTipo = $_GET['id'];

// Consulta para obtener información del tipo de habitación
$SqlTipo = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, capacidadPersonas, estado, fecha_sys FROM habitaciones_tipos WHERE id_hab_tipo = " . $idTipo . "";

// Consulta para obtener imágenes relacionadas con el tipo de habitación
$sqlImg = "SELECT habitaciones_imagenes.id_hab_imagen, habitaciones_imagenes.nombre, habitaciones_imagenes.ruta, habitaciones_imagenes.estado FROM habitaciones_imagenes INNER JOIN habitaciones_tipos ON habitaciones_imagenes.id_hab_tipo = habitaciones_tipos.id_hab_tipo WHERE habitaciones_imagenes.id_hab_tipo = " . $idTipo . "";

// consulta para obtener los servicios que estan relacionados con el tipo de habitacion
$sqlServicios = "SELECT habitaciones_tipos_servicios.id_tipo_servicio, habitaciones_tipos_servicios.id_hab_tipo, habitaciones_servicios.servicio, habitaciones_servicios.id_servicio, habitaciones_tipos_servicios.estado FROM habitaciones_tipos_servicios INNER JOIN habitaciones_servicios ON habitaciones_tipos_servicios.id_servicio = habitaciones_servicios.id_servicio WHERE habitaciones_tipos_servicios.estado = 1 AND habitaciones_tipos_servicios.id_hab_tipo = " . $idTipo . "";

$sqlPrecioVentilador = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON htp.id_tipo_servicio = hts.id_tipo_servicio WHERE hts.id_hab_tipo = " . $idTipo . " AND hts.id_servicio = 1 AND htp.estado = 1";

$sqlPrecioAire = "SELECT htp.id_tipo_precio, htp.id_tipo_servicio, htp.precio FROM habitaciones_tipos_precios AS htp INNER JOIN habitaciones_tipos_servicios AS hts ON htp.id_tipo_servicio = hts.id_tipo_servicio WHERE hts.id_hab_tipo = " . $idTipo . " AND hts.id_servicio = 2 AND htp.estado = 1";

?>

<!DOCTYPE html>
<html lang="en">

<head>
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

    <div class="contenido">
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-7 me-5 responsive-informacion">

                    <?php

                    foreach ($dbh->query($SqlTipo) as $row) :
                    ?>
                        <h1 class="tituloPrincipal mb-4">Editar <?php echo $row['tipoHabitacion'] ?></h1>

                        <div class="formularioRegTipoHabi border border-1" id="<?php echo $idTipo ?>">

                            <!-- FORMULARIO PARA ACTUALIZAR LOS TIPOS DE HABITACIONES  -->

                            <form action="../../procesos/registroHabitaciones/registroTipos/conActualizarTipo.php" method="post" id="formActTipoCama">

                                <h2>Información</h2>

                                <input type="hidden" name="idTipoHab" value="<?php echo $idTipo ?>">

                                <input type="hidden" name="actTipo" value="1">

                                <label for="nombreTipo" class="form-label">Tipo de habitación</label>
                                <input type="text" name="nombreTipo" id="nombreTipo" value="<?php echo $row['tipoHabitacion'] ?>" class="form-control p-2" placeholder="Nombre del tipo de la habitacion" require>
                                <p></p>

                                <div class="row responsiveRowInput">
                                    <div class="col-5 responsiveInput">
                                        <label for="cantidadCamas" class="form-label mt-3">Cantidad de camas</label>
                                        <input type="number" name="cantidadCamas" id="cantidadCamas" value="<?php echo $row['cantidadCamas'] ?>" min="0" class="form-control p-2 inputPeque" required>
                                        <p></p>
                                    </div>

                                    <div class="col">
                                        <label for="cantidadPersonas" class="form-label mt-3">Cantidad maxima de huéspedes</label>
                                        <input type="number" name="cantidadPersonas" id="cantidadPersonas" value="<?php echo $row['capacidadPersonas'] ?>" min="0" class="form-control p-2 inputPeque" required>
                                        <p></p>
                                    </div>
                                </div>

                                <div class="row responsiveRowInput">
                                    <div class="col-5 responsiveInput">
                                        <?php

                                        foreach ($dbh->query($sqlPrecioVentilador) as $rowPrecios) :
                                        ?>
                                            <label for="precioVentilador" class="form-label mt-3">Costo con ventilador</label>
                                            <input type="number" name="precioVentilador" id="precioVentilador" value="<?php echo $rowPrecios['precio'] ?>" min="0" class="form-control p-2 inputPeque" required>
                                            <p></p>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>

                                    <div class="col">
                                        <?php

                                        foreach ($dbh->query($sqlPrecioAire) as $rowPrecios) :
                                        ?>
                                            <label for="precioAire" class="form-label mt-3">Costo con aire acondicionado</label>
                                            <input type="number" name="precioAire" id="precioAire" value="<?php echo $rowPrecios['precio'] ?>" min="0" class="form-control p-2 inputPeque" required>
                                            <p></p>
                                        <?php
                                        endforeach;
                                        ?>
                                    </div>
                                </div>
                                <div class="botonRgServicio">
                                    <input type="submit" name="actTipoBtn" value="Actualizar" class="btnInputSubmit">
                                </div>
                            </form>
                        </div>
                </div>

                <div class="col-4 responsiveServicios">

                    <div class="serviciosHabitaciones">
                        <h1 class="tituloServicios mb-0"><i class="bi bi-check-square"></i> Servicios</h1>
                        <ul class="listaServTipo">
                            <?php
                            // mostrar datos de los servicios
                            foreach ($dbh->query($sqlServicios) as $rowServ) :
                                if ($rowServ['id_servicio'] == 1 || $rowServ['id_servicio'] == 2) :
                            ?>
                                    <li class="border border-bottom"><span><?php echo $rowServ['servicio'] ?></span></li>
                                <?php
                                else :
                                ?>
                                    <li class="border border-bottom"><span><?php echo $rowServ['servicio'] ?></span>
                                        <form action="../../procesos/registroHabitaciones/registroTipos/conActualizarTipo.php" method="post">
                                            <input type="hidden" name="idTipoHab" value="<?php echo $idTipo ?>">
                                            <input type="hidden" name="idServicio" value="<?php echo $rowServ['id_tipo_servicio'] ?>">
                                            <button type="submit" name="btnElmServ" title="Deshabilitar"><i class="bi bi-trash"></i></button>
                                        </form>
                                    </li>
                            <?php
                                endif;
                            endforeach;
                            ?>
                            <li class="btnAñadirServ" id="btnAddServ" title="Añadir servicio"><button data-bs-toggle="modal" data-bs-target="#modalAddServ" id="<?php echo $row['id_hab_tipo'] ?>">Añadir</button></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row respisive-row-fotos">
                <div class="col-md-7 mt-4 border border-1 cardFotos">
                    <h2>Fotos</h2>
                    <div class="actImg responsive-card-fotos">
                        <?php
                        // mostrar las imagenes por medio del foreach
                        foreach ($dbh->query($sqlImg) as $row) :
                            if ($row['estado'] == 1) :
                        ?>
                                <div class="listImg2" id="<?php echo $row['id_hab_imagen'] ?>" data-bs-toggle="modal" data-bs-target="#modalImg" title="Editar imagen">
                                    <img src="../../imgServidor/<?php echo $row['ruta'] ?>" alt="Fotos de las habitaciones">
                                </div>
                        <?php
                            endif;
                        endforeach;
                        ?>
                        <div class="addFoto" title="Añadir imagen">
                            <i class="bi bi-camera"></i>
                            <label for="addImg">Añadir</label>
                        </div>
                        <form action="../../procesos/registroHabitaciones/registroTipos/conActualizarImgTipo.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="idTipoHab" value="<?php echo $idTipo ?>">
                            <input type="file" accept="image/*" name="addImg" id="addImg">
                            <input type="submit" value="Enviar" name="btnAddImg" id="btnAddImg">
                        </form>

                    </div>
                </div>
            </div>
        <?php
                    endforeach;
        ?>
        </div>
    </div>




    <!-- Modal de actualizar imagenes -->
    <div class="modal fade" id="modalImg" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Editar foto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contenidoImg">

                </div>
            </div>
        </div>
    </div>


    <!-- MODAL DE AÑADIR MAS SERVICIOS-->

    <div class="modal fade" id="modalAddServ" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir servicios</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalAddServ2"></div>
            </div>
        </div>
    </div>


    <!-- ALERTAS -->

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

    <script src="../../js/validarRegistroTipoHabitaciones.js"></script>

</body>

</html>