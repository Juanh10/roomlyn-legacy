<?php

if (!empty($_GET['id'])) {

    include_once "../../../procesos/config/conex.php";

    $id = $_GET['id'];

    $sql = "SELECT id_hab_tipo, tipoHabitacion, cantidadCamas, capacidadPersonas, estado FROM habitaciones_tipos WHERE id_hab_tipo = " . $id . "";

    foreach ($dbh->query($sql) as $rowTipoHab) {
        $cantidadCamas = $rowTipoHab['cantidadCamas'];
    }
?>
    <p class="mensajeCantidad">Cantidad de camas disponibles en este tipo de habitación: <?php echo $cantidadCamas ?></p>
    <p>Seleccione los tipos de cama y la cantidad para cada tipo:</p>
    
    <div class="tiposDeCamas mb-2">
    <div class="tipoSimple">
        <div class="input-group mb-3">
            <div class="input-group-text">
                <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="simple" id="simple" onchange="inputSimple(this)">
                <label for="simple">Simple</label>
            </div>
            <input type="number" class="form-control cantidadCamas" name="cantTipoSimple" id="cantTipoSimple" aria-label="Cantidad de camas" placeholder="Cantidad de camas" disabled>
        </div>
    </div>

    <div class="tipoDoble">
        <div class="input-group">
            <div class="input-group-text">
                <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="doble" id="doble" onchange="inputDoble(this)">
                <label for="doble">Doble</label>
            </div>
            <input type="number" class="form-control cantidadCamas" name="cantTipoDoble" id="cantTipoDoble" aria-label="Cantidad de camas" placeholder="Cantidad de camas" disabled>
        </div>
    </div>
    <p id="msjErrorTipoCama">Debes escoger al menos una opción</p>
    <p id="msjErrorTipoCama2">La cantidad de camas no coincide con el tipo de habitación.</p>
    </div>

    <script>
        function inputSimple(checkbox) {
        let input = document.getElementById("cantTipoSimple");
        input.disabled = !checkbox.checked;
    }

    function inputDoble(checkbox) {
        let input = document.getElementById("cantTipoDoble");
        input.disabled = !checkbox.checked;
    }
    </script>

<?php

}



?>