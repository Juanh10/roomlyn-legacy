<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sql = "SELECT clientes_registrados.id_cliente_registrado, clientes_registrados.estado, info_clientes.fecha_reg, info_clientes.id_info_cliente, info_clientes.documento, info_clientes.nombres, info_clientes.apellidos, info_clientes.celular, info_clientes.sexo, info_clientes.email, nacionalidades.nacionalidad, municipios.municipio
FROM clientes_registrados INNER JOIN info_clientes ON clientes_registrados.id_info_cliente = info_clientes.id_info_cliente INNER JOIN nacionalidades ON info_clientes.id_nacionalidad = nacionalidades.id_nacionalidad INNER JOIN municipios ON info_clientes.id_municipio = municipios.id_municipio WHERE 1";

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "menuAdmin.php"; ?>
    <title>Clientes</title>
</head>

<body class="fondo">

    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>CLIENTES REGISTRADOS</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>


    <div class="contenido">
        <div class="container" id="contenedorPrincipalCli">
            <div class="row">
            <div class="filtrarFechas">
                <button class="btn botonFiltrarFecha mb-3" id="btnFiltrar" data-bs-toggle="modal" data-bs-target="#modalFiltrarFecha">Filtrar por fecha</button>
            </div>
                <div class="col">
                    <div class="table-responsive tabla-clientes">
                        <table class="table table-hover table-borderless text-center" id="tablaClientes">
                            <thead class="tabla-background">
                                <tr>
                                    <th>#</th>
                                    <th>Nombres</th>
                                    <th>Documento</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Nacionalidad</th>
                                    <th>Municipio</th>
                                    <th>Fecha registro</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php

                                foreach ($dbh->query($sql) as $row) :

                                    $id = $row['id_cliente_registrado'];
                                    $nombres = $row['nombres'];
                                    $apellidos = $row['apellidos'];
                                    $documento = $row['documento'];
                                    $sexo = $row['sexo'];
                                    $email = $row['email'];
                                    $celular = $row['celular'];
                                    $nacionalidad = $row['nacionalidad'];
                                    $municipio = $row['municipio'];
                                    $fechaReg = $row['fecha_reg'];
                                    $estado = $row['estado'];

                                    if ($estado == 1) :

                                ?>

                                        <tr class="filas filasUsuario">
                                            <td class="datos"><?php echo $id ?></td>
                                            <td class="datos"><?php echo $nombres . " " . $apellidos ?></td>
                                            <td class="datos"><?php echo $documento ?></td>
                                            <td class="datos"><?php echo $celular ?></td>
                                            <td class="datos"><?php echo $email ?></td>
                                            <td class="datos"><?php echo $nacionalidad ?></td>
                                            <td class="datos"><?php echo $municipio ?></td>
                                            <td class="datos"><?php echo $fechaReg ?></td>
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
                    </div>
                </div>
            </div>
        </div>
        <div id="contenedorFiltroCli"></div>
    </div>

    <!-- MODAL -->

    <div class="modal fade" id="modalFiltrarFecha" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Filtrar por fecha</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formFiltrarFecha">
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="fechaInicio" placeholder="Fecha Inicio" required>
                            <label for="fechaInicio">Fecha inicio</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="date" class="form-control" id="fechaFinal" placeholder="Fecha Inicio" required>
                            <label for="fechaFinal">Fecha final</label>
                        </div>

                        <div class="d-flex justify-content-center align-items-center">
                            <button type="button" class="btn boton-guardar" id="filtroBtnFechaCli">Filtrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- PIE DE PAGINA -->
    <footer class="pie-de-pagina">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>

</body>

</html>