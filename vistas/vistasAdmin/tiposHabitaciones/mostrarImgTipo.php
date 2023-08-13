<?php

$id = $_GET['id'];
$idTipo = $_GET['idTipo'];

include "../../../procesos/config/conex.php";

$sql = "SELECT ruta FROM habitaciones_imagenes WHERE id = " . $id . "";

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
        ?>
            <div class="imagenTipo">
                <img src="../../imgServidor/<?php echo $row['ruta'] ?>" alt="Fotos de las habitaciones">
            </div>
        <?php
        endforeach;
        ?>
    </div>

    <form action="../../procesos/registroHabitaciones/registroTipos/conActualizarImgTipo.php" method="post" enctype="multipart/form-data" id="formActImg">
        <input type="hidden" name="idTipoHab" value="<?php echo $idTipo ?>">
        <input type="file" name="imgNueva" class="form-control inputFileImg">
        <input type="submit" name="actulizarImagen" value="Actualizar" class="btnActImg">
    </form>

</body>

</html>