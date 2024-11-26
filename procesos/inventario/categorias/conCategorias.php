<?php
date_default_timezone_set('America/Bogota');
session_start();

include_once "../../config/conex.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoria = $_POST['categoria'];
    $estado = 1;
    $fecha_sys = date('Y-m-d H:i:s');

    $sql = $dbh->prepare("INSERT INTO inventario_categorias(nombre_categoria, estado, fecha_sys) VALUES (:nombre, :estado, :fecha_sys)");
    $sql->bindParam(':nombre', $categoria);
    $sql->bindParam(':estado', $estado);
    $sql->bindParam(':fecha_sys', $fecha_sys);

    // Ejecutar la consulta y verificar si fue exitosa
    if ($sql->execute()) {
        // Obtener el ID del último registro insertado
        $id = $dbh->lastInsertId();

        // Devuelve una respuesta en JSON
        echo json_encode(['id' => $id, 'nombre' => $categoria]);
    } else {
        // En caso de error en la ejecución
        echo json_encode(['error' => 'Hubo un error al insertar la categoría.']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Leer el contenido de la solicitud PUT
    parse_str(file_get_contents("php://input"), $put_vars);
    
    $id_categoria = $put_vars['id_categoria'];
    $categoria = $put_vars['categoria'];

    // Consulta para actualizar la categoría
    $sql = $dbh->prepare("UPDATE inventario_categorias SET nombre_categoria = :nombre WHERE id_categoria = :id");
    $sql->bindParam(':nombre', $categoria);
    $sql->bindParam(':id', $id_categoria);

    if ($sql->execute()) {
        echo json_encode(['id' => $id_categoria, 'nombre' => $categoria]);
    } else {
        echo json_encode(['error' => 'Hubo un error al actualizar la categoría.']);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Leer el contenido de la solicitud DELETE
    parse_str(file_get_contents("php://input"), $delete);
    
    $id_categoria = $delete['id_categoria'];
    $estado = 0;

    // Consulta para actualizar la categoría
    $sql = $dbh->prepare("UPDATE inventario_categorias SET estado = :estado WHERE id_categoria = :id");
    $sql->bindParam(':id', $id_categoria);
    $sql->bindParam(':estado', $estado);

    if ($sql->execute()) {
        echo json_encode(['id' => $id_categoria, 'resultado' => true]);
    } else {
        echo json_encode(['error' => 'Hubo un error al actualizar la categoría.']);
    }
}


?>
