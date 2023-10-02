<?php

$id = $_POST['idTipoHab'];
include "listaHabitaciones.php";

if(isset($_POST['btnVerInfor'])){
    if(!empty($_POST['opServicios'])){
        $opServicio = $_POST['opServicios'];
        $ventSelec = false;
        $aireSelec = false;

        foreach($opServicio as $opciones){ // recorrer el arreglo de los checkbox
            if($opciones == "ventilador"){ // si seleccionó ventilador me cambia la variable boolean a true
                $ventSelec = true;
            }else if($opciones == "aire"){ // si seleccionó aire me cambia la variable boolean a true
                $aireSelec = true;
            }
        }

        if($ventSelec && $aireSelec):
            mostrarDatosHabitaciones("ambas",$id, $dbh);
        elseif($ventSelec):
            mostrarDatosHabitaciones("ventilador",$id, $dbh);
        elseif($aireSelec):
            mostrarDatosHabitaciones("aire",$id, $dbh);
        endif;
    }else{
        mostrarDatosHabitaciones("ambas",$id, $dbh);
    }
}
?>