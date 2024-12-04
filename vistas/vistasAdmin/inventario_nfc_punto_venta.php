<?php
include_once "../../procesos/config/conex.php";

if (isset($_POST['codigo_nfc'])) {
    $codigo_nfc = $_POST['codigo_nfc'];

    // Consulta para verificar si el código está asociado a una habitación ocupada
    $query = $dbh->prepare("SELECT hb.id_habitacion, hb.nHabitacion FROM habitaciones AS hb INNER JOIN llaveros_nfc as ll ON hb.id_codigo_nfc = ll.id_codigo_nfc WHERE ll.codigo = :codigo_nfc AND hb.estado = 1 AND hb.id_hab_estado = 4");
    $query->bindParam(':codigo_nfc', $codigo_nfc, PDO::PARAM_STR);
    $query->execute();
    $habitacion = $query->fetch(PDO::FETCH_ASSOC);

    if ($habitacion) {
        echo json_encode($habitacion); // Enviar habitación si está ocupada
    } else {
        echo json_encode(['error' => 'Habitación no encontrada o no ocupada']);
    }
} else {
    echo json_encode(['error' => 'Código NFC no proporcionado']);
}
