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
            <div class="row">
                <div class="col-md-7 me-5">

                    <h1 class="tituloPrincipal mb-4">Gestión de tipos de habitaciones</h1>

                    <div class="formularioRegTipoHabi border border-1">

                        <!-- FORMULARIO DE REGISTRO DE TIPOS DE HABITACIONES  -->

                        <form action="../../procesos/registroHabitaciones/registroTipos/conRegistroTipos.php" method="post" enctype="multipart/form-data" id="formularioReg">

                            <h2>Información</h2>

                            <label for="nombreTipo" class="form-label">Tipo de habitacion</label>
                            <input type="text" name="nombreTipo" id="nombreTipo" class="form-control p-2" placeholder="Nombre del tipo de la habitacion" required>
                            <p></p>

                            <div class="row">
                                <div class="col-5">
                                    <label for="cantidadCamas" class="form-label mt-3">Cantidad de camas</label>
                                    <input type="number" name="cantidadCamas" id="cantidadCamas" min="0" class="form-control p-2 inputPeque" required>
                                    <p></p>
                                </div>

                                <div class="col">
                                    <label for="cantidadPersonas" class="form-label mt-3">Cantidad maxima de huespedes</label>
                                    <input type="number" name="cantidadPersonas" id="cantidadPersonas" min="0" class="form-control p-2 inputPeque" required>
                                    <p></p>
                                </div>
                            </div>

                            <label for="formFileMultiple" class="form-label mt-3">Adjuntar imagenes</label>
                            <input class="form-control" name="imagenes[]" id="imagenes" type="file" id="formFileMultiple" accept="image/*" multiple required>
                            <p></p>

                            <div class="row">
                                <div class="col-5">
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

                <div class="col-4">

                    <div class="serviciosHabitaciones">
                        <h1 class="tituloServicios mb-0"><i class="bi bi-check-square"></i> Servicios <span class="checkSpan">(Seleccione al menos una opción)</span></h1>
                        <?php

                        foreach ($dbh->query($sql) as $row) :
                        ?>
                            <div class="form-check serviciosCheck border border-bottom">
                                <label for="" class="ocularIdServi"><?php echo $row['id'] ?></label>
                                <input class="form-check-input inputCheck ms-1" type="checkbox" id="<?php echo $row['elemento'] ?>" value="<?php echo $row['id'] ?>" name="opcionesServ[]">
                                <label class="form-check-label" for="<?php echo $row['elemento'] ?>"><?php echo $row['elemento'] ?></label>
                                <span class="btn btn-sm editServiciosBtn bi bi-pencil-square" data-bs-toggle="modal" data-bs-target="#actualizarServicios" title="Editar"></span>
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
                            <input type="text" class="form-control" id="nameServicio" name="servicio" placeholder="Servicio">
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
                        <label for="servicio">Servicio</label>
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


    <!-- ALERTAS -->

    <?php
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

    

    if (isset($_SESSION['msjRegistradoTipoH'])) {
    ?>  
    <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '<?php echo $_SESSION['msjRegistradoTipoH']; ?>',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    <?php
        unset($_SESSION['msjRegistradoTipoH']);
    }


    ?>


    <script src="../../js/scriptRegistroHabitacion.js"></script>


</body>

</html>