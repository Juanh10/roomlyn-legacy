<?php

include_once "../../../procesos/config/conex.php";

// Obtener el valor del departamento enviado por la solicitud AJAX
$departamento = $_GET['valorDe'];

// Consultar las ciudades asociadas al departamento seleccionado
$sqlCiudad = "SELECT id_municipio, id_departamento, municipio FROM municipios WHERE id_departamento = " . $departamento . "";

// Ejecutar la consulta
$resultFilasCiudad = $dbh->query($sqlCiudad);

// Verificar si se obtuvieron resultados de la consulta
if ($resultFilasCiudad->rowCount() > 0) :
    // Imprimir la opción predeterminada deshabilitada
    echo '<option selected disabled value="">Escoja una opción</option>';

    // Iterar sobre los resultados y generar las opciones para el campo de ciudades
    foreach ($resultFilasCiudad as $rowCiudad) :
        echo '<option value="' . $rowCiudad['id_municipio'] . '">' . $rowCiudad['municipio'] . '</option>';
    endforeach;
else :
    // Si no hay ciudades disponibles, imprimir una opción por defecto indicando que no es requerido
    echo '<option selected value="1">No requerido</option>';
endif;
?>