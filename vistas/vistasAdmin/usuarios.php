<?php

session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sql = "SELECT empleados.*, info_empleados.* FROM empleados JOIN info_empleados ON empleados.id_info_empleado = info_empleados.id_info_empleado WHERE estado = 1";

?>

<?php
//! SECCION UNICAMENTE PARA EL ADMINISTRADOR

if ($_SESSION['tipoUsuario'] == 1) :  // verificamos el tipo de usuario
?>

    <!DOCTYPE html>
    <html lang="es">

    <head>
        <?php require_once "menuAdmin.php"; ?>
    </head>

    <body>

        <header class="cabeceraMenu">
            <div class="iconoMenu">
                <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
                <span>RECEPCIONISTAS</span>
            </div>
            <div class="usuPlat">
                <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
            </div>
        </header>

        <div class="contenido">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="buscBntAgr">
                            <div class="botonAgregar">
                                <a href="../registroUsuarios.php" class="btn btnColorUsuario mb-3">Añadir Usuario</a>
                            </div>
                        </div>
                        <div class="table-responsive tabla-usuarios">
                            <table class="table table-hover table-borderless text-center" id="tablaUsuarios">
                                <thead class="tabla-background">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombres</th>
                                        <th>Documento</th>
                                        <th>Teléfono</th>
                                        <th>Email</th>
                                        <th>Tipo</th>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($dbh->query($sql) as $row) :

                                        $id = $row['id_empleado'];
                                        $nombre1 = $row['pNombre'];
                                        $nombre2 = $row['sNombre'];
                                        $apellido1 = $row['pApellido'];
                                        $apellido2 = $row['sApellido'];
                                        $documento = $row['documento'];
                                        $email = $row['email'];
                                        $celular = $row['celular'];
                                        $tipoUsuario = $row['id_rol'];
                                        $usuario = $row['usuario'];
                                        // $contraseña = $row['contraseña'];
                                        $estado = $row['estado'];
                                    ?>

                                            <tr class="filas filasUsuario">
                                                <td class="datos"><?php echo $id ?></td>
                                                <td class="datos"><?php echo $nombre1 . " " . $nombre2 . " " . $apellido1 . " " . $apellido2 ?></td>
                                                <td class="datos"><?php echo $documento ?></td>
                                                <td class="datos"><?php echo $celular ?></td>
                                                <td class="datos"><?php echo $email ?></td>
                                                <td class="datos"><?php echo ($tipoUsuario == 1) ? "Administrador" : "Recepcionista"; ?></td>
                                                <td class="datos"><?php echo $usuario ?></td>
                                                <td>
                                                    <div class="accion">
                                                        <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar" data-bs-toggle="modal" data-bs-target="#modalActualizarUsuario" title="Editar"></span>
                                                        <?php
                                                        if ($tipoUsuario != 1) :
                                                        ?>
                                                            <form action="../../procesos/registroUsuario/conEliminarUsuario.php" method="post" class="formularioEliminar">
                                                                <input type="hidden" name="id_usuario" value="<?php echo $id ?>">
                                                                <button type="submit" class="btn btn-danger btn-sm eliminarbtn" title="Deshabilitar">
                                                                    <i class="bi bi-trash"></i>
                                                                </button>
                                                            </form>
                                                        <?php
                                                        endif;
                                                        ?>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="paginacionTabla">
                            <div class="inforPaginacion">
                                <span id="totalRegistro"></span>
                                <span id="pagActual"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalActualizarUsuario" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header fondo-modal">
                        <h5 class="modal-title">Editar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <form action="../../procesos/registroUsuario/conActualizarUsuarios.php" method="post" id="formularioAct">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" id="id_usuario" name="id_usuario" required>
                                        <label for="pNombre">Primer nombre</label>
                                        <input type="text" id="pNombre" class="form-control mt-2" name="primerNombreUsuario" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Debe de llevar solo letras" required>
                                        <p></p>
                                        <label for="sNombre" class="mt-2">Segundo nombre</label>
                                        <input type="text" id="sNombre" class="form-control mt-2" name="segundoNombreUsuario" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Debe de llevar solo letras">
                                        <p></p>
                                        <label for="pApellido" class="mt-2">Primer apellido</label>
                                        <input type="text" id="pApellido" class="form-control mt-2" name="primerApellidoUsuario" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Debe de llevar solo letras" required>
                                        <p></p>
                                        <label for="sApellido" class="mt-2">Segundo apellido</label>
                                        <input type="text" id="sApellido" class="form-control mt-2" name="segundoApellidoUsuario" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Debe de llevar solo letras">
                                        <p></p>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefono">Teléfono </label>
                                        <input type="text" id="nCelular" class="form-control mt-2" name="telefonoUsuario" pattern="[0-9]*" title="Debe de llevar solo numeros" required>
                                        <p></p>
                                        <label for="email" class="mt-2">Email</label>
                                        <input type="email" id="email" class="form-control mt-2" name="emailUsuario" required>
                                        <p></p>
                                        <label for="documento" class="mt-2">Documento</label>
                                        <input type="text" id="documento" pattern="[0-9]*" title="Debe de llevar solo numeros" class="form-control mt-2" name="documentoUsuario" required>
                                        <p></p>
                                        <label for="usuario" class="mt-2">Usuario</label>
                                        <input type="text" id="usuario" class="form-control mt-2" name="usuario" required>
                                        <p></p>
                                    </div>
                                </div>
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

        <!-- PIE DE PAGINA -->
        <footer class="pie-de-pagina">
            <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
        </footer>


        <script>
            //* Mostrar datos de usuarios para editar

            $('.botonEditar').click(function(e) {
                let tr = e.target.parentElement.parentElement.parentElement; // seleccionar al tr
                let td = [...tr.children]; // convertir en arreglo


                let datos = td.map(function(element) { // recorre los td
                    return $(element).text(); // combierte los elementos del td en texto
                })

                let nombreSeparados = datos[1].split(" "); // separa el nombre y lo convierte en un arreglo

                $('#id_usuario').val(datos[0]);
                $('#pNombre').val(nombreSeparados[0]);
                $('#sNombre').val(nombreSeparados[1]);
                $('#pApellido').val(nombreSeparados[2]);
                $('#sApellido').val(nombreSeparados[3]);
                $('#documento').val(datos[2]);
                $('#nCelular').val(datos[3]);
                $('#email').val(datos[4]);
                $('#usuario').val(datos[6]);
                $('#contraseñaUsuario').val(datos[7]);
            });
        </script>


        <script src="../../js/validarRegistroUsuario.js"></script>

        <!-- MOSTRAR MENSAJE DE CONFIRMACION -->

        <?php

        if (isset($_SESSION['msj2'])) :
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
        endif;

        if (isset($_SESSION['msjExito'])) :
            ?>
                <script>
                    Swal.fire({
                        position: '',
                        icon: 'success',
                        title: '<?php echo $_SESSION['msjExito']; ?>',
                        showConfirmButton: false,
                        timer: 1000
                    });
                </script>
            <?php
                unset($_SESSION['msjExito']);
            endif;

        ?>

    </body>

    </html>

<?php

else :

    header("location: inicio.php");

endif;

?>