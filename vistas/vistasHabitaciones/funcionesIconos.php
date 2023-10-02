<?php

function iconCantidadCama($tipoCama){

   $arrTipoCama = explode(",", $tipoCama);

   for ($i=0; $i <count($arrTipoCama) ; $i++) { 
        if(strtolower($arrTipoCama[$i]) === "simple"){
            echo "<img src='../../iconos/camaSimple.png' alt='cama sencilla' title='Sencilla'>  ";
        }else{
            echo "<img src='../../iconos/camaDoble.png' alt='cama doble' title='Doble'> ";
        }
   }

}

function iconCapacidad($capacidadPerson){

    for ($i=0; $i < $capacidadPerson ; $i++) { 
        echo "<i class='bi bi-person-fill'></i>";
    }

}

?>