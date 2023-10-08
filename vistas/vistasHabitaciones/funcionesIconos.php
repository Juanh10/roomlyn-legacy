<?php

function iconCantidadCama($tipoCama){

   $arrTipoCama = explode(",", $tipoCama);

   for ($i=0; $i < count($arrTipoCama) ; $i++) { 
        echo $arrTipoCama[$i]." ";
   }

}

function iconCapacidad($capacidadPerson){

    echo ($capacidadPerson > 1)? $capacidadPerson." Personas": $capacidadPerson." Persona";

}

?>