<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sql = "SELECT id_hab_tipo, tipoHabitacion FROM habitaciones_tipos WHERE 1 AND estado = 1"; //consulta para el modal de añadir habitaciones

$sql2 = "SELECT habitaciones.id_habitacion, habitaciones.id_servicio, habitaciones.nHabitacion, habitaciones_tipos.tipoHabitacion, habitaciones.tipoCama, habitaciones.cantidadPersonasHab, habitaciones.observacion, habitaciones.estado, habitaciones_estado.estado_habitacion FROM habitaciones INNER JOIN habitaciones_tipos ON habitaciones.id_hab_tipo = habitaciones_tipos.id_hab_tipo INNER JOIN habitaciones_estado ON habitaciones.id_hab_estado = habitaciones_estado.id_hab_estado WHERE habitaciones.estado = 1 ORDER BY habitaciones.id_habitacion"; // consulta para mostrar todos los datos relacionados con las habitacione.

// CONSULTA DE CATEGORIAS A LA BD

$sqlCategorias = $dbh->prepare("SELECT id_categoria, nombre_categoria, estado, fecha_sys FROM inventario_categorias WHERE 1");
$sqlCategorias->execute();

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
            <span>GESTIONAR CATEGORIAS</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <div class="contenido">
        <div class="row m-0 d-flex justify-content-center mt-5">
            <div class="col-md-3 me-5">
                <!-- AGREGAR CATEGORIAS -->
                <form id="formularioCategorias" class="d-grid gap-2">
                    <label for="categoria" class="mb-1">Nombre de la categoria*</label>
                    <input type="text" class="form-control justify-self-center" style="max-width: 300px;" name="categoria" id="categoria">
                    <p class="errorValidacion">Completa este campo</p>
                    <button class="btn fw-bold mt-2 justify-self-center botonRoomlyn">Agregar</button>
                </form>
                <!-- EDITAR CATEGORIAS -->
                <form id="formularioEditCategorias" class="d-grid gap-2 d-none">
                    <span class="btnVolverHab">
                        < Volver</span>
                            <label for="editcategoria" class="mb-1">Nombre de la categoria*</label>
                            <input type="text" class="form-control justify-self-center" style="max-width: 300px;" name="editcategoria" id="editcategoria">
                            <p class="errorValidacion">Completa este campo</p>
                            <button class="btn fw-bold mt-2 justify-self-center botonRoomlyn">Editar</button>
                </form>
            </div>
            <div class="col-md-5">
                <table class="table text-center" id="tablaCategorias" border="1">
                    <thead class="tabla-background">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Categoría</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Obtener todos los resultados en un array 
                        $categorias = $sqlCategorias->fetchAll(PDO::FETCH_ASSOC);
                        foreach ($categorias as $categoria):
                            $id = $categoria['id_categoria'];
                            $NombreCategoria = $categoria['nombre_categoria'];
                            $estadoCategoria = $categoria['estado'];
                            if ($estadoCategoria == 1):
                        ?>
                                <tr>
                                    <td class="text-center"><?php echo $id ?></td>
                                    <td class="text-center"><?php echo $NombreCategoria ?></td>
                                    <td class="d-flex justify-content-center">
                                        <div class="accion">
                                            <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar btnEditarCategoria" data-id="<?php echo $id ?>" title="Editar"></span>
                                            <form class="formEliminarCategoria">
                                                <input type="hidden" name="id_usuario" value="<?php echo $id ?>">
                                                <button type="submit" class="btn btn-danger btn-sm eliminarbtn" title="Deshabilitar">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            endif;
                        endforeach;
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="../../js/scriptInventario.js"></script>

</body>

</html>