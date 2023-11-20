<?php

session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sql = "SELECT id_servicio, servicio FROM habitaciones_servicios WHERE 1";

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
            <span>HABITACIONES</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <div class="contenido">
        <div class="container mt-3">
            <div class="row contenedorFila">
                <div class="col-md-7 me-5 responsiveGestion">

                    <h1 class="tituloPrincipal mb-4">Gestión de tipos de habitaciones</h1>

                    <div class="formularioRegTipoHabi border border-1">

                        <!-- FORMULARIO DE REGISTRO DE TIPOS DE HABITACIONES  -->

                        <form action="../../procesos/registroHabitaciones/registroTipos/conRegistroTipos.php" method="post" enctype="multipart/form-data" id="formularioReg">

                            <h2>Información</h2>

                            <label for="nombreTipo" class="form-label">Tipo de habitación</label>
                            <input type="text" name="nombreTipo" id="nombreTipo" class="form-control p-2" placeholder="Nombre del tipo de la habitación" required>
                            <p></p>

                            <div class="row responsiveRowInput">
                                <div class="col-5 responsiveInput">
                                    <label for="cantidadCamas" class="form-label mt-3">Cantidad de camas</label>
                                    <input type="number" name="cantidadCamas" id="cantidadCamas" min="0" class="form-control p-2 inputPeque" required>
                                    <p></p>
                                </div>

                                <div class="col">
                                    <label for="cantidadPersonas" class="form-label mt-3">Cantidad maxima de huéspedes</label>
                                    <input type="number" name="cantidadPersonas" id="cantidadPersonas" min="0" class="form-control p-2 inputPeque" required>
                                    <p></p>
                                </div>
                            </div>

                            <label for="imagenes" class="form-label mt-3">Adjuntar imagenes</label>
                            <input class="form-control" name="imagenes[]" id="imagenes" type="file" accept="image/*" multiple required>
                            <p></p>

                            <div class="row responsiveRowInput">
                                <div class="col-5 responsiveInput">
                                    <label for="precioVentilador" class="form-label mt-3">Costo con ventilador</label>
                                    <input type="number" name="precioVentilador" id="precioVentilador" min="0" class="form-control p-2 inputPeque" required>
                                    <p></p>
                                </div>

                                <div class="col">
                                    <label for="precioAire" class="form-label mt-3">Costo con aire acondicionado</label>
                                    <input type="number" name="precioAire" id="precioAire" min="0" class="form-control p-2 inputPeque" required>
                                    <p></p>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="col-4 responsiveServicios">

                    <div class="serviciosHabitaciones">
                        <h1 class="tituloServicios mb-0"><i class="bi bi-check-square"></i> Servicios</h1>
                        <?php

                        foreach ($dbh->query($sql) as $row) :
                        ?>
                            <div class="form-check serviciosCheck border border-bottom">

                                <?php

                                $elemento = strtolower($row['servicio']);

                                ?>
                                <label for="" class="ocularIdServi"><?php echo $row['id_servicio'] ?></label>

                                <?php

                                if ($elemento == "ventilador" || $elemento == "aire acondicionado") {
                                ?>
                                    <input class="form-check-input inputCheck ms-1" type="checkbox" id="<?php echo $row['servicio'] ?>" value="<?php echo $row['id_servicio'] ?>" name="opcionesServ[]" checked disabled>
                                    <label class="form-check-label" for="<?php echo $row['servicio'] ?>"><?php echo $row['servicio'] ?></label>
                                <?php
                                } else {
                                ?>
                                    <input class="form-check-input inputCheck ms-1" type="checkbox" id="<?php echo $row['servicio'] ?>" value="<?php echo $row['id_servicio'] ?>" name="opcionesServ[]" >
                                    <label class="form-check-label" for="<?php echo $row['servicio'] ?>"><?php echo $row['servicio'] ?></label>
    
                                    <span class="btn btn-sm editServiciosBtn bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#actualizarServicios" title="Editar"></span>
                                <?php
                                }
                                ?>
                            </div>
                        <?php
                        endforeach;
                        ?>
                        <!-- BOTON PARA AÑADIR MAS SERVICIOS -->
                        <div class="botonRegServi">
                            <span class="btnServicio" data-bs-toggle="modal" data-bs-target="#modalRegServ">Registrar servicio</span>
                        </div>
                    </div>
                    <div>
                        <span id="mensajeErrorServicio">Debes seleccionar al menos un servicio</span>
                    </div>
                </div>
            </div>
            <div class="formularioMensaje">
                <p><i class="bi bi-exclamation-circle-fill"></i>¡Por favor rellene los campos correctamente!</p>
            </div>
            <div class="botonRgServicio">
                <input type="submit" value="Registrar" class="btnInputSubmit">
            </div>
            </form>
        </div>
    </div>



    <!-- MODAL DE AÑADIR MAS SERVICIOS -->

    <div class="modal fade" id="modalRegServ" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar servicio</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="../../procesos/registroHabitaciones/registroServicios/conRegistroServicios.php" method="post">
                        <div class="form-floating">
                            <input type="text" class="form-control" id="nameServicio" name="servicio" placeholder="Servicio" required>
                            <label for="nameServicio">Servicio</label>
                        </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" value="Registrar" name="registrarServicio" class="btn boton-guardar">
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- MODAL PARA ACTUALIZAR SERVICIOS -->

    <div class="modal fade" id="actualizarServicios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Actualizar servicio</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../procesos/registroHabitaciones/registroServicios/conActualizarServicios.php" method="post">
                        <input type="hidden" class="form-control mt-2" id="idServicio" name="idServicio">
                        <label for="servicioAct">Servicio</label>
                        <input type="text" class="form-control mt-2" id="servicioAct" name="servicioAct">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <input type="submit" value="Actualizar" class="btn boton-guardar">
                </div>
                </form>
            </div>
        </div>
    </div>

    <!-- PIE DE PAGINA -->
    <footer class="pie-de-pagina">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>

    <!-- ALERTAS -->

    <?php

    // registro de servicios
    if (isset($_SESSION['mensaje'])) :
    ?>
        <div class="alert alert-success alerta" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i><?php echo $_SESSION['mensaje'] ?></strong>
        </div>
    <?php
        unset($_SESSION['mensaje']);
    endif;

    // registro de tipos de habitaciones

    if (isset($_SESSION['msj2'])) {
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '<?php echo $_SESSION['msj2']; ?>',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    <?php
        unset($_SESSION['msj2']);
    }

    // Alerta de errores
    if (isset($_SESSION['msjError'])) :
    ?>
        <div class="alert alert-danger alerta" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i><?php echo $_SESSION['msjError'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjError']);
    endif;


    ?>


    <script src="../../js/validarRegistroTipoHabitaciones.js"></script>


</body>

</html>