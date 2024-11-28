<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

// Realizar la consulta a la BD
$categorias = $dbh->query("SELECT id_categoria, nombre_categoria FROM inventario_categorias WHERE estado = 1 GROUP BY nombre_categoria ASC")->fetchAll();

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
                <div id="tabla_productos"></div>
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
                icon: 'success',
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
    <script>
        $(document).ready(function() {
            $('#tabla_productos').load('inventario/productos/tabla_productos.php');
        })
    </script>

</body>

</html>