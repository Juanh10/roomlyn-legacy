<?php
session_start();

if (empty($_SESSION['id_empleado'])) {
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

// Consulta para obtener las ventas
$sql1 = "
    SELECT 
        iv.id_venta, 
        iv.id_empleado, 
        iv.id_reserva, 
        iv.id_punto_venta, 
        iv.total_venta, 
        iv.hora_venta, 
        iv.fecha_venta, 
        ie.pNombre, 
        ie.pApellido,
        cli.nombres,
        cli.apellidos
    FROM inventario_ventas as iv
    INNER JOIN empleados as emp ON iv.id_empleado = emp.id_empleado
    INNER JOIN info_empleados as ie ON emp.id_info_empleado = ie.id_info_empleado
    INNER JOIN reservas as r ON iv.id_reserva = r.id_reserva
    INNER JOIN info_clientes as cli ON r.id_cliente = cli.id_info_cliente
    WHERE iv.estado = 1
    ORDER BY iv.fecha_venta DESC, iv.hora_venta DESC
";

$stmt1 = $dbh->prepare($sql1);
$stmt1->execute();
$ventas = $stmt1->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <?php require_once "menuAdmin.php"; ?>
</head>

<body>
    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>SALIDAS</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <div class="contenido">
        <div class="row mx-0">
            <div class="col">
                <div class="table-responsive-md mb-5 mt-4">
                    <table id="tablaSalidas" class="table table-condensed display nowrap">
                        <thead class="tabla-background">
                            <tr>
                                <th class="text-center">Referencia</th>
                                <th class="text-center">Empleado</th>
                                <th class="text-center">Cliente</th>
                                <th class="text-center">Total Venta</th>
                                <th class="text-center">Fecha de Venta</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($ventas as $venta) : ?>
                                <tr>
                                    <td class="details-control text-center fw-bold" data-id="<?php echo $venta['id_venta']; ?>" id="detallesVenta"><i class="bi bi-caret-down-fill arrow-down"></i> <?php echo $venta['id_venta']; ?></td>
                                    <td class="text-center"><?php echo $venta['pNombre'] . " " . $venta['pApellido']; ?></td>
                                    <td class="text-center"><?php echo $venta['nombres'] . " " . $venta['apellidos']; ?></td>
                                    <td class="text-center"><?php echo $venta['total_venta']; ?></td>
                                    <td class="text-center"><?php echo $venta['fecha_venta']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/scriptInventario.js"></script>

</body>

</html>