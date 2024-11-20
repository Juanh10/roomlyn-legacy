<?php
session_start();

include_once "../config/conex.php";

// Verificar que se envie por el metodo get
if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    try {
        // validar el dato enviado
        if (!empty($_GET['numHab'])) {
            $numHab = $_GET['numHab'];

            // Preparamos y ejecutamos la consulta para obtener el valor del id habitacion
            $sql = $dbh->prepare('SELECT id_hab_tipo FROM habitaciones WHERE id_habitacion = :hab');
            $sql->bindParam(':hab', $numHab);
            $sql->execute();
            $resultado = $sql->fetch(PDO::FETCH_ASSOC); // Me devuelve el valor    

            $idTipoHab = $resultado['id_hab_tipo'];

            echo json_encode(["status" => "success", "message" => $idTipoHab]); 

        }else{
            echo json_encode(["status" => "error", "message" => "Ocurrió un error, intentalo de nuevo"]); 
        }
    } catch (\Throwable $e) {
        $mensajeError = array(
            "error" => "Ocurrió un error al procesar la solicitud: " . $e->getMessage()
        );
        echo json_encode($mensajeError);
    }
}
