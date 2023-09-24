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
            <label for="tipoCama mb-3">Tipo de la cama <?php echo $i ?></label>
            <select name="tipoCama<?php echo $i ?>" id="tipoCama<?php echo $i ?>" class="form-select mb-3 mt-2">
                <option disabled selected value="">Escoja una opción</option>
                <option value="Simple">Simple</option>
                <option value="Doble">Doble</option>
            </select>
            <p></p>
        <?php
    }


}



?>