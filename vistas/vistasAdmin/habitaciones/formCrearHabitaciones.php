<?php

if(!empty($_GET['id'])){
    
    include_once "../../../procesos/config/conex.php";

    $id = $_GET['id'];
    
    $sql = "SELECT id, tipoHabitacion, cantidadCamas, capacidadPersonas, estado FROM habitaciones_tipos WHERE id = ".$id."";

    foreach ($dbh->query($sql) as $rowTipoHab) {
        $cantidadCamas = $rowTipoHab['cantidadCamas'];
    }


    for ($i=1; $i <= $cantidadCamas ; $i++) { 
        ?>
        <label for="">Tipo de la cama <?php echo $i ?></label>
            <input type="text" name="tipoCama" class="form-control w-50 mt-2">
        <?php
    }


}



?>