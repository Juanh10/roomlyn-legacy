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

$idTipo = $_GET['id'];

// Consulta para obtener información del tipo de habitación
$SqlTipo = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, capacidadPersonas, precioVentilador, precioAire, estado, fecha_sys FROM habitaciones_tipos WHERE id_hab_tipo = " . $idTipo . "";

// Consulta para obtener imágenes relacionadas con el tipo de habitación
$sqlImg = "SELECT habitaciones_imagenes.id_hab_imagen, habitaciones_imagenes.nombre, habitaciones_imagenes.ruta, habitaciones_imagenes.estado FROM habitaciones_imagenes INNER JOIN habitaciones_tipos ON habitaciones_imagenes.id_hab_tipo = habitaciones_tipos.id_hab_tipo WHERE habitaciones_imagenes.id_hab_tipo = " . $idTipo . "";

// consulta para obtener los servicios que estan relacionados con el tipo de habitacion
$sqlServicios = "SELECT habitaciones_tipos_elementos.id_hab_tipo_elemento, habitaciones_tipos_elementos.id_hab_tipo, habitaciones_elementos.elemento, habitaciones_tipos_elementos.estado FROM habitaciones_tipos_elementos INNER JOIN habitaciones_elementos ON habitaciones_tipos_elementos.id_hab_elemento = habitaciones_elementos.id_hab_elemento WHERE habitaciones_tipos_elementos.id_hab_tipo = " . $idTipo . "";

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
                <div class="col-md-7 me-5">

                    <?php

                    foreach ($dbh->query($SqlTipo) as $row) :
                    ?>
                        <h1 class="tituloPrincipal mb-4">Editar <?php echo $row['tipoHabitacion'] ?></h1>

                        <div class="formularioRegTipoHabi border border-1" id="<?php echo $idTipo ?>">

                            <!-- FORMULARIO PARA ACTUALIZAR LOS TIPOS DE HABITACIONES  -->

                            <form action="../../procesos/registroHabitaciones/registroTipos/conActualizarTipo.php" method="post">

                                <h2>Información</h2>

                                <input type="hidden" name="idTipoHab" value="<?php echo $idTipo ?>">

                                <label for="nombreTipo" class="form-label">Tipo de habitación</label>
                                <input type="text" name="nombreTipo" id="nombreTipo" value="<?php echo $row['tipoHabitacion'] ?>" class="form-control p-2" placeholder="Nombre del tipo de la habitacion" require>

                                <div class="row">
                                    <div class="col-5">
                                        <label for="cantidadCamas" class="form-label mt-3">Cantidad de camas</label>
                                        <input type="number" name="cantidadCamas" id="cantidadCamas" value="<?php echo $row['cantidadCamas'] ?>" min="0" class="form-control p-2 inputPeque" required>
                                    </div>

                                    <div class="col">
                                        <label for="cantidadPersonas" class="form-label mt-3">Cantidad maxima de huespedes</label>
                                        <input type="number" name="cantidadPersonas" id="cantidadPersonas" value="<?php echo $row['capacidadPersonas'] ?>" min="0" class="form-control p-2 inputPeque" required>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-5">
                                        <label for="precioVentilador" class="form-label mt-3">Costo con ventilador</label>
                                        <input type="number" name="precioVentilador" id="precioVentilador" value="<?php echo $row['precioVentilador'] ?>" min="0" class="form-control p-2 inputPeque" required>
                                    </div>

                                    <div class="col">
                                        <label for="precioAire" class="form-label mt-3">Costo con aire acondicionado</label>
                                        <input type="number" name="precioAire" id="precioAire" value="<?php echo $row['precioAire'] ?>" min="0" class="form-control p-2 inputPeque" required>
                                    </div>
                                </div>
                                <div class="botonRgServicio">
                                    <input type="submit" name="actTipo" value="Actualizar" class="btnInputSubmit">
                                </div>
                            </form>
                        </div>
                </div>

                <div class="col-4">

                    <div class="serviciosHabitaciones">
                        <h1 class="tituloServicios mb-0"><i class="bi bi-check-square"></i> Servicios</h1>
                        <ul class="listaServTipo">
                            <?php
                            // mostrar datos de los servicios
                            foreach ($dbh->query($sqlServicios) as $rowServ) :
                                if ($rowServ['estado'] == 1) :
                            ?>
                                    <li class="border border-bottom"><span><?php echo $rowServ['elemento'] ?></span>
                                        <form action="../../procesos/registroHabitaciones/registroTipos/conActualizarTipo.php" method="post">
                                            <input type="hidden" name="idTipoHab" value="<?php echo $idTipo ?>">
                                            <input type="hidden" name="idServicio" value="<?php echo $rowServ['id_hab_tipo_elemento'] ?>">
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

            <div class="row">
                <div class="col-md-7 mt-4 border border-1 cardFotos">
                    <h2>Fotos</h2>
                    <div class="actImg">
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

</body>

</html>