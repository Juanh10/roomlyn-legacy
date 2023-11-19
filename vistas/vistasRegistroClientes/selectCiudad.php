<?php
include_once "../../procesos/config/conex.php";

$departamento = $_GET['valorDe'];
$sqlCiudad = "SELECT id_municipio, id_departamento, municipio FROM municipios WHERE id_departamento = " . $departamento . "";

$resultFilasCiudad = $dbh->query($sqlCiudad);

if ($resultFilasCiudad->rowCount() > 0) :

    echo '<option selected disabled value="">Escoja una opción</option>';

    foreach ($resultFilasCiudad as $rowCiudad) :
        echo '<option value="' . $rowCiudad['id_municipio'] . '">' . $rowCiudad['municipio'] . '</option>';
    endforeach;
else :
    echo '<option selected value="1">No requerido</option>';
endif;
