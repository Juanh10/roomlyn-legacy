<?php

function convertirDias($checkin, $chechout)
{
    // Convertir las fechas para manipularlo matematicamente
    $timestampInicio = strtotime($checkin);
    $timestampFin = strtotime($chechout);

    // Calcular la diferencia en segundos
    $diferenciaSegundos = $timestampFin - $timestampInicio;

    // Convertir la diferencia en segundos a días
    $diferenciaDias = $diferenciaSegundos / 86400;

    $diferenciaDias = round($diferenciaDias);

    return $diferenciaDias;
}


function facturaReserva($precio, $diferenciaDias)
{

    // Cálculos comunes
    $subtotal1 = $precio * $diferenciaDias;
    $iva = $subtotal1 * 0.19;
    $totalFactura = $subtotal1 + $iva;

    return [
        'precioTipo' => $precio,
        'subtotal' => $subtotal1,
        'iva' => $iva,
        'total' => $totalFactura
    ];
}
