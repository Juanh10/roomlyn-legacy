<?php

if (!empty($_GET['idselect'])) {
    include_once "../../../procesos/config/conex.php";

    $idSelect = $_GET['idselect'];

    $sql = "SELECT id, tipoHabitacion, cantidadCamas, capacidadPersonas, estado FROM habitaciones_tipos WHERE id = " . $idSelect . "";

    foreach ($dbh->query($sql) as $rowTipoHab) {
        $cantidadCamas = $rowTipoHab['cantidadCamas'];
    }


    for ($i = 1; $i <= $cantidadCamas; $i++) {
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
} else {
    $arregloTipoCama = explode(",", $rowHab['tipoCama']);

    for ($i = 0; $i < count($arregloTipoCama); $i++) {

        if ($arregloTipoCama[$i] === "Simple") {
        ?>
            <label for="tipoCama mb-3">Tipo de la cama <?php echo $i + 1 ?></label>
            <select name="tipoCama<?php echo $i + 1 ?>" id="tipoCama<?php echo $i ?>" class="form-select mb-3 mt-2">
                <option value="Simple" selected>Simple</option>
                <option value="Doble">Doble</option>
            </select>
        <?php
        } else {
        ?>
            <label for="tipoCama mb-3">Tipo de la cama <?php echo $i + 1 ?></label>
            <select name="tipoCama<?php echo $i + 1 ?>" id="tipoCama<?php echo $i ?>" class="form-select mb-3 mt-2">
                <option value="Doble" selected>Doble</option>
                <option value="Simple">Simple</option>
            </select>
<?php
        }
    }
}

?>