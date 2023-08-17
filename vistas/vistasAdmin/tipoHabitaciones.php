<?php

session_start();

if (empty($_SESSION['idUsuario'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

/* echo $_SESSION['idUsuario'];
echo $_SESSION['pNombre'];
echo $_SESSION['pApellido'];
echo $_SESSION['tipoUsuario']; */

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <?php require_once "menuAdmin.php"; ?>
</head>

<body>


    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>HABITACIONES</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <div class="contenido">
        <div class="container lisTiposHb">
            <h1>Tipos de habitaciones</h1>
            <div class="row">
                <div class="col">
                    <div class="cardHabitacion">

                        <?php

                        include "../../procesos/config/conex.php";

                        $sql = "SELECT habitaciones_tipos.id, habitaciones_tipos.tipoHabitacion, habitaciones_imagenes.ruta, habitaciones_imagenes.estado FROM habitaciones_tipos INNER JOIN habitaciones_imagenes ON habitaciones_tipos.id = habitaciones_imagenes.idTipoHabitacion WHERE 1 AND habitaciones_imagenes.estado = 1 GROUP BY(habitaciones_imagenes.idTipoHabitacion)";

                        foreach ($dbh->query($sql) as $row) :
                        ?>
                            <div class="cardHab">
                                <?php
                                if ($row['estado'] == 1) :
                                ?>
                                    <div class="imgHab">
                                        <img src="../../imgServidor/<?php echo $row['ruta'] ?>" alt="">
                                    </div>
                                <?php
                                endif;
                                ?>
                                <div class="tipoHab">
                                    <span><?php echo $row['tipoHabitacion'] ?></span>
                                    <button data-id="<?php echo $row['id']; ?>" data-bs-toggle="modal" data-bs-target="#modalInfor">Ver más</button>
                                </div>
                            </div>

                        <?php
                        endforeach;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalInfor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contenidoDelCrud">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Deshabilitar</button>
                    <a href="" id="editTipo" class="btn btn-warning">Editar </a>
                </div>
            </div>
        </div>
    </div>

</body>

</html>