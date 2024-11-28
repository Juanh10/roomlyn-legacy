<?php

// Incluir la configuración de conexión y establecer la zona horaria
include_once "../../config/conex.php";
date_default_timezone_set("America/Bogota");

session_start();

// Verificar que la solicitud sea POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
} else {
    // Redirigir si no se accede por POST
    header("location: ../../../vistas/vistasAdmin/inventario_productos.php");
    exit;
}
