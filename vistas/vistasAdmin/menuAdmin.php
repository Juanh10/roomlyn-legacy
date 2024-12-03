<?php

include_once "../../procesos/config/conex.php";

$sqlFecha = "UPDATE reservas AS r JOIN habitaciones AS h ON r.id_habitacion = h.id_habitacion SET r.id_estado_reserva = 3, h.id_hab_estado = 1 WHERE r.id_estado_reserva = 1 AND fecha_ingreso < CURDATE()";
$dbh->query($sqlFecha);

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../iconos/logo_icono.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />
    <link rel="stylesheet" href="../../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../librerias/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../librerias/sweetAlert2/css/sweetalert2.min.css">
    <link rel="stylesheet" href="../../librerias/datatables/css/datatables.min.css">
    <!-- <link rel="stylesheet" href="../../librerias/datatables/css/jquery.dataTables.min.css"> -->
    <link rel="stylesheet" href="../../librerias/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../../css/estilosMenuAdmin.css">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <link rel="stylesheet" href="../../css/estilosReservasAdmin.css">
    <title>ROOMLYN</title>
</head>

<body>

    <!--* CABECERA DEL MENU  -->

    <header class="cabeceraMenu">
        <div class="iconoMenu">
            <i class="bi bi-list btnIconoMenu" id="btnMenu2"></i>
            <span>INICIO</span>
        </div>
        <div class="usuPlat">
            <span><?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?></span>
        </div>
    </header>

    <!-- MENU LATERAL FIJO  -->
    <nav class="menuLateralFijo">

        <div class="logo_cont2">
            <div class="logo2">
                <a href="inicio.php">
                    <img src="../../iconos/logoRoomlyn3.png" alt="Logo roomlyn">
                </a>
            </div>
        </div>

        <ul class="list">

            <li class="list_item">
                <a class="enlaceMenu" href="inicio.php" title="Inicio">
                    <i class="bi bi-house-door-fill"></i>
                </a>
            </li>

            <li class="list_item">
                <a class="enlaceMenu listRecepcion" href="recepcion.php" title="Recepción">
                    <i class="bi bi-calendar-plus"></i>
                </a>
            </li>

            <li class="list_item">
                <a class="enlaceMenu" href="reservaciones.php" title="Historial de Reservaciones">
                    <i class="bi bi-calendar-check-fill"></i>
                </a>
            </li>

            <li class="list_item">

                <div class="enlacePrincipal" id="flechaHabitaciones">
                    <a class="enlaceMenu menuDesplegable" title="Habitaciones">
                        <i class="bi bi-list-ul"></i>
                        <i class="bi bi-caret-right-fill flecha iconHabitaciones"></i>
                    </a>
                </div>

                <ul class="submenu">
                    <li class="list_itemSecund">
                        <div class="enlaceSecundarios">
                            <a class="enlaceMenuSecund" href="regTipoHabitacion.php" title="Crear tipo de habitación">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <a class="enlaceMenuSecund" href="tipoHabitaciones.php" title="Listado tipo de habitaciones">
                                <i class="bi bi-card-checklist"></i>
                            </a>
                            <a class="enlaceMenuSecund" href="habitaciones.php" title="Habitaciones">
                                <i class="material-symbols-outlined">bed</i>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

            <li class="list_item">
                <a class="enlaceMenu" href="clientes.php" title="Clientes">
                    <i class="bi bi-person-lines-fill"></i>
                </a>
            </li>

            <li class="list_item">

                <div class="enlacePrincipal" id="flechaInventario">
                    <a class="enlaceMenu menuDesplegable_inventario" title="Inventario">
                        <i class="bi bi-boxes"></i>
                        <i class="bi bi-caret-right-fill flecha iconInventario"></i>
                    </a>
                </div>

                <ul class="submenu">
                    <li class="list_itemSecund">
                        <div class="enlaceSecundarios">
                            <a class="enlaceMenuSecund_inventario" href="inventario_categorias.php" title="Administrar categorias">
                                <i class="bi bi-tags-fill"></i>
                            </a>
                            <a class="enlaceMenuSecund_inventario" href="inventario_productos.php" title="Administrar articulos">
                                <i class="bi bi-bag-check-fill"></i>
                            </a>

                            <a class="enlaceMenuSecund_inventario" href="inventarioEntradas.php" title="Entradas">
                                <i class="bi bi-box-arrow-in-down"></i>
                            </a>

                            <a class="enlaceMenuSecund_inventario" href="inventarioSalidas.php" title="Salidas">
                                <i class="bi bi-box-arrow-up"></i>
                            </a>

                            <?php
                            if ($_SESSION['tipoUsuario'] == 1):
                            ?>
                                <a class="enlaceMenuSecund_inventario" href="inventarioAdministrarPuntoVenta.php" title="Punto de venta">
                                    <i class="bi bi-box-seam-fill"></i>
                                </a>
                            <?php
                            else:
                            ?>
                                <a class="enlaceMenuSecund_inventario" href="inventarioLoginPuntoVenta.php" target="_blank" title="Punto de venta">
                                    <i class="bi bi-box-seam-fill"></i>
                                </a>
                            <?php
                            endif;
                            ?>
                        </div>
                    </li>
                </ul>
            </li>

            <?php

            //? strtolower: convertir en minuscula

            //* comparar si el tipo de usuario es igual a administrador para asi mostrar otra opcion del menu que solo se le muestra si es administrador

            if ($_SESSION['tipoUsuario'] == 1) :

            ?>

                <li class="list_item">
                    <a class="enlaceMenu listUsuarios" href="usuarios.php" title="Usuarios">
                        <i class="bi bi-people-fill"></i>
                    </a>
                </li>
            <?php

            endif;

            ?>

        </ul>
        <div class="iconCerrarSesion2">
            <a href="#" class="btnCerrarSesion" title="Cerrar Sesión">
                <i class="bi bi-box-arrow-left"></i>
            </a>
        </div>
    </nav>

    <!-- MENU LATERAL QUE SE MUESTRA AL DAR CLIC EN EL BOTON MENU -->

    <nav class="menuLateral">
        <div class="logo_cont">
            <i class="bi bi-list btnIconoMenu" id="btnMenu"></i>
            <div class="logo">
                <a href="inicio.php">
                    <img src="../../iconos/logoPlahot2.png" alt="Icono PLAHOT">
                </a>
            </div>
        </div>
        <ul class="list_MenuDesplegable">
            <li class="list_itemDesplegable">
                <a class="enlaceMenu2" href="inicio.php">
                    <i class="bi bi-house-door-fill"></i>
                    <span class="linksOpciones">Inicio</span>
                </a>
            </li>

            <li class="list_itemDesplegable">
                <a class="enlaceMenu2" href="recepcion.php">
                    <i class="bi bi-calendar-plus"></i>
                    <span class="linksOpciones">Recepción</span>
                </a>
            </li>

            <li class="list_itemDesplegable">
                <a class="enlaceMenu2" href="reservaciones.php">
                    <i class="bi bi-calendar-check-fill"></i>
                    <span class="linksOpciones">Historial de Reservaciones</span>
                </a>
            </li>

            <li class="list_itemDesplegable">
                <div class="enlacePrincipal" id="flechaMenuHabitaciones">
                    <a class="enlaceMenu2 menuDesplegable">
                        <i class="bi bi-list-ul"></i>
                        <span>Habitaciones</span>
                        <i class="bi bi-caret-right-fill flecha iconoHabitaciones"></i>
                    </a>
                </div>
                <ul class="submenu">
                    <li class="list_itemSecund">
                        <div class="enlaceSecundarios">
                            <a class="enlaceMenuSecund" href="regTipoHabitacion.php">
                                <i class="bi bi-pencil"></i>
                                <span>Crear tipo de habitación</span>
                            </a>
                            <a class="enlaceMenuSecund" href="tipoHabitaciones.php">
                                <i class="bi bi-card-checklist"></i>
                                <span>Listado tipo de habitaciones</span>
                            </a>
                            <a class="enlaceMenuSecund" href="habitaciones.php">
                                <i class="material-symbols-outlined">bed</i>
                                <span>Habitaciones</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </li>

            <li class="list_itemDesplegable">
                <a class="enlaceMenu2" href="clientes.php">
                    <i class="bi bi-person-lines-fill"></i>
                    <span class="linksOpciones">Clientes</span>
                </a>
            </li>

            <li class="list_itemDesplegable">
                <div class="enlacePrincipal" id="flechaMenuInventario">
                    <a class="enlaceMenu2 menuDesplegable_inventario">
                        <i class="bi bi-boxes"></i>
                        <span>Inventario</span>
                        <i class="bi bi-caret-right-fill flecha IconoInventario"></i>
                    </a>
                </div>
                <ul class="submenu">
                    <li class="list_itemSecund">
                        <div class="enlaceSecundarios">
                            <a class="enlaceMenuSecund_inventario" href="inventario_categorias.php">
                                <i class="bi bi-tags-fill"></i>
                                <span>Categorías</span>
                            </a>
                            <a class="enlaceMenuSecund_inventario" href="inventario_productos.php">
                                <i class="bi bi-bag-check-fill"></i>
                                <span>Productos</span>
                            </a>

                            <a class="enlaceMenuSecund_inventario" href="inventarioEntradas.php">
                                <i class="bi bi-box-arrow-in-down"></i>
                                <span>Entradas</span>
                            </a>

                            <a class="enlaceMenuSecund_inventario" href="inventarioSalidas.php">
                                <i class="bi bi-box-arrow-up"></i>
                                <span>Salidas</span>
                            </a>

                            <?php
                            if ($_SESSION['tipoUsuario'] == 1):
                            ?>
                                <a class="enlaceMenuSecund_inventario" href="inventarioAdministrarPuntoVenta.php">
                                    <i class="bi bi-box-seam-fill"></i>
                                    <span>Punto de venta</span>
                                </a>
                            <?php
                            else:
                            ?>
                                <a class="enlaceMenuSecund_inventario" href="inventarioLoginPuntoVenta.php">
                                    <i class="bi bi-box-seam-fill"></i>
                                    <span>Punto de venta</span>
                                </a>
                            <?php
                            endif;
                            ?>
                        </div>
                    </li>
                </ul>
            </li>

            <?php if ($_SESSION['tipoUsuario'] == 1) : ?>
                <li class="list_itemDesplegable">
                    <a class="enlaceMenu2" href="usuarios.php">
                        <i class="bi bi-people-fill"></i>
                        <span class="linksOpciones">Usuarios</span>
                    </a>
                </li>
            <?php endif; ?>
        </ul>

        <div class="iconCerrarSesion">
            <a href="#" class="btnCerrarSesion">
                <i class="bi bi-box-arrow-left"></i>
                <span>Cerrar Sesión</span>
            </a>
        </div>
    </nav>


    <script src="../../librerias/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.js.iife.js"></script>
    <script src="../../librerias/bootstrap5/js/bootstrap.min.js"></script>
    <script src="../../librerias/sweetAlert2/js/sweetalert2.all.min.js"></script>
    <script src="../../librerias/datatables/js/datatables.min.js"></script>
    <!-- <script src="../../librerias/datatables/js/jquery.dataTables.min.js"></script> -->
    <script src="../../librerias/select2/dist/js/select2.min.js"></script>
    <script src="../../js/scriptMenuAdmit.js"></script>
    <script src="../../js/scriptHabitacionesReservas.js"></script>
    <script src="../../js/logoBase64Roomlyn.js"></script>
    <script src="../../js/driver.js"></script>

    <script src="https://cdn.userway.org/widget.js" data-account="5f8ySwz5CA"></script>

</body>

</html>