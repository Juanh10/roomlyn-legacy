<?php

include_once "../config/conex.php";

$select = $_GET['select'];

// Preparar la consulta SQL

$sql = $dbh->prepare("SELECT r.id_habitacion, h.nHabitacion, COUNT(*) AS cantidad_reservas FROM reservas AS r INNER JOIN habitaciones AS h ON h.id_habitacion = r.id_habitacion WHERE r.id_estado_reserva = 4 AND YEAR(fecha_sys) = YEAR(CURDATE()) AND MONTH(fecha_sys) = :selec GROUP BY r.id_habitacion, h.nHabitacion ORDER BY cantidad_reservas DESC");

$sql->bindParam(':selec', $select, PDO::PARAM_INT);

$sql->execute();

// Obtener los resultados de la consulta
$data = $sql->fetchAll(PDO::FETCH_ASSOC);

// Convertir los resultados a formato JSON y devolverlos como respuesta
echo json_encode($data);

?>