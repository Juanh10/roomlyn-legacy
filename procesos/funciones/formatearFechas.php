<?php

function formatearFecha($fecha){
    $date = new DateTime($fecha);
    $fechaFormateada = $date->format('d/m/Y');
    return $fechaFormateada;
}

?>