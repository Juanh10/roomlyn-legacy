<?php
include_once "../../procesos/config/conex.php";


$nacionalidad = $_GET['valorNa'];

$sqlDepartamento = "SELECT id_departamento, id_nacionalidad, departamento FROM departamento WHERE id_nacionalidad = " . $nacionalidad . "";

$resultFilasDepartamento = $dbh->query($sqlDepartamento);



if ($resultFilasDepartamento->rowCount() > 0) :

    echo '<option selected disabled value="">Escoja una opción</option>';


    foreach ($resultFilasDepartamento as $rowDepartamento) :
        echo '<option value="' . $rowDepartamento['id_departamento'] . '">' . $rowDepartamento['departamento'] . '</option>';
    endforeach;
else :
    echo '<option selected value="1">No requerido</option>';
endif;
