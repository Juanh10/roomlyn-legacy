<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

// Realizar la consulta a la BD
$categorias = $dbh->query("SELECT id_categoria, nombre_categoria FROM inventario_categorias WHERE estado = 1 GROUP BY nombre_categoria ASC")->fetchAll();

// Consulta SQL para obtener los productos activos
$sql2 = "SELECT ie.id, ie.id_empleado, ie.id_producto, ie.cantidad, ie.precio_unitario, ie.estado, ie.fecha_sys, info.pNombre, info.pApellido, pro.referencia, pro.nombre FROM inventario_entradas AS ie INNER JOIN empleados AS emp ON ie.id_empleado = emp.id_empleado INNER JOIN info_empleados info ON emp.id_info_empleado = info.id_info_empleado INNER JOIN inventario_productos as pro ON ie.id_producto = pro.id_producto WHERE ie.estado = 1 AND pro.estado = 1 ORDER BY ie.fecha_sys DESC";

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
            <span>ENTRADAS</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <div class="contenido">
        <div class="row mx-0">
            <div class="col">
                <div class="table-responsive-md mb-5 mt-4">
                    <table id="tablaEntradas" class="table table-condensed display nowrap">
                        <thead class="tabla-background">
                            <tr>
                                <th class="text-center" scope="col">Usuario</th>
                                <th class="text-center" scope="col">Referencia</th>
                                <th class="text-center" scope="col">Producto</th>
                                <th class="text-center" scope="col">Cantidad</th>
                                <th class="text-center" scope="col">Precio unitario</th>
                                <th class="text-center" scope="col">Total</th>
                                <th class="text-center" scope="col">Fecha de registro</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Mostrar los datos de cada fila
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                <tr>
                                    <td class="text-center" scope="row"><?php echo $row['pNombre'] . " " . $row['pApellido']; ?></td>
                                    <td class="text-center"><?php echo $row['referencia']; ?></td>
                                    <td class="text-center"><?php echo $row['nombre']; ?></td>
                                    <td class="text-center"><?php echo $row['cantidad']; ?></td>
                                    <td class="text-center"><?php echo number_format($row['precio_unitario'],0,',','.'); ?></td>
                                    <td class="text-center"><?php echo number_format($row['precio_unitario'] * $row['cantidad'],0,',','.'); ?></td>
                                    <td class="text-center"><?php echo $row['fecha_sys']; ?></td>
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

    <!-- PIE DE PAGINA -->
    <footer class="pie-de-pagina">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>

    
    <script src="../../js/scriptInventario.js"></script>

</body>

</html>