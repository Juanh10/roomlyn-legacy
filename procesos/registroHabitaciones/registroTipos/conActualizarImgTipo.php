<?php

include_once "../../config/conex.php";
session_start();

// Actualizar imagen existente
if (isset($_POST['actulizarImagen'])) {
    // Obtener valores del formulario
    $idTipoHab = $_POST['idTipoHab'];
    $idImg = $_POST['idImg'];

    // Verificar si se seleccionó un nuevo archivo
    if (isset($_FILES['imgNueva']) && $_FILES['imgNueva']['error'] == 0) {
        // Obtener información sobre el archivo
        $tipoArchivo = $_FILES['imgNueva']['type'];
        $tiposPermitidos = array('image/jpeg', 'image/jpg', 'image/png', 'image/bmp', 'image/webp', 'image/tiff', 'image/svg');

        // Verificar si el tipo de archivo es permitido
        if (in_array($tipoArchivo, $tiposPermitidos)) {
            // Obtener información del nuevo archivo
            $imagenNueva = $_FILES['imgNueva']['name'];
            $nombreImagen = pathinfo($imagenNueva, PATHINFO_FILENAME);
            $extensionImg = pathinfo($imagenNueva, PATHINFO_EXTENSION);
            $tmpImg = $_FILES['imgNueva']['tmp_name'];
            $rutaImg = $nombreImagen . "." . $extensionImg;

            // Preparar y ejecutar la consulta de actualización
            $sqlImg = $dbh->prepare("UPDATE habitaciones_imagenes SET nombre = :nombre, ruta = :ruta WHERE id_hab_imagen = :id");
            $sqlImg->bindParam(':nombre', $nombreImagen);
            $sqlImg->bindParam(':ruta', $rutaImg);
            $sqlImg->bindParam(':id', $idImg);

            if ($sqlImg->execute()) {
                // Mover el nuevo archivo al directorio
                move_uploaded_file($tmpImg, "../../../imgServidor/" . $rutaImg);
                $_SESSION['msjExito'] = "La foto se ha actualizado con éxito.";
                header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
            } else {
                $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, contáctanos para informarnos sobre este inconveniente.";
                header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
            }
        } else {
            $_SESSION['msjError'] = "Tipo de archivo no permitido";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }
    } else {
        $_SESSION['msjError'] = "No se eligió ningún archivo";
        header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
    }
}

// Eliminar imagen
if (isset($_POST['eliminarImagen'])) {
    // Verificar si se proporcionaron los valores necesarios
    if (!empty($_POST['idImg']) && !empty($_POST['idTipoHab'])) {
        $idImg2 = $_POST['idImg'];
        $idTipoHab = $_POST['idTipoHab'];
        $estadoElm = 0;

        // Preparar y ejecutar la consulta de actualización para deshabilitar la imagen
        $sqlElmImg = $dbh->prepare("UPDATE habitaciones_imagenes SET estado = :estadoElm WHERE id_hab_imagen = :idImgElm");
        $sqlElmImg->bindParam(':estadoElm', $estadoElm);
        $sqlElmImg->bindParam('idImgElm', $idImg2);

        if ($sqlElmImg->execute()) {
            $_SESSION['msjExito'] = "¡Se ha deshabilitado correctamente!";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        } else {
            $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, contáctanos para informarnos sobre este inconveniente.";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab . "");
        }
    }
}

// Agregar nueva imagen
if (isset($_POST['btnAddImg'])) {
    // Obtener el id del tipo de habitación
    $idTipoHab2 = $_POST['idTipoHab'];

    // Verificar si se proporcionó un archivo
    if ($_FILES['addImg']['error'] == 0) {
        $tipoArchivo = $_FILES['addImg']['type'];
        $tiposPermitidos = array('image/jpeg', 'image/jpg', 'image/png', 'image/bmp', 'image/webp', 'image/tiff', 'image/svg');

        // Verificar si el tipo de archivo es permitido
        if (in_array($tipoArchivo, $tiposPermitidos)) {
            // Obtener información del nuevo archivo
            $imagenNueva = $_FILES['addImg']['name'];
            $rutaTmp = $_FILES['addImg']['tmp_name'];
            $estadoImgNueva = 1;
            $nombreImgNueva = pathinfo($imagenNueva, PATHINFO_FILENAME);
            $extensionImgNueva = pathinfo($imagenNueva, PATHINFO_EXTENSION);
            $rutaNuevaImg = $nombreImgNueva . "." . $extensionImgNueva;

            // Preparar y ejecutar la consulta para insertar la nueva imagen
            $sqlImgNueva = $dbh->prepare("INSERT INTO habitaciones_imagenes(id_hab_tipo, nombre, ruta, estado) VALUES (:idTip, :nombre, :ruta, :estado)");
            $sqlImgNueva->bindParam(':idTip', $idTipoHab2);
            $sqlImgNueva->bindParam('nombre', $nombreImgNueva);
            $sqlImgNueva->bindParam(':ruta', $rutaNuevaImg);
            $sqlImgNueva->bindParam(':estado', $estadoImgNueva);

            if ($sqlImgNueva->execute()) {
                // Mover el nuevo archivo al directorio deseado
                move_uploaded_file($rutaTmp, "../../../imgServidor/" . $rutaNuevaImg);
                $_SESSION['msjExito'] = "La foto se ha insertado exitosamente.";
                header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab2 . "");
            } else {
                $_SESSION['msjError'] = "Ha habido un error en el proceso. Por favor, contáctanos para informarnos sobre este inconveniente.";
                header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab2 . "");
            }
        } else {
            $_SESSION['msjError'] = "Tipo de archivo no permitido";
            header("location: ../../../vistas/vistasAdmin/editTiposHabitaciones.php?id=" . $idTipoHab2 . "");
        }
    }
}
?>