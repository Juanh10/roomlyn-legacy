<?php

include_once "../../procesos/config/conex.php";

$departamento = $_GET['valorDe'];
$cliente = $_GET['vCliente'];

$sqlCiudad = "SELECT id_municipio, id_departamento, municipio FROM municipio WHERE id_departamento = " . $departamento . "";

$resultFilasCiudad = $dbh->query($sqlCiudad);

$sqlCliente = "SELECT clientes_registrados.id_cliente_registrado, info_clientes.id_departamento, info_clientes.id_municipio, departamento.departamento, municipio.municipio FROM clientes_registrados INNER JOIN info_clientes ON info_clientes.id_info_cliente = clientes_registrados.id_info_cliente INNER JOIN nacionalidad ON info_clientes.id_nacionalidad = nacionalidad.id_nacionalidad INNER JOIN departamento ON info_clientes.id_departamento = departamento.id_departamento INNER JOIN municipio ON info_clientes.id_municipio = municipio.id_municipio WHERE clientes_registrados.id_cliente_registrado = " . $cliente . " AND clientes_registrados.estado = 1";
$rowCliente = $dbh->query($sqlCliente);

if ($departamento != 0) {
    if ($resultFilasCiudad->rowCount() > 0) {

        echo '<option selected disabled value="">Escoja una opción</option>';

        foreach ($resultFilasCiudad as $rowCiudad) :
            echo '<option value="' . $rowCiudad['id_municipio'] . '">' . $rowCiudad['municipio'] . '</option>';
        endforeach;
    } else if ($rowCliente->rowCount() > 0) {

        $rowCliente2 = $dbh->query($sqlCliente)->fetch();

        $sqlCiudad2 = "SELECT id_municipio, id_departamento, municipio FROM municipio WHERE id_departamento = " . $rowCliente2['id_departamento'] . "";

        $resultFilasCiudad2 = $dbh->query($sqlCiudad2);

        echo '<option value="' . $rowCliente2['id_municipio'] . '">' . $rowCliente2['municipio'] . '</option>';

        foreach ($resultFilasCiudad2 as $rowCiudad) {
            if ($rowCiudad['id_municipio'] != $rowCliente2['id_municipio']) {
                echo '<option value="' . $rowCiudad['id_municipio'] . '">' . $rowCiudad['municipio'] . '</option>';
            }
        }
    }
} else {
    echo '<option selected value="1">No requerido</option>';
}
