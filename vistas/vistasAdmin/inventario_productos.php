<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

// Realizar la consulta a la BD
$categorias = $dbh->query("SELECT id_categoria, nombre_categoria FROM inventario_categorias WHERE estado = 1 GROUP BY nombre_categoria ASC")->fetchAll();

// Consulta SQL para obtener los productos activos
$sql2 = "SELECT inv.id_producto, inv.id_categoria, inv.referencia, inv.nombre, inv.descripcion, inv.imagen, inv.precio_unitario, inv.cantidad_stock, inv.estadoProducto, inv.estado AS estado_producto, inv.fecha_ingreso, inv.fecha_sys, cat.estado AS estado_categoria FROM inventario_productos AS inv INNER JOIN inventario_categorias AS cat ON cat.id_categoria = inv.id_categoria WHERE inv.estado = 1 AND cat.estado = 1";

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
            <span>GESTIONAR PRODUCTOS</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <div class="contenido">
        <div class="row mx-0">
            <div class="col">
                <div class="btnAdd mt-4 ms-5 mb-4">
                    <button type="button" class="btn botonRoomlyn fw-bold" data-bs-toggle="modal" data-bs-target="#agregar">
                        Agregar
                    </button>
                </div>
                <div class="table-responsive-md">
                    <table id="tablaProductos" class="table table-condensed display nowrap">
                        <thead class="tabla-background">
                            <tr>
                                <th class="text-center" scope="col">Referencia</th>
                                <th class="text-center" scope="col">Categoria</th>
                                <th class="text-center" scope="col">Nombre</th>
                                <th class="text-center" scope="col">Cantidad</th>
                                <th class="text-center" scope="col">Precio</th>
                                <th class="text-center" scope="col">Imagen</th>
                                <th class="text-center" scope="col">Descripcion</th>
                                <th class="text-center" scope="col">Estado</th>
                                <th class="text-center" scope="col">Acción</th>
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
                                        $estado = 1;
                                        $catSql = "SELECT nombre_categoria FROM inventario_categorias WHERE id_categoria = :id_categoria AND estado = :estado";
                                        $catStmt = $dbh->prepare($catSql);
                                        $catStmt->bindParam(':id_categoria', $row['id_categoria']);
                                        $catStmt->bindParam(':estado', $estado);
                                        $catStmt->execute();
                                        $catRow = $catStmt->fetch(PDO::FETCH_ASSOC);
                                        echo $catRow['nombre_categoria'];
                                        ?>
                                    </td>
                                    <td class="text-center"><?php echo $row['nombre']; ?></td>
                                    <td class="text-center"><?php echo $row['cantidad_stock']; ?></td>
                                    <td class="text-center"><?php echo '$' . number_format($row['precio_unitario'], 0); ?></td>
                                    <td class="text-center"><img src="../../<?php echo $row['imagen']; ?>" width="80px" height="80px" alt=""></td>
                                    <td class="text-center"><?php echo $row['descripcion']; ?></td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <label class="switch">
                                                <input type="checkbox" class="estadoToggle" data-id="<?php echo $row['id_producto']; ?>" <?php echo $row['estadoProducto'] == 1 ? 'checked' : ''; ?>>
                                                <span class="slider"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="accion d-flex justify-content-center">
                                            <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar btnEditarCategoria" data-id="<?php echo $row['id_producto'] ?>" data-bs-toggle="modal" data-bs-target="#modalEditProducto" title="Editar"></span>
                                            <form action="../../procesos/inventario/productos/conProductos.php" method="post" id="formEliminarProducto_<?php echo $row['id_producto']; ?>" class="formEliminarProducto">
                                                <input type="hidden" name="id_producto" value="<?php echo $row['id_producto'] ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="button" class="btn btn-danger btn-sm eliminarbtn" title="Deshabilitar" data-id="<?php echo $row['id_producto']; ?>">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>

                                        </div>
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
    </div>


    <!-- Modal agregar productos-->
    <div class="modal fade" id="agregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formularioProducto" action="../../procesos/inventario/productos/conProductos.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="action" value="insert">
                        <div class="mb-3">
                            <select id="categoria_cat" name="categoria_cat" class="form-select" aria-label="Default select example" required>
                                <option disabled selected>Seleccione la categoria*</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['id_categoria'] ?>"><?php echo $categoria['nombre_categoria'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="referencia_cat" name="referencia_cat" placeholder="REV0230" required>
                            <label for="referencia_cat">Referencia*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombre_cat" name="nombre_cat" placeholder="Gaseosas" required>
                            <label for="nombre_cat">Nombre del producto*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="imagen_cat" name="imagen_cat" placeholder="Imagen del producto">
                            <label for="imagen_cat">Imagen del producto</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="cantidad_cat" name="cantidad_cat" placeholder="9" required>
                            <label for="cantidad_cat">Cantidad en stock*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="precio_cat" name="precio_cat" placeholder="4000" required>
                            <label for="precio_cat">Precio unitario*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea type="textarea" class="form-control" id="descripcion_cat" name="descripcion_cat"></textarea>
                            <label for="descripcion_cat">Descripción del producto</label>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Agregar" class="btn botonRoomlyn fw-bold">
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal editar productos-->
    <div class="modal fade" id="modalEditProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar producto</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formularioProductoEdit" action="../../procesos/inventario/productos/conProductos.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="id_producto" id="id_producto">
                        <input type="hidden" name="action" value="update">
                        <div class="mb-3">
                            <select id="categoria_catEdit" name="categoria_catEdit" class="form-select" aria-label="Default select example" required>
                                <option disabled selected>Seleccione la categoria*</option>
                                <?php foreach ($categorias as $categoria): ?>
                                    <option value="<?php echo $categoria['id_categoria'] ?>"><?php echo $categoria['nombre_categoria'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="referencia_catEdit" name="referencia_catEdit" placeholder="REV0230" required>
                            <label for="referencia_cat">Referencia*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nombre_catEdit" name="nombre_catEdit" placeholder="Gaseosas" required>
                            <label for="nombre_cat">Nombre del producto*</label>
                            <p></p>
                        </div>


                        <div class="form-floating mb-3">
                            <input type="file" class="form-control" id="imagen_catEdit" name="imagen_catEdit" placeholder="Imagen del producto">
                            <label for="imagen_cat">Imagen del producto</label>
                            <p></p>
                        </div>

                        <div class="mb-3 ms-2">
                            <p>Imagen actual</p>
                            <img id="imagenPreview" src="" alt="Imagen del producto" class="img-fluid mb-2" style="max-width: 100px; display: none;">
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="cantidad_catEdit" name="cantidad_catEdit" placeholder="9" required>
                            <label for="cantidad_cat">Cantidad en stock*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <input type="number" class="form-control" id="precio_catEdit" name="precio_catEdit" placeholder="4000" required>
                            <label for="precio_cat">Precio unitario*</label>
                            <p></p>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea type="textarea" class="form-control" id="descripcion_catEdit" name="descripcion_catEdit"></textarea>
                            <label for="descripcion_cat">Descripción del producto</label>
                        </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" value="Editar" class="btn botonRoomlyn fw-bold">
                </div>
                </form>
            </div>
        </div>
    </div>



    <?php

    if (isset($_SESSION['msjExito'])) :
    ?>
        <script>
            // Mostrar alerta de éxito
            Swal.fire({
                icon: 'success',
                title: 'Operación exitosa',
                text: '<?php echo $_SESSION['msjExito'] ?>.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    <?php
        unset($_SESSION['msjExito']);
    endif;

    if (isset($_SESSION['msjError'])) :
    ?>
        <script>
            // Mostrar alerta de éxito
            Swal.fire({
                icon: 'error',
                title: 'Error en la operación',
                text: '<?php echo $_SESSION['msjError'] ?>.',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        </script>
    <?php
        unset($_SESSION['msjError']);
    endif;

    ?>

    <script src="../../js/scriptInventario.js"></script>

</body>

</html>