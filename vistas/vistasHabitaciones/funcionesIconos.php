<?php

function iconCantidadCama($cantCama){

    for ($i=0; $i < $cantCama ; $i++) { 
        echo "<img src='../iconos/cama.png' alt='Cama'>";
    }

}

function iconCapacidad($capacidadPerson){

    for ($i=0; $i < $capacidadPerson ; $i++) { 
        echo "<i class='bi bi-person-fill'></i>";
    }

}

?>