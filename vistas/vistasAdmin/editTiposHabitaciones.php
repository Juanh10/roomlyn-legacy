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
                    // Consulta para obtener información del tipo de habitación
                    $SqlTipo = "SELECT id, tipoHabitacion, cantidadCamas, capacidadPersonas, precioVentilador, precioAire, estado, fecha_sys FROM habitaciones_tipos WHERE id = " . $idTipo . "";

                    // Consulta para obtener imágenes relacionadas con el tipo de habitación
                    $sqlImg = "SELECT habitaciones_imagenes.id, habitaciones_imagenes.nombre, habitaciones_imagenes.ruta, habitaciones_imagenes.estado FROM habitaciones_imagenes INNER JOIN habitaciones_tipos ON habitaciones_imagenes.idTipoHabitacion = habitaciones_tipos.id WHERE habitaciones_imagenes.idTipoHabitacion = " . $idTipo . "";

                    foreach ($dbh->query($SqlTipo) as $row) :
                    ?>
                        <h1 class="tituloPrincipal mb-4">Editar <?php echo $row['tipoHabitacion'] ?></h1>

                        <div class="formularioRegTipoHabi border border-1" id="<?php echo $idTipo ?>">

                            <!-- FORMULARIO PARA ACTUALIZAR LOS TIPOS DE HABITACIONES  -->

                            <form action="../../procesos/registroHabitaciones/registroTipos/conRegistroTipos.php" method="post" enctype="multipart/form-data" id="formularioReg">

                                <h2>Información</h2>

                                <label for="nombreTipo" class="form-label">Tipo de habitacion</label>
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
                        </div>
                </div>

                <div class="col-4">

                    <div class="serviciosHabitaciones">
                        <h1 class="tituloServicios mb-0"><i class="bi bi-check-square"></i> Servicios <span class="checkSpan">(Seleccione al menos una opción)</span></h1>



                    </div>

                    <div>
                        <span id="mensajeErrorServicio">Debes seleccionar al menos un servicio</span>
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
                        ?>
                            <div class="listImg" id="<?php echo $row['id'] ?>" data-bs-toggle="modal" data-bs-target="#modalImg">
                                <img src="../../imgServidor/<?php echo $row['ruta'] ?>" alt="Fotos de las habitaciones">
                            </div>
                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>

            <div class="botonRgServicio">
                <input type="submit" value="Actualizar" class="btnInputSubmit">
            </div>

            </form>
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
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Actualizar foto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contenidoImg">
                    
                </div>
            </div>
        </div>
    </div>

</body>

</html>