<?php

include_once "../../config/conex.php";

// Eliminar los servicios de las habitaciones

if (isset($_POST['btnElmServ'])) {

    session_start();

    if (!empty($_POST['idServicio'])) {

        $idServicios = $_POST['idServicio'];
        $idTipoHab = $_POST['idTipoHab'];

        $estadoElmServ = 0;

        $sqlElmServ = $dbh->prepare("UPDATE habitaciones_elementos_selec SET estado=:estado WHERE id_hab_tipo_elemento = :idServ"); // consulta sql

        $sqlElmServ->bindParam(':estado', $estadoElmServ); // vincular los marcadores con las variables
        $sqlElmServ->bindParam(':idServ', $idServicios);

        // ejecutamos la consulta 
        if ($sqlElmServ->execute()) {
            $nuevaListaServicios = obtenerListaServicios($dbh, $idTipoHab);

            echo $nuevaListaServicios;
        } else {
            $_SESSION['msjError'] = "Ocurrió un error";
            header("location: ../../../vistas/vistasAdmin/habitaciones.php?id=" . $idTipoHab . "");
        }
    } else {
        $_SESSION['msjError'] = "Ocurrió un error";
        header("location: ../../../vistas/vistasAdmin/habitaciones.php?id=" . $idTipoHab . "");
    }
}

// Agregar servicios segun los tipos de habitaciones

if (isset($_POST['añadirServ'])) {

    session_start();

    if (!empty($_POST['idTipoHab'])) { // si el campo no esta vacio

        $idTipoHab = $_POST['idTipoHab'];

        if (!empty($_POST['listaServi'])) { // si el campo no esta vacio

            $tipoServ = $_POST['listaServi'];
            $estado = 1;

            $sql = $dbh->prepare("INSERT INTO habitaciones_elementos_selec(id_habitacion, id_hab_elemento, estado, fecha_sys) VALUES (:idTipoHab, :idElemento, :estado, now())"); // consulta sql

            $sql->bindParam(':idTipoHab', $idTipoHab); // vincular los marcadores con las variables
            $sql->bindParam(':estado', $estado);

            $estadoSer = false;

            foreach ($tipoServ as $tipo) { // recorrer el arreglo de los servicios
                $sql->bindParam(':idElemento', $tipo);

                if ($sql->execute()) { // ejecutar la consulta
                    $estadoSer = true;
                } else {
                    $estadoSer = false;
                }
            }

            if ($estadoSer) {
                $nuevaListaServicios = obtenerListaServicios($dbh, $idTipoHab);

                echo $nuevaListaServicios;
            } else {
                echo "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente";
            }
        } else {
            echo "Debes seleccionar al menos un elemento de la habitación";
        }
    } else {
        echo "Ha habido un error en el proceso. Por favor, te solicitamos amablemente que nos contactes mediante el correo electrónico hotelroomlyn@gmail.com para informarnos sobre este inconveniente.";
    }
}

// Función para obtener la lista actualizada de servicios
function obtenerListaServicios($dbh, $idTipoHab)
{

    $sqlServicios = "SELECT habitaciones_elementos_selec.id_hab_tipo_elemento, habitaciones_elementos_selec.id_habitacion, habitaciones_elementos.elemento, habitaciones_elementos.id_hab_elemento, habitaciones_elementos_selec.estado FROM habitaciones_elementos_selec INNER JOIN habitaciones_elementos ON habitaciones_elementos_selec.id_hab_elemento = habitaciones_elementos.id_hab_elemento WHERE habitaciones_elementos_selec.estado = 1 AND habitaciones_elementos_selec.id_habitacion = " . $idTipoHab . "";

    ob_start(); // Capturar el contenido de salida

?>
    <?php
    foreach ($dbh->query($sqlServicios) as $rowServ) {
    ?>
        <li class="border border-bottom"><span><?php echo $rowServ['elemento'] ?></span>
            <form id="formEliminarServicio">
                <input type="hidden" name="idTipoHab" id="tipoHab<?php echo $idTipoHab ?>" value="<?php echo $idTipoHab ?>">
                <input type="hidden" name="idServicio" id="idServicio<?php echo $rowServ['id_hab_tipo_elemento'] ?>" value="<?php echo $rowServ['id_hab_tipo_elemento'] ?>">
                <button type="button" name="btnElmServ" title="Deshabilitar"><i class="bi bi-trash"></i></button>
            </form>
        </li>
    <?php
    }

    ?>
<?php

    $html = ob_get_clean(); // Obtener y limpiar el contenido de salida capturado
    return $html;
}

?>