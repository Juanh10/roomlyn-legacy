<?php
include_once "../../procesos/config/conex.php";

if (isset($_POST['id_venta'])) {
    $idVenta = $_POST['id_venta'];
    $sql2 = "
        SELECT 
            dv.id_producto, 
            dv.cantidad_producto, 
            dv.precio_unitario, 
            dv.precio_total, 
            p.nombre AS producto_nombre, 
            p.referencia AS producto_referencia
        FROM inventario_detalles_ventas dv
        INNER JOIN inventario_productos p ON dv.id_producto = p.id_producto
        WHERE dv.id_venta = :id_venta
    ";

    $stmt2 = $dbh->prepare($sql2);
    $stmt2->bindParam(':id_venta', $idVenta, PDO::PARAM_INT);
    $stmt2->execute();

    echo json_encode($stmt2->fetchAll(PDO::FETCH_ASSOC));
}
?>