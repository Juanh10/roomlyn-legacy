<?php

if (!empty($_GET['idselect'])) {
    include_once "../../../procesos/config/conex.php";

    $idSelect = $_GET['idselect'];

    $sql = "SELECT id, tipoHabitacion, cantidadCamas, capacidadPersonas, estado FROM habitaciones_tipos WHERE id = " . $idSelect . "";

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
                    <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="simple" id="simple">
                    <label for="simple">Simple</label>
                </div>
                <input type="number" class="form-control cantidadCamas" name="cantTipoSimple" aria-label="Cantidad de camas" placeholder="Cantidad de camas">
            </div>
        </div>

        <div class="tipoDoble">
            <div class="input-group">
                <div class="input-group-text">
                    <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="doble" id="doble">
                    <label for="doble">Doble</label>
                </div>
                <input type="number" class="form-control cantidadCamas" name="cantTipoDoble" aria-label="Cantidad de camas" placeholder="Cantidad de camas">
            </div>
        </div>
        <p id="msjErrorTipoCama">Debes escoger al menos una opción</p>
        <p id="msjErrorTipoCama2">La cantidad de camas no coincide con el tipo de habitación.</p>
    </div>

<?php


} else {
    $arregloTipoCama = explode(",", $rowHab['tipoCama']);

    $arregloOpciones = [];

    /* $subArreglo1 = explode(" ", $arregloTipoCama[0]);
    $subArreglo2 = explode(" ", $arregloTipoCama[1]); */

    $nuevoArreglo = array();

    foreach ($arregloTipoCama as $elemento) {
        $partes = explode(" ", $elemento);
        $cantidad = intval($partes[0]); // Convierte la cantidad a un número entero
        $tipo = $partes[1];
        $nuevoArreglo[] = array("cantidad" => $cantidad, "tipo" => $tipo);
    }

?>

    <p>Seleccione los tipos de cama y la cantidad para cada tipo:</p>

    <?php

    $tieneSimple = false;
    $tieneDoble = false;

    foreach ($nuevoArreglo as $elemento) {
        if ($elemento["tipo"] == "simple") {
            $tieneSimple = true;
        } elseif ($elemento["tipo"] == "doble") {
            $tieneDoble = true;
        }
    }


    if ($tieneSimple && $tieneDoble) {
        // Acceder al primer elemento (índice 0)
        $primerElemento = $nuevoArreglo[0];
        $cantidadDelPrimerElemento = $primerElemento["cantidad"]; // 1
        $tipoDelPrimerElemento = $primerElemento["tipo"]; // "simple"

        // Acceder al segundo elemento (índice 1)
        $segundoElemento = $nuevoArreglo[1];
        $cantidadDelSegundoElemento = $segundoElemento["cantidad"]; // 1
        $tipoDelSegundoElemento = $segundoElemento["tipo"]; // "doble"
    ?>
        <div class="tiposDeCamas mb-2">
            <div class="tipoSimple">
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="simple" id="simple" checked>
                        <label for="simple">Simple</label>
                    </div>
                    <input type="number" class="form-control cantidadCamas" name="cantTipoSimple" aria-label="Cantidad de camas" placeholder="Cantidad de camas" value="<?php echo $cantidadDelPrimerElemento ?>">
                </div>
            </div>

            <div class="tipoDoble">
                <div class="input-group">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="doble" id="doble" checked>
                        <label for="doble">Doble</label>
                    </div>
                    <input type="number" class="form-control cantidadCamas" name="cantTipoDoble" aria-label="Cantidad de camas" placeholder="Cantidad de camas" value="<?php echo $cantidadDelSegundoElemento ?>">
                </div>
            </div>
            <p id="msjErrorTipoCama">Debes escoger al menos una opción</p>
            <p id="msjErrorTipoCama2">La cantidad de camas no coincide con el tipo de habitación.</p>
        </div>
    <?php
    } else if ($tieneSimple) {
        // Acceder al primer elemento (índice 0)
        $primerElemento = $nuevoArreglo[0];
        $cantidadDelPrimerElemento = $primerElemento["cantidad"]; // 1
        $tipoDelPrimerElemento = $primerElemento["tipo"]; // "simple"
    ?>
        <div class="tiposDeCamas mb-2">
            <div class="tipoSimple">
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="simple" id="simple" checked>
                        <label for="simple">Simple</label>
                    </div>
                    <input type="number" class="form-control cantidadCamas" name="cantTipoSimple" aria-label="Cantidad de camas" placeholder="Cantidad de camas" value="<?php echo $cantidadDelPrimerElemento ?>">
                </div>
            </div>

            <div class="tipoDoble">
                <div class="input-group">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="doble" id="doble">
                        <label for="doble">Doble</label>
                    </div>
                    <input type="number" class="form-control cantidadCamas" name="cantTipoDoble" aria-label="Cantidad de camas" placeholder="Cantidad de camas">
                </div>
            </div>
            <p id="msjErrorTipoCama">Debes escoger al menos una opción</p>
            <p id="msjErrorTipoCama2">La cantidad de camas no coincide con el tipo de habitación.</p>
        </div>
        <?php
    } else if ($tieneDoble) {
        // Acceder al segundo elemento (índice 1)
        $segundoElemento = $nuevoArreglo[0];
        $cantidadDelSegundoElemento = $segundoElemento["cantidad"]; // 1
        $tipoDelSegundoElemento = $segundoElemento["tipo"]; // "doble"
        ?>
            <div class="tipoDoble">
                <div class="input-group">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="doble" id="doble" checked>
                        <label for="doble">Doble</label>
                    </div>
                    <input type="number" class="form-control cantidadCamas" name="cantTipoDoble" aria-label="Cantidad de camas" placeholder="Cantidad de camas" value="<?php echo $cantidadDelSegundoElemento ?>">
                </div>
            </div>
            <p id="msjErrorTipoCama">Debes escoger al menos una opción</p>
            <p id="msjErrorTipoCama2">La cantidad de camas no coincide con el tipo de habitación.</p>
        </div>

        <div class="tiposDeCamas mb-2">
            <div class="tipoSimple">
                <div class="input-group mb-3">
                    <div class="input-group-text">
                        <input class="form-check-input mt-0 me-2" type="checkbox" name="tipoCama[]" value="simple" id="simple">
                        <label for="simple">Simple</label>
                    </div>
                    <input type="number" class="form-control cantidadCamas" name="cantTipoSimple" aria-label="Cantidad de camas" placeholder="Cantidad de camas">
                </div>
            </div>
<?php
    }
}
