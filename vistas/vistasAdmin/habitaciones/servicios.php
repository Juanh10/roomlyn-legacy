<?php

include "../../../procesos/config/conex.php";

$sql = "SELECT id, elemento FROM habitaciones_elementos WHERE 1";

?>


<div class="row">
    <div class="col-sm-5 mt-3">
        <h3>Registrar servicios</h3>
        <div class="col-8">
            <form method="post" class="mt-4" action="../../procesos/registroHabitaciones/registroServicios/conRegistroServicios.php">
                <div class="mb-3">
                    <div class="form-floating">
                        <input type="text" name="servicio" id="floatingServicio" placeholder="Servicio" class="form-control" required>
                        <label for="floatingServicio" class="form-label">Servicio </label>
                    </div>
                    <input type="submit" class="btn btn-primary mt-4" value="Registrar">
                </div>
            </form>
        </div>
    </div>

    <div class="col-sm-6 mt-5">
        <div class="table-responsive m-2">
            <table class="table table-hover text-center">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Servicio</th>
                        <th>Editar</th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    foreach ($dbh->query($sql) as $row) {
                        $id = $row['id'];
                        $servicio = $row['elemento'];

                    ?>
                        <tr>
                            <td><?php echo $id; ?></td>
                            <td><?php echo $servicio; ?></td>
                            <td> <span class="btn btn-warning btn-sm editServiciosBtn" data-bs-toggle="modal" data-bs-target="#actualizarServicios">
                                    <i class="bi bi-pencil-square"></i>
                                </span>
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


 <!-- MODAL DE ACTUALIZAR -->
 <div class="modal fade" id="actualizarServicios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="../../procesos/registroHabitaciones/registroServicios/conActualizarServicios.php" method="post" id="frmCategorias">
                        <div class="mb-3">
                            <input type="hidden" name="id_actualServicio" id="id_actualServicio">
                            <label for="exampleInputEmail1" class="form-label"> Servicio: </label>
                            <input type="text" autocomplete="off" class="form-control" id="servicioAct" name="servicioAct" aria-describedby="emailHelp">
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
    
    <script src="../../js/scriptMenuAdmit.js"></script>