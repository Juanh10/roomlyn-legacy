<?php
include_once "../../../procesos/config/conex.php";

// Obtener el valor del parámetro 'valorNa' a través de GET
$nacionalidad = $_GET['valorNa'];

// Construir la consulta SQL para obtener los departamentos de una nacionalidad específica
$sqlDepartamento = "SELECT id_departamento, id_nacionalidad, departamento FROM departamentos WHERE id_nacionalidad = " . $nacionalidad . "";

// Ejecutar la consulta SQL
$resultFilasDepartamento = $dbh->query($sqlDepartamento);

// Verificar si hay resultados obtenidos de la consulta
if ($resultFilasDepartamento->rowCount() > 0) :

    // Imprimir la opción predeterminada para la selección de departamentos
    echo '<option selected disabled value="">Escoja una opción</option>';

    // Recorrer los resultados y generar opciones para cada departamento
    foreach ($resultFilasDepartamento as $rowDepartamento) :
        echo '<option value="' . $rowDepartamento['id_departamento'] . '">' . $rowDepartamento['departamento'] . '</option>';
    endforeach;
else :
    // Si no hay resultados, imprimir una opción predeterminada indicando que no es requerido
    echo '<option selected value="1">No requerido</option>';
endif;
?>