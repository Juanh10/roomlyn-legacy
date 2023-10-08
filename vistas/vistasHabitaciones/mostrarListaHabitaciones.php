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
            mostrarTituloTipo($id,$dbh);
            mostrarDatosHabitaciones("ventilador",$id, $dbh);
            mostrarDatosHabitaciones("aire",$id, $dbh);
        elseif($ventSelec):
            mostrarTituloTipo($id,$dbh);
            mostrarDatosHabitaciones("ventilador",$id, $dbh);
        elseif($aireSelec):
            mostrarTituloTipo($id,$dbh);
            mostrarDatosHabitaciones("aire",$id, $dbh);
        endif;
    }else{
        mostrarTituloTipo($id,$dbh);
        mostrarDatosHabitaciones("ventilador",$id, $dbh);
        mostrarDatosHabitaciones("aire",$id, $dbh);
    }
}
?>