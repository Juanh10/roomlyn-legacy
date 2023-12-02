<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

</head>
<body>

<?php
include_once "../../procesos/config/conex.php";


$nacionalidad = $_GET['valorNa'];

$sqlDepartamento = "SELECT id_departamento, id_nacionalidad, departamento FROM departamentos WHERE id_nacionalidad = " . $nacionalidad . "";

$resultFilasDepartamento = $dbh->query($sqlDepartamento);



if ($resultFilasDepartamento->rowCount() > 0) :

    echo '<option selected disabled value="">Escoja una opcion</option>';


    foreach ($resultFilasDepartamento as $rowDepartamento) :
        echo '<option value="' . $rowDepartamento['id_departamento'] . '">' . $rowDepartamento['departamento'] . '</option>';
    endforeach;
else :
    echo '<option selected value="1">No requerido</option>';
endif;
?>
</body>
</html>