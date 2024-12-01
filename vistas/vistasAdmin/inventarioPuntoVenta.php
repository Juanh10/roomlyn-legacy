<?php
session_start();

if (empty($_SESSION['id_caja'])) { //* Si el id de la caja es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: inicio.php");
}

include_once "../../procesos/config/conex.php";

$sqlHab = $dbh->query("SELECT hb.id_habitacion, hb.id_hab_tipo, hb.id_hab_estado, hb.nHabitacion, hb.tipoCama, hb.cantidadPersonasHab, hb.estado, hbt.tipoHabitacion, hbe.estado_habitacion, hbs.servicio, hbe.estado_habitacion FROM habitaciones AS hb INNER JOIN habitaciones_tipos AS hbt ON hbt.id_hab_tipo = hb.id_hab_tipo INNER JOIN habitaciones_estado AS hbe ON hbe.id_hab_estado = hb.id_hab_estado INNER JOIN habitaciones_servicios hbs ON hbs.id_servicio = hb.id_servicio  WHERE hb.estado = 1 ORDER BY hb.nHabitacion ASC")->fetchAll();

// Consulta SQL para obtener los productos activos
$sqlProducto = $dbh->query("SELECT inv.id_producto, inv.id_categoria, inv.referencia, inv.nombre, inv.descripcion, inv.imagen, inv.precio_unitario, inv.cantidad_stock, inv.estado, inv.estadoProducto AS estado_producto, inv.fecha_ingreso, inv.fecha_sys, cat.estado AS estado_categoria FROM inventario_productos AS inv INNER JOIN inventario_categorias AS cat ON cat.id_categoria = inv.id_categoria WHERE inv.estadoProducto = 1 AND inv.estado = 1 AND cat.estado = 1")->fetchAll();

$sqlCategorias = $dbh->query("SELECT id_categoria, nombre_categoria FROM inventario_categorias WHERE estado = 1")->fetchAll();

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja Abierta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="icon" href="../../iconos/logo_icono.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />
    <link rel="stylesheet" href="../../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../librerias/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../librerias/sweetAlert2/css/sweetalert2.min.css">
    <link rel="stylesheet" href="../../librerias/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../../css/estilosMenuAdmin.css">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <link rel="stylesheet" href="../../css/estilosReservasAdmin.css">
    <link rel="stylesheet" href="../../css/estilosPuntoVenta.css">
</head>

<body>
    <!--* CABECERA DEL MENU  -->

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #86726b;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-bold active" aria-current="page" href="#"><?php echo $_SESSION['nombre_caja'] ?></a>
                    </li>
                </ul>
                <div class="ms-auto d-flex justify-content-center ">
                    <span class="navbar-text">
                        <form id="formCerrarSesionCaja">
                            <input type="hidden" name="id" value="<?php echo $_SESSION['id_caja'] ?>">
                            <input type="submit" class="btn btn-secondary" value="Cerrar caja">
                        </form>
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid my-4 mt-5 pt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="input-group mb-3">
                    <input type="text" id="buscadorProducto" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2">
                </div>

                <div class="input-group mb-3">
                    <label for="filtroCategoria" class="mb-2 text-body-tertiary fw-bold">Filtrar por categoria</label>
                    <select id="filtroCategoria" name="states[]" multiple="multiple">
                        <option value="0" selected>Todos</option>
                        <?php
                        foreach ($sqlCategorias as $categoria):
                        ?>
                            <option value="<?php echo $categoria['id_categoria'] ?>"><?php echo $categoria['nombre_categoria'] ?></option>
                        <?php
                        endforeach;
                        ?>
                    </select>
                </div>
                <div id="contenedorProductos"></div>
            </div>
            <div class="col-md-4">
                <div class="cart-item mb-3">
                    <div class="tipoCliente">
                        <select id="tipoCliente" class="form-select mb-3">
                            <option selected disabled>Destinatario de la venta</option>
                            <option value="0">Público general</option>
                            <?php foreach ($sqlHab as $habitacion): ?>
                                <option value="<?php echo $habitacion['id_habitacion']; ?>">
                                    <?php echo 'Habitación ' . $habitacion['nHabitacion']; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <h5 class="mb-3">Factura</h5>
                    <div id="listaFactura"></div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total a pagar</strong>
                        <strong id="totalFactura">$0</strong>
                    </div>
                    <button id="generarVenta" class="btn btn-success w-100 mt-3">Generar venta</button>
                </div>

            </div>
        </div>
    </div>

    <script src="../../librerias/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <script src="../../librerias/bootstrap5/js/bootstrap.min.js"></script>
    <script src="../../librerias/sweetAlert2/js/sweetalert2.all.min.js"></script>
    <script src="../../librerias/datatables/js/datatables.min.js"></script>
    <script src="../../librerias/select2/dist/js/select2.min.js"></script>
    <script src="../../js/logoBase64Roomlyn.js"></script>
    <script src="../../js/driver.js"></script>
    <script src="../../js/scriptInventario.js"></script>
    <script src="../../js/scriptPuntoVenta.js"></script>
</body>

</html>