<?php
include_once "../../procesos/config/conex.php";

if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $valCat = $_GET['valorCat'] ?? [];
    $busqueda = $_GET['buscadorProducto'];

    if (is_array($valCat) && !empty($valCat)) {
        // Verificar si el arreglo contiene el valor '0' (mostrar todos los productos)
        if (in_array(0, $valCat)) {
            // Mostrar todos los productos activos
            $sqlProducto = $dbh->query(" SELECT inv.id_producto, inv.id_categoria, inv.referencia, inv.nombre, inv.descripcion, inv.imagen, inv.precio_unitario, inv.cantidad_stock, inv.estado, inv.estadoProducto AS estado_producto, inv.fecha_ingreso, inv.fecha_sys, cat.estado AS estado_categoria FROM inventario_productos AS inv INNER JOIN inventario_categorias AS cat ON cat.id_categoria = inv.id_categoria WHERE inv.estadoProducto = 1 AND inv.estado = 1 AND cat.estado = 1 AND (inv.nombre LIKE '%$busqueda%') ORDER BY inv.nombre ASC")->fetchAll();
        } else {
            // Mostrar productos de las categorías seleccionadas
            $placeholders = implode(',', array_fill(0, count($valCat), '?'));
            $sql = "SELECT inv.id_producto, inv.id_categoria, inv.referencia, inv.nombre, inv.descripcion, inv.imagen, inv.precio_unitario, inv.cantidad_stock, inv.estado, inv.estadoProducto AS estado_producto, inv.fecha_ingreso, inv.fecha_sys, cat.estado AS estado_categoria FROM inventario_productos AS inv INNER JOIN inventario_categorias AS cat ON cat.id_categoria = inv.id_categoria WHERE inv.estadoProducto = 1 AND inv.estado = 1 AND cat.estado = 1 AND inv.id_categoria IN ($placeholders) AND (inv.nombre LIKE '%$busqueda%') ORDER BY inv.nombre ASC";
            $stmt = $dbh->prepare($sql);
            $stmt->execute($valCat);
            $sqlProducto = $stmt->fetchAll();
        }
    } else {
        // Si no hay categorías seleccionadas, mostrar todos los productos
        $sqlProducto = $dbh->query("SELECT inv.id_producto, inv.id_categoria, inv.referencia, inv.nombre, inv.descripcion, inv.imagen, inv.precio_unitario, inv.cantidad_stock, inv.estado, inv.estadoProducto AS estado_producto, inv.fecha_ingreso, inv.fecha_sys, cat.estado AS estado_categoria FROM inventario_productos AS inv INNER JOIN inventario_categorias AS cat ON cat.id_categoria = inv.id_categoria WHERE inv.estadoProducto = 1 AND inv.estado = 1 AND cat.estado = 1 AND (inv.nombre LIKE '%$busqueda%') ORDER BY inv.nombre ASC")->fetchAll();
    }
}
?>

<div class="row row-cols-1 row-cols-md-2 g-4">
    <?php foreach ($sqlProducto as $producto): ?>
        <div class="col-md-3 agregarProducto">
            <div class="product-card producto"
                data-id="<?php echo $producto['id_producto'] ?>"
                data-nombre="<?php echo $producto['nombre']; ?>"
                data-precio="<?php echo $producto['precio_unitario']; ?>">
                <div class="contenedorImagen d-flex justify-content-center">
                    <img src="../../<?php echo $producto['imagen'] ?>" class="card-img-top" alt="<?php echo $producto['nombre'] ?>">
                </div>
                <div class="card-body text-center mt-1">
                    <h5 class="fs-6"><?php echo $producto['nombre'] ?></h5>
                    <h5 class="fs-6">$<?php echo number_format($producto['precio_unitario'], 0, ',', '.') ?></h5>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>