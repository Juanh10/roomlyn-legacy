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

$sql = "SELECT usuarios.*, infousuarios.* FROM usuarios JOIN infousuarios ON usuarios.id_infoUsuario = infousuarios.id_infoUsuario WHERE 1";

?>

<?php
//! SECCION UNICAMENTE PARA EL ADMINISTRADOR

if (strtolower($_SESSION['tipoUsuario']) == "administrador") :  // verificamos el tipo de usuario
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
                <span>USUARIOS</span>
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
                            <!--                 <input type="search" class="buscador form-control" id="buscador" name="buscador" placeholder="Buscar"> -->
                        </div>
                        <div class="table-responsive tabla-usuarios">
                            <table class="table table-hover table-borderless text-center" id="tablaUsuarios">
                                <thead class="tabla-background">
                                    <tr>
                                        <th>#</th>
                                        <th>Nombres</th>
                                        <th>Documento</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th>Tipo</th>
                                        <th>Usuario</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($dbh->query($sql) as $row) :

                                        $id = $row['idUsuario'];
                                        $nombre1 = $row['pNombre'];
                                        $nombre2 = $row['sNombre'];
                                        $apellido1 = $row['pApellido'];
                                        $apellido2 = $row['sApellido'];
                                        $documento = $row['documento'];
                                        $email = $row['email'];
                                        $celular = $row['celular'];
                                        $tipoUsuario = $row['tipoUsuario'];
                                        $usuario = $row['usuario'];
                                        // $contraseña = $row['contraseña'];
                                        $estado = $row['estado'];

                                        if ($estado == 1) :

                                    ?>

                                            <tr class="filas filasUsuario">
                                                <td class="datos"><?php echo $id ?></td>
                                                <td class="datos"><?php echo $nombre1 . " " . $nombre2 . " " . $apellido1 . " " . $apellido2 ?></td>
                                                <td class="datos"><?php echo $documento ?></td>
                                                <td class="datos"><?php echo $celular ?></td>
                                                <td class="datos"><?php echo $email ?></td>
                                                <td class="datos"><?php echo $tipoUsuario ?></td>
                                                <td class="datos"><?php echo $usuario ?></td>
                                                <td>
                                                    <div class="accion">
                                                        <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar" data-bs-toggle="modal" data-bs-target="#modalActualizarUsuario" title="Editar"></span>

                                                        <form action="../../procesos/registroUsuario/conEliminarUsuario.php" method="post" class="formularioEliminar">

                                                            <input type="hidden" name="id_usuario" value="<?php echo $id ?> ">

                                                            <button type="submit" class="btn btn-danger btn-sm eliminarbtn" title="Deshabilitar">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                    <?php

                                        endif;
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
                            <!--                         <div class=botonesPaginacion">
                            <button class="btn colorBtn" id="btnAnterior"><i class="bi bi-caret-left-fill"></i> Anterior</button>
                            <button class="btn colorBtn" id="btnSiguiente">Siguiente <i class="bi bi-caret-right-fill"></i></button>
                        </div> -->
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
                            <form action="../../procesos/registroUsuario/conActualizarUsuarios.php" method="post">
                                <div class="row">
                                    <div class="col-md-6">
                                        <input type="hidden" id="id_usuario" name="id_usuario">
                                        <label for="pNombre">Primer nombre</label>
                                        <input type="text" id="pNombre" class="form-control mt-2" name="primerNombreUsuario">
                                        <label for="sNombre" class="mt-2">Segundo nombre</label>
                                        <input type="text" id="sNombre" class="form-control mt-2" name="segundoNombreUsuario">
                                        <label for="pApellido" class="mt-2">Primer apellido</label>
                                        <input type="text" id="pApellido" class="form-control mt-2" name="primerApellidoUsuario">
                                        <label for="sApellido" class="mt-2">Segundo apellido</label>
                                        <input type="text" id="sApellido" class="form-control mt-2" name="segundoApellidoUsuario">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="telefono">Telefono</label>
                                        <input type="text" id="telefono" class="form-control mt-2" name="telefonoUsuario">
                                        <label for="email" class="mt-2">Email</label>
                                        <input type="email" id="email" class="form-control mt-2" name="emailUsuario">
                                        <label for="documento" class="mt-2">Documento</label>
                                        <input type="text" id="documento" class="form-control mt-2" name="documentoUsuario">
                                        <label for="usuario" class="mt-2">Usuario</label>
                                        <input type="text" id="usuario" class="form-control mt-2" name="usuario">
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

        ?>

    </body>

    </html>

<?php

else :

    header("location: inicio.php");

endif;

?>