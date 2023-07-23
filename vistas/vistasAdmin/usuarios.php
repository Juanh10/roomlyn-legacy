<?php

session_start();

if (empty($_SESSION['idUsuario'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

/* echo $_SESSION['idUsuario'];
echo $_SESSION['pNombre'];
echo $_SESSION['pApellido'];
echo $_SESSION['tipoUsuario']; */

?>

<?php

include_once "../../procesos/config/conex.php";

$sql = "SELECT usuarios.*, infousuarios.* FROM usuarios JOIN infousuarios ON usuarios.id_infoUsuario = infousuarios.id_infoUsuario WHERE 1";



?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "menuAdmin.php"; ?>
    <title>Usuarios</title>
</head>

<body>

    <div class="contenido">
        <div class="container">
            <a href="../registroUsuarios.php" class="btn btn-registrar mb-4">Registrar Usuario</a>

            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead class="table-dark">
                                <tr>
                                    <th scope="col">ID</th>
                                    <th scope="col">Primer Nombre</th>
                                    <th scope="col">Segundo Nombre</th>
                                    <th scope="col">Primer Apellido</th>
                                    <th scope="col">Segundo Apellido</th>
                                    <th scope="col">Documento</th>
                                    <th scope="col">Telefono</th>
                                    <th scope="col">Email</th>
                                    <th scope="col">Tipo</th>
                                    <th scope="col">Usuario</th>
                                    <th scope="col">Contraseña</th>
                                    <th scope="col">Editar</th>
                                    <th scope="col">Deshabilitar</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($dbh->query($sql) as $row) {

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
                                    $contraseña = $row['contraseña'];
                                    $estado = $row['estado'];
                                    if ($estado == 1) {
                                ?>

                                        <tr>
                                            <td><?php echo $id; ?></td>
                                            <td><?php echo $nombre1; ?></td>
                                            <td><?php echo $nombre2; ?></td>
                                            <td><?php echo $apellido1; ?></td>
                                            <td><?php echo $apellido2; ?></td>
                                            <td><?php echo $documento; ?></td>
                                            <td><?php echo $celular ?></td>
                                            <td><?php echo $email ?></td>
                                            <td><?php echo $tipoUsuario ?></td>
                                            <td><?php echo $usuario ?></td>
                                            <td><?php echo $contraseña ?></td>
                                            <td>
                                                <span class="btn btn-warning btn-sm editBtn" data-bs-toggle="modal" data-bs-target="#actualizarUsuarios">
                                                    <i class="bi bi-pencil-square"></i>
                                                </span>
                                            </td>
                                            <td>
                                                <form action="../../procesos/registroUsuario/conEliminarUsuario.php" method="post" class="formularioEliminar">
                                                    <input type="hidden" name="id_usuario" value="<?php echo $id ?> ">
                                                    <button type="submit" class="btn btn-danger btn-sm eliminarbtn">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                <?php
                                    }
                                }

                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- MODAL DE ACTUALIZAR -->
    <div class="modal fade" id="actualizarUsuarios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="../../procesos/registroUsuario/conActualizarUsuarios.php" method="post" id="frmCategorias">
                        <div class="mb-3">
                            <input type="hidden" name="id_usuario" id="id_actual">
                            <label for="exampleInputEmail1" class="form-label"> Primer Nombre: </label>
                            <input type="text" autocomplete="off" class="form-control" id="primerNombreUsuario" name="primerNombreUsuario" aria-describedby="emailHelp">
                            <label for="exampleInputEmail1" class="form-label"> Segundo Nombre: </label>
                            <input type="text" autocomplete="off" class="form-control" id="segundoNombreUsuario" name="segundoNombreUsuario" aria-describedby="emailHelp">
                            <label for="exampleInputEmail1" class="form-label">Primer Apellido: </label>
                            <input type="text" autocomplete="off" class="form-control" id="primerApellidoUsuario" name="primerApellidoUsuario" aria-describedby="emailHelp">
                            <label for="exampleInputEmail1" class="form-label">Segundo Apellido: </label>
                            <input type="text" autocomplete="off" class="form-control" id="segundoApellidoUsuario" name="segundoApellidoUsuario" aria-describedby="emailHelp">
                            <label for="exampleInputEmail1" class="form-label">Documento: </label>
                            <input type="text" autocomplete="off" class="form-control" id="documentoUsuario" name="documentoUsuario" aria-describedby="emailHelp">
                            <label for="exampleInputEmail1" class="form-label">Telefono: </label>
                            <input type="text" autocomplete="off" class="form-control" id="telefonoUsuario" name="telefonoUsuario" aria-describedby="emailHelp">
                            <label for="exampleInputEmail1" class="form-label">Email: </label>
                            <input type="text" autocomplete="off" class="form-control" id="emailUsuario" name="emailUsuario" aria-describedby="emailHelp">
                            <label for="exampleInputEmail1" class="form-label">Usuario: </label>
                            <input type="text" autocomplete="off" class="form-control" id="usuario" name="usuario" aria-describedby="emailHelp">
                            <label for="exampleInputEmail1" class="form-label">Contraseña: </label>
                            <input type="text" autocomplete="off" class="form-control" id="contraseña" name="contraseña" aria-describedby="emailHelp">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <input type="submit" class="btn btn-primary" value="Actualizar" name="btnAgregar" id="btnAgregar">
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>



    <!-- MENSAJES DE CONFIRMACION -->

    <?php

    if (isset($_SESSION['msjActualizado'])) {
    ?>

        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '<?php echo $_SESSION['msjActualizado']; ?>',
                showConfirmButton: false,
                timer: 1000
            });;
        </script>
    <?php
        unset($_SESSION['msjActualizado']);
    }

    if (isset($_SESSION['msjEliminar'])) {
        ?>
    
            <script>
                Swal.fire({
                    position: '',
                    icon: 'success',
                    title: '<?php echo $_SESSION['msjEliminar']; ?>',
                    showConfirmButton: false,
                    timer: 1000
                });;
            </script>
        <?php
            unset($_SESSION['msjEliminar']);
        }
        

    ?>

</body>

</html>