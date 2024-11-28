<?php
session_start();

if (empty($_SESSION['id_empleado'])) { // Si el id del usuario es vacío es porque está intentando ingresar sin iniciar sesión
    header("location: ../login.php");
}

include_once "../../../../procesos/config/conex.php"; // Incluye la conexión a la base de datos

// Consulta SQL para obtener los productos activos
$sql2 = "SELECT id_producto, id_categoria, referencia, nombre, descripcion, imagen, precio_unitario, cantidad_stock, estado, fecha_ingreso, fecha_sys 
         FROM inventario_productos WHERE estado = 1";

// Ejecutar la consulta
$stmt = $dbh->prepare($sql2);
$stmt->execute();
?>

<div class="container">
    <div class="table-responsive-md">
        <table id="tablaProductos" class="table table-hover table-condensed table-bordered display nowrap">
            <thead class="tabla-background">
                <tr>
                    <th class="text-center" scope="col">Referencia</th>
                    <th class="text-center" scope="col">Categoria</th>
                    <th class="text-center" scope="col">Nombre</th>
                    <th class="text-center" scope="col">Cantidad</th>
                    <th class="text-center" scope="col">Precio</th>
                    <th class="text-center" scope="col">Imagen</th>
                    <th class="text-center" scope="col">Descripcion</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar los datos de cada fila
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                ?>
                    <tr>
                        <td class="text-center" scope="row"><?php echo $row['referencia']; ?></td>
                        <td class="text-center">
                            <?php
                            // Consulta para obtener el nombre de la categoría
                            $estado = 1;
                            $catSql = "SELECT nombre_categoria FROM inventario_categorias WHERE id_categoria = :id_categoria AND estado = :estado";
                            $catStmt = $dbh->prepare($catSql);
                            $catStmt->bindParam(':id_categoria', $row['id_categoria']);
                            $catStmt->bindParam(':estado', $estado);
                            $catStmt->execute();
                            $catRow = $catStmt->fetch(PDO::FETCH_ASSOC);
                            echo $catRow['nombre_categoria']; // Mostrar el nombre de la categoría
                            ?>
                        </td>
                        <td class="text-center"><?php echo $row['nombre']; ?></td>
                        <td class="text-center"><?php echo $row['cantidad_stock']; ?></td>
                        <td class="text-center"><?php echo '$' . number_format($row['precio_unitario'], 0); ?></td>
                        <td class="text-center"><img src="../../<?php echo $row['imagen']; ?>" width="80px" height="80px" alt=""></td>
                        <td class="text-center"><?php echo $row['descripcion']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tablaProductos').DataTable({
            "order": [],
            "bSort": false,
            "lengthMenu": [5, 10, 20, 30],
            responsive: true,
            language: {
                "decimal": ",",
                "thousands": ".",
                "lengthMenu": "Mostrar _MENU_ registros",
                "info": "Total registros: _TOTAL_",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros en total)",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros",
                "emptyTable": "No hay datos disponibles en la tabla",
                "paginate": {
                    "first": "<<",
                    "previous": "<",
                    "next": ">",
                    "last": ">>"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
</script>