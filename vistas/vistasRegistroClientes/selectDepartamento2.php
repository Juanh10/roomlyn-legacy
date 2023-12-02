<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

</head>
<body>

<?php

include_once "../../procesos/config/conex.php";

if(!empty($_GET['event'])){
    $nacionalidad = $_GET['valorNa'];
    $sqlDepartamento = "SELECT id_departamento, id_nacionalidad, departamento FROM departamentos WHERE id_nacionalidad = " . $nacionalidad . "";
    
    $resultFilasDepartamento = $dbh->query($sqlDepartamento);
    if ($resultFilasDepartamento->rowCount() > 0) :
    
        echo '<option selected disabled value="">Escoja una opcion</option>';
    
        foreach ($resultFilasDepartamento as $rowDepartamento) :
            if ($rowDepartamento['id_departamento'] != $rowCliente['id_departamento']) {
                echo '<option value="' . $rowDepartamento['id_departamento'] . '">' . $rowDepartamento['departamento'] . '</option>';
            }
        endforeach;
    else :
        echo '<option selected value="1">No requerido</option>';
    endif;

}else{
    $nacionalidad = $_GET['valorNa'];
    $cliente = $_GET['vCliente'];
    
    $sqlDepartamento = "SELECT id_departamento, id_nacionalidad, departamento FROM departamentos WHERE id_nacionalidad = " . $nacionalidad . "";
    
    $resultFilasDepartamento = $dbh->query($sqlDepartamento);
    
    $sqlCliente = "SELECT clientes_registrados.id_cliente_registrado, info_clientes.id_departamento, info_clientes.id_municipio, departamentos.departamento, municipios.municipio FROM clientes_registrados INNER JOIN info_clientes ON info_clientes.id_info_cliente = clientes_registrados.id_info_cliente INNER JOIN nacionalidades ON info_clientes.id_nacionalidad = nacionalidades.id_nacionalidad INNER JOIN departamentos ON info_clientes.id_departamento = departamentos.id_departamento INNER JOIN municipios ON info_clientes.id_municipio = municipios.id_municipio WHERE clientes_registrados.id_cliente_registrado = " . $cliente . " AND clientes_registrados.estado = 1";
    
    $rowCliente = $dbh->query($sqlCliente)->fetch();
    
    
    if ($resultFilasDepartamento->rowCount() > 0) :
        
        echo '<option selected value="' . $rowCliente['id_departamento'] . '">' . $rowCliente['departamento'] . '</option>';
    
        foreach ($resultFilasDepartamento as $rowDepartamento) :
            if ($rowDepartamento['id_departamento'] != $rowCliente['id_departamento']) {
                echo '<option value="' . $rowDepartamento['id_departamento'] . '">' . $rowDepartamento['departamento'] . '</option>';
            }
        endforeach;
    else :
        echo '<option selected value="1">No requerido</option>';
    endif;
    
}
?>
</body>
</html>