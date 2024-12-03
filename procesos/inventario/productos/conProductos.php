<?php

// Incluir la configuración de conexión y establecer la zona horaria
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");

session_start();

$idEmpleado = $_SESSION['id_empleado'];

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_POST['action'])) {
        $action = $_POST['action'];

        if ($action === "insert") {
            // Validar los campos recibidos
            if (isset($_POST['categoria_cat']) && isset($_POST['referencia_cat']) && isset($_POST['nombre_cat']) && isset($_POST['cantidad_cat']) &&         isset($_POST['precio_cat'])) {
                // Obtener datos del formulario
                $categoria = $_POST['categoria_cat'];
                $referencia = $_POST['referencia_cat'];
                $nombre = $_POST['nombre_cat'];
                $cantidad = $_POST['cantidad_cat'];
                $precio = $_POST['precio_cat'];
                $descripcion = $_POST['descripcion_cat'] ?? null;
                $fechaActual = new DateTime();
                $fecha = $fechaActual->format('Y-m-d');
                $fechaYHora = $fechaActual->format('Y-m-d H:i:s');

                // Manejo de imagen
                $imagen = $_FILES['imagen_cat'];
                $rutaImagen = "img/notimages.png"; // Ruta de imagen predeterminada

                if (!empty($imagen['name'])) {
                    // Validar y mover la imagen cargada
                    $directorioDestino = "imgServidor";
                    $nombreImagen = uniqid() . "_" . basename($imagen['name']);
                    $rutaCompleta = $directorioDestino . '/' . $nombreImagen;
                    $rutaCompletaGuardar = "../../../" . $directorioDestino . '/' . $nombreImagen;

                    // Extensiones permitidas
                    $extensionesValidas = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'ico'];
                    $extension = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));

                    if (in_array($extension, $extensionesValidas)) {
                        if (move_uploaded_file($imagen['tmp_name'], $rutaCompletaGuardar)) {
                            $rutaImagen = $rutaCompleta; // Usar la ruta de la imagen subida
                        } else {
                            $_SESSION['msjError'] = "Error al subir la imagen.";
                            header("location: ../../../vistas/vistasAdmin/inventario_productos.php");

                            exit;
                        }
                    } else {
                        $_SESSION['msjError'] = "Formato de imagen no válido.";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");

                        exit;
                    }
                }

                // Insertar en la base de datos
                try {
                    $sqlInsertProd = $dbh->prepare("INSERT INTO inventario_productos(id_categoria, referencia, nombre, descripcion, imagen, precio_unitario, cantidad_stock, estado, fecha_ingreso, fecha_sys) VALUES (:idCat, :ref, :nom, :descr, :img, :prec, :cant, :est, :fecIng, :fecSys)");

                    $sqlInsertProd->bindParam(':idCat', $categoria);
                    $sqlInsertProd->bindParam(':ref', $referencia);
                    $sqlInsertProd->bindParam(':nom', $nombre);
                    $sqlInsertProd->bindParam(':descr', $descripcion);
                    $sqlInsertProd->bindParam(':img', $rutaImagen);
                    $sqlInsertProd->bindParam(':prec', $precio);
                    $sqlInsertProd->bindParam(':cant', $cantidad);
                    $estado = 1; // Estado activo
                    $sqlInsertProd->bindParam(':est', $estado);
                    $sqlInsertProd->bindParam(':fecIng', $fecha);
                    $sqlInsertProd->bindParam(':fecSys', $fechaYHora);

                    if ($sqlInsertProd->execute()) {
                        $_SESSION['msjExito'] = "Producto registrado exitosamente.";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                        exit;
                    } else {
                        $_SESSION['msjError'] = "Error al registrar el producto.";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");

                        exit;
                    }
                } catch (PDOException $e) {
                    $_SESSION['msjError'] = "Error de base de datos: " . $e->getMessage();
                    header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                    exit;
                }
            } else {
                // Mensaje de error si faltan campos
                $_SESSION['msjError'] = "Campos vacíos. Por favor, llena los campos requeridos.";
                header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                exit;
            }
        } else if ($action === "update") {
            // EDITAR PRODUCTO
            if (
                isset($_POST['id_producto']) && isset($_POST['categoria_catEdit']) && isset($_POST['referencia_catEdit']) &&
                isset($_POST['nombre_catEdit']) && isset($_POST['cantidad_catEdit']) && isset($_POST['precio_catEdit'])
            ) {

                $idProducto = $_POST['id_producto'];
                $categoria = $_POST['categoria_catEdit'];
                $referencia = $_POST['referencia_catEdit'];
                $nombre = $_POST['nombre_catEdit'];
                $cantidad = $_POST['cantidad_catEdit'];
                $precio = $_POST['precio_catEdit'];
                $descripcion = $_POST['descripcion_catEdit'] ?? null;
                $fechaYHora = (new DateTime())->format('Y-m-d H:i:s');

                // Manejo de imagen
                $rutaImagen = null; // Ruta predeterminada si no se sube imagen
                if (!empty($_FILES['imagen_catEdit']['name'])) {
                    $imagen = $_FILES['imagen_catEdit'];
                    $directorioDestino = "imgServidor";
                    $nombreImagen = uniqid() . "_" . basename($imagen['name']);
                    $rutaCompleta = $directorioDestino . '/' . $nombreImagen;
                    $rutaCompletaGuardar = "../../../" . $directorioDestino . '/' . $nombreImagen;

                    // Validar extensión
                    $extensionesValidas = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'webp', 'svg', 'ico'];
                    $extension = strtolower(pathinfo($nombreImagen, PATHINFO_EXTENSION));

                    if (in_array($extension, $extensionesValidas)) {
                        if (move_uploaded_file($imagen['tmp_name'], $rutaCompletaGuardar)) {
                            $rutaImagen = $rutaCompleta;
                        } else {
                            $_SESSION['msjError'] = "Error al subir la imagen.";
                            header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                            exit;
                        }
                    } else {
                        $_SESSION['msjError'] = "Formato de imagen no válido.";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                        exit;
                    }
                }

                // Actualizar en la base de datos
                try {
                    $sqlUpdateProd = $dbh->prepare("UPDATE inventario_productos 
                        SET id_categoria = :idCat, referencia = :ref, nombre = :nom, descripcion = :descr, 
                            imagen = IFNULL(:img, imagen), precio_unitario = :prec, cantidad_stock = :cant, fecha_sys = :fecSys
                        WHERE id_producto = :idProd");

                    $sqlUpdateProd->bindParam(':idCat', $categoria);
                    $sqlUpdateProd->bindParam(':ref', $referencia);
                    $sqlUpdateProd->bindParam(':nom', $nombre);
                    $sqlUpdateProd->bindParam(':descr', $descripcion);
                    $sqlUpdateProd->bindParam(':img', $rutaImagen);
                    $sqlUpdateProd->bindParam(':prec', $precio);
                    $sqlUpdateProd->bindParam(':cant', $cantidad);
                    $sqlUpdateProd->bindParam(':fecSys', $fechaYHora);
                    $sqlUpdateProd->bindParam(':idProd', $idProducto);

                    if ($sqlUpdateProd->execute()) {
                        $_SESSION['msjExito'] = "Producto actualizado exitosamente.";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                        exit;
                    } else {
                        $_SESSION['msjError'] = "Error al actualizar el producto.";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                        exit;
                    }
                } catch (PDOException $e) {
                    $_SESSION['msjError'] = "Error de base de datos: " . $e->getMessage();
                    header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                    exit;
                }
            } else {
                $_SESSION['msjError'] = "Campos vacíos. Por favor, completa los datos requeridos.";
                header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                exit;
            }
        } else if ($action === "delete") {
            // ELIMINAR PRODUCTO (CAMBIO DE ESTADO A 0)
            if (isset($_POST['id_producto'])) {
                $idProducto = $_POST['id_producto'];
                $fechaYHora = (new DateTime())->format('Y-m-d H:i:s');

                try {
                    $sqlDeleteProd = $dbh->prepare("UPDATE inventario_productos 
                        SET estado = 0, fecha_sys = :fecSys 
                        WHERE id_producto = :idProd");

                    $sqlDeleteProd->bindParam(':fecSys', $fechaYHora);
                    $sqlDeleteProd->bindParam(':idProd', $idProducto);

                    if ($sqlDeleteProd->execute()) {
                        $_SESSION['msjExito'] = "Producto eliminado exitosamente.";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                        exit;
                    } else {
                        $_SESSION['msjError'] = "Error al eliminar el producto.";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                        exit;
                    }
                } catch (PDOException $e) {
                    $_SESSION['msjError'] = "Error de base de datos: " . $e->getMessage();
                    header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                    exit;
                }
            } else {
                $_SESSION['msjError'] = "Producto no especificado.";
                header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                exit;
            }
        } else if ($action === "updateEstado") {
            if (isset($_POST['id_producto']) && isset($_POST['estadoProducto'])) {
                $idProducto = $_POST['id_producto'];
                $estadoProducto = $_POST['estadoProducto'];
                try {
                    $sqlUpdateEstado = $dbh->prepare("UPDATE inventario_productos SET estadoProducto = :estadoProducto WHERE id_producto = :idProducto");
                    $sqlUpdateEstado->bindParam(':estadoProducto', $estadoProducto, PDO::PARAM_INT);
                    $sqlUpdateEstado->bindParam(':idProducto', $idProducto, PDO::PARAM_INT);

                    if ($sqlUpdateEstado->execute()) {
                        echo json_encode(['success' => true]);
                    } else {
                        echo json_encode(['success' => false, 'error' => 'Error al actualizar el estado.']);
                    }
                } catch (PDOException $e) {
                    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
                }
            } else {
                echo json_encode(['success' => false, 'error' => 'Datos incompletos.']);
            }
        } else if ($action === "updateCantidad") {
            $idProducto = $_POST['id_productoCant'];
            $accionCantidad = $_POST['accionCantidad'];
            $cantidad = $_POST['cantidad_stock'];
            $estado = 1;
            $fechaActual = new DateTime();
            $fechaYHora = $fechaActual->format('Y-m-d H:i:s');

            // Determinar si sumar o restar
            if ($accionCantidad == 1) {
                // Preparar la consulta de actualización
                $sqlProducto = $dbh->prepare("UPDATE inventario_productos SET cantidad_stock = cantidad_stock + :cantidad WHERE id_producto = :id");
                // Preparar la consulta de inserción
                $sqlEntrada = $dbh->prepare("INSERT INTO inventario_entradas(id_empleado, id_producto, cantidad, estado, fecha_sys) VALUES (:id, :producto, :cant, :est, :fecha)");

                $sqlEntrada->bindParam(':id', $idEmpleado);
                $sqlEntrada->bindParam(':producto', $idProducto);
                $sqlEntrada->bindParam(':cant', $cantidad);
                $sqlEntrada->bindParam(':est', $estado);
                $sqlEntrada->bindParam(':fecha', $fechaYHora);
            } else {
                $sqlProducto = $dbh->prepare("UPDATE inventario_productos SET cantidad_stock = cantidad_stock - :cantidad WHERE id_producto = :id");
            }

            $sqlProducto->bindParam(':cantidad', $cantidad);
            $sqlProducto->bindParam(':id', $idProducto);

            if ($sqlProducto->execute()) {
                if (isset($sqlEntrada)) {
                    if ($sqlEntrada->execute()) {
                        $_SESSION['msjExito'] = "Cantidad actualizada exitosamente";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                        exit;
                    } else {
                        $_SESSION['msjError'] = "Error al insertar la entrada";
                        header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                        exit;
                    }
                } else {
                    $_SESSION['msjExito'] = "Cantidad actualizada exitosamente";
                    header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                    exit;
                }
            } else {
                $_SESSION['msjError'] = "Error al actualizar la cantidad";
                header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
                exit;
            }
        } else {
            $_SESSION['msjError'] = "Acción no válida.";
            header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
            exit;
        }
    }
} else {
    // Redirigir si no se accede por POST
    header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
    exit;
}
