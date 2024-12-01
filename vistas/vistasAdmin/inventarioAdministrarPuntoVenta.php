<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sql2 = "SELECT id_punto_venta, nombre, ubicacion, contrasena, fecha_acceso, estado_conexion FROM inventario_punto_venta WHERE estado = 1";

// Ejecutar la consulta
$stmt = $dbh->prepare($sql2);
$stmt->execute();


?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <?php require_once "menuAdmin.php"; ?>
</head>
</head>

<body>
    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>CAJA PUNTO DE VENTA</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <div class="contenido">
        <div class="row mx-0">
            <div class="col">
                <div class="btnAdd mt-4 ms-5 mb-4">
                    <button type="button" class="btn botonRoomlyn fw-bold" data-bs-toggle="modal" data-bs-target="#agregar">
                        Agregar caja
                    </button>
                    <a class="btn botonRoomlyn fw-bold" href="inventarioLoginPuntoVenta.php?usuario=<?php echo $_SESSION['id_empleado'] ?>" target="_blank">Iniciar caja</a>
                </div>
                <div class="table-responsive-md">
                    <table id="tablaCajas" class="table table-hover table-condensed display nowrap">
                        <thead class="tabla-background">
                            <tr>
                                <th class="text-center" scope="col">#</th>
                                <th class="text-center" scope="col">Nombre</th>
                                <th class="text-center" scope="col">Ubicación</th>
                                <th class="text-center" scope="col">Fecha de acceso</th>
                                <th class="text-center" scope="col">Estado</th>
                                <th class="text-center" scope="col">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Mostrar los datos de cada caja
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center"><?php echo $row['id_punto_venta']; ?></td>
                                    <td class="text-center"><?php echo $row['nombre']; ?></td>
                                    <td class="text-center"><?php echo $row['ubicacion']; ?></td>
                                    <td class="text-center"><?php echo $row['fecha_acceso']; ?></td>
                                    <td class="text-center"><?php echo ($row['estado_conexion'] == 1) ? '<i class="bi bi-patch-check-fill text-success" title="Conectado"></i>' : '<i class="bi bi-patch-minus-fill text-secondary" title="Desconectado"></i>'; ?></td>
                                    <td class="text-center">
                                        <div class="accion justify-content-center">
                                            <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar" data-bs-toggle="modal" data-bs-target="#modalActualizarCaja" title="Editar"></span>
                                            <form action="../../procesos/inventario/punto_venta/conAdminCaja.php" method="post" class="formularioEliminar">
                                                <input type="hidden" name="action" value="delete">
                                                <input type="hidden" name="idCaja" value="<?php echo $row['id_punto_venta'] ?>">
                                                <button type="submit" class="btn btn-danger btn-sm eliminarbtn" title="Deshabilitar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>


    <!-- Modal agregar caja-->
    <div class="modal fade" id="agregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar caja</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formulariCajaVenta" action="../../procesos/inventario/punto_venta/conAdminCaja.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="insert">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombreCaja" name="nombreCaja" placeholder="REV0230" required>
                            <label for="referencia_cat">Nombre caja*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="ubicacionCaja" name="ubicacionCaja" placeholder="Gaseosas" required>
                            <label for="nombre_cat">Ubicación*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="9" required>
                            <label for="cantidad_cat">Contraseña*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="contrasenaTwo" name="contrasenaTwo" placeholder="9" required>
                            <label for="cantidad_cat">Confirmar contraseña*</label>
                            <p></p>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Agregar" class="btn botonRoomlyn fw-bold">
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal editar caja-->
    <div class="modal fade" id="modalActualizarCaja" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar caja</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formulariREditCajaVenta" method="post" action="../../procesos/inventario/punto_venta/conAdminCaja.php" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="update">
                    <input type="hidden" id="idCaja" name="idCaja">
                        <div class="inforCaja">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nombreEditCaja" name="nombreEditCaja" placeholder="Nombre caja" required>
                                <label for="referencia_cat">Nombre caja*</label>
                                <p></p>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="ubicacionEditCaja" name="ubicacionEditCaja" placeholder="Ubicación" required>
                                <label for="nombre_cat">Ubicación*</label>
                                <p></p>
                            </div>
                            <a class="ms-1" id="editarContra" style="cursor: pointer;">Cambiar contraseña</a>
                        </div>

                        <div class="inforContra">
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="contrasenaEdit" name="contrasenaEdit" placeholder="9" minlength="4">
                                <label for="cantidad_cat">Contraseña nueva*</label>
                                <p></p>
                            </div>

                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="contrasenaTwoEdit" name="contrasenaTwoEdit" placeholder="9">
                                <label for="cantidad_cat">Confirmar contraseña*</label>
                                <p></p>
                            </div>
                            <a class="ms-1" id="editarInformacion" style="cursor: pointer;">Cambiar Información</a>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Agregar" class="btn botonRoomlyn fw-bold">
                </div>
                </form>
            </div>
        </div>
    </div>

    <?php

    if (isset($_SESSION['msjExito'])) :
    ?>
        <script>
            // Mostrar alerta de éxito
            Swal.fire({
                icon: 'success',
                title: 'Operación exitosa',
                text: '<?php echo $_SESSION['msjExito'] ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    <?php
        unset($_SESSION['msjExito']);
    endif;

    if (isset($_SESSION['msjError'])) :
    ?>
        <script>
            // Mostrar alerta de éxito
            Swal.fire({
                icon: 'error',
                title: 'Error en la operación',
                text: '<?php echo $_SESSION['msjError'] ?>',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    <?php
        unset($_SESSION['msjError']);
    endif;

    ?>

    <script src="../../js/scriptInventario.js"></script>
    <script>
        $(document).ready(function() {
            $('#tabla_productos').load('inventario/productos/tabla_productos.php');
        })
    </script>


    <script src="../../librerias/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <script src="../../librerias/bootstrap5/js/bootstrap.min.js"></script>
    <script src="../../librerias/sweetAlert2/js/sweetalert2.all.min.js"></script>
    <script src="../../librerias/datatables/js/datatables.min.js"></script>

    <script src="https://cdn.userway.org/widget.js" data-account="5f8ySwz5CA"></script>

</body>

</html>