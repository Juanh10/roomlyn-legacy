<?php

$id = $_GET['id'];
$idTipo = $_GET['idTipo'];

include_once "../../../procesos/config/conex.php";

$sql = "SELECT ruta, estado FROM habitaciones_imagenes WHERE id = " . $id . "";

?>


<!DOCTYPE html>

<head>
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <link rel="stylesheet" href="../../librerias/bootstrap5/css/bootstrap.min.css">
</head>

<body>

    <div class="mostrarImg">
        <?php
        foreach ($dbh->query($sql) as $row) :
            if($row['estado'] == 1):
        ?>
            <div class="imagenTipo">
                <img src="../../imgServidor/<?php echo $row['ruta'] ?>" alt="Fotos de las habitaciones">
            </div>
        <?php
        endif;
        endforeach;
        ?>
    </div>

    <form action="../../procesos/registroHabitaciones/registroTipos/conActualizarImgTipo.php" method="post" enctype="multipart/form-data" id="formActImg">
        <input type="hidden" name="idTipoHab" value="<?php echo $idTipo ?>">
        <input type="hidden" name="idImg" value="<?php echo $id ?>">
        <input type="file" name="imgNueva" class="form-control inputFileImg">
        <div class="btnInputs">
            <input type="submit" name="eliminarImagen" value="Deshabilitar" class="btnElmImg">
            <input type="submit" name="actulizarImagen" value="Actualizar" class="btnActImg">
        </div>
    </form>

</body>

</html>