<?php

include_once "../../procesos/config/conex.php";
include_once "../../procesos/funciones/formatearFechas.php";

$fechaInicio = $_POST['fechaInicial'];
$fechaFin = $_POST['fechaFinal'];

$sql = "SELECT clientes_registrados.id_cliente_registrado, clientes_registrados.estado, info_clientes.fecha_reg, info_clientes.id_info_cliente, info_clientes.documento, info_clientes.nombres, info_clientes.apellidos, info_clientes.celular, info_clientes.sexo, info_clientes.email, nacionalidades.nacionalidad, municipios.municipio
FROM clientes_registrados INNER JOIN info_clientes ON clientes_registrados.id_info_cliente = info_clientes.id_info_cliente INNER JOIN nacionalidades ON info_clientes.id_nacionalidad = nacionalidades.id_nacionalidad INNER JOIN municipios ON info_clientes.id_municipio = municipios.id_municipio WHERE info_clientes.fecha_reg BETWEEN '" . $fechaInicio . "' AND '" . $fechaFin . "' ORDER BY clientes_registrados.id_cliente_registrado ASC";

$resultCons = $dbh->query($sql);

?>

<div class="btnVolverFiltro mx-4">
    <span>
        < Volver</span>
</div>

<?php

if ($resultCons->rowCount() > 0) :
?>
    <div class="container">
        <div class="row">
            <div class="filtrarFechas">
                <button class="btn botonFiltrarFecha mb-3" id="btnFiltrar" data-bs-toggle="modal" data-bs-target="#modalFiltrarFecha">Filtrar por fecha</button>
            </div>
            <div class="col">
                <div class="table-responsive tabla-clientes">
                    <table class="table table-hover table-borderless text-center" id="tablaClientesFiltro" aria-label="Clientes">
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
                                        <td class="datos"><?php echo formatearFecha($fechaReg) ?></td>
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
<?php
else :

?>

    <span class="mx-4">No hay registros</span>

<?php

endif;

?>

<script src="../../js/scriptDataTablesFiltro.js"></script>
<script>
    $('.btnVolverFiltro').click(function() {
        location.reload();
    });
</script>