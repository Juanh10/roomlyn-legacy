<?php

include "../../../procesos/config/conex.php";

$sql = "SELECT id, elemento FROM habitaciones_elementos WHERE 1";
$sql2 = "SELECT id, tipoHabitacion, cantidadCamas, imagen FROM habitaciones_tipos WHERE 1";

?>


<button class="btn btn-primary mb-4 mt-4" data-bs-toggle="modal" data-bs-target="#registrarTipoHabitacion">Registrar</button>

<div class="row">
    <div class="col">
        <div class="table-responsive">
            <table class="table table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tipo</th>
                        <th>Cantidad camas</th>
                        <th>Imagen</th>
                        <th>Editar</th>
                        <th>Deshabilitar</th>
                    </tr>
                <tbody>
                    <?php
                    foreach ($dbh->query($sql2) as $row) {

                        $id = $row['id'];
                        $tipoHabitacion = $row['tipoHabitacion'];
                        $cantidadCamas = $row['cantidadCamas'];
                        $imagen = $row['imagen'];

                    ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $tipoHabitacion; ?></td>
                            <td><?php echo $cantidadCamas; ?></td>
                            <td><?php echo $imagen; ?></td>
                            <td> <span class="btn btn-warning btn-sm editServiciosBtn" data-bs-toggle="modal" data-bs-target="#actualizarServicios">
                                    <i class="bi bi-pencil-square"></i>
                                </span>
                            </td>
                            <td>
                                <form action="" method="post" class="formularioEliminar">
                                    <input type="hidden" name="id_usuario" value="<?php echo $id ?> ">
                                    <button type="submit" class="btn btn-danger btn-sm eliminarbtn">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    <?php

                    }

                    ?>


                </tbody>
                </thead>
            </table>
        </div>
    </div>
</div>


<!-- MODAL DE REGISTRAR TIPO DE HABITACIONES -->
<div class="modal fade" id="registrarTipoHabitacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Editar</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form action="../../procesos/registroHabitaciones/registroTipos/conRegistroTipos.php" method="post" id="frmCategorias">
                    <div class="mb-3">

                        <div class="form-floating">
                            <input type="text" name="tipoHabitacion" id="tipoHabitacion" placeholder="Tipo de habitacion" class="form-control" required>
                            <label for="tipoHabitacion" class="form-label">Tipo de Habitacion</label>
                        </div>

                        <div class="form-floating mt-4">
                            <input type="number" name="cantiCama" id="cantiCama" placeholder="Cantidad de camas" class="form-control" min="0" required>
                            <label for="cantiCama" class="form-label">Cantidad de camas</label>
                        </div>

                        <div class="mt-4">
                            <label for="imagen" class="form-label">Foto</label>
                            <input type="file" name="imagen" id="imagen" placeholder="Cantidad de camas" class="form-control" min="0">
                        </div>

                        <div class="mt-4">
                            <label for="" class="form-label">Servicios</label>
                            <select name="opcioneServicios[]" class="form-select" multiple aria-label="multiple select example" required>
                                <option selected disabled>Seleccione varios servicios</option>
                                <?php
                                foreach ($dbh->query($sql) as $row) {
                                    $idServicio = $row['id'];
                                    $servicio = $row['elemento'];

                                ?>
                                    <option value="<?php echo $idServicio ?>"><?php echo $servicio ?></option>
                                <?php
                                }

                                ?>
                            </select>
                        </div>

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