<?php
session_start();

if (empty($_SESSION['id_empleado'])) { //* Si el id del usuario es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

/* CONSULTAS */

$sqlTotal = "SELECT SUM(total_reserva) AS ingresos_totales FROM reservas WHERE id_estado_reserva = 4 AND MONTH(fecha_sys) = MONTH(CURRENT_DATE());";
$resultTotal = $dbh->query($sqlTotal)->fetch();

$sqlHab = "SELECT COUNT(*) AS habitaciones_totales FROM habitaciones";
$resulHab = $dbh->query($sqlHab)->fetch();

$sqlCliente = "SELECT COUNT(*) AS clientes_totales FROM clientes_registrados";
$resulCli = $dbh->query($sqlCliente)->fetch();

$sqlEm = "SELECT COUNT(*) AS empleados_totales FROM empleados";
$resultEm = $dbh->query($sqlEm)->fetch();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php require_once "menuAdmin.php"; ?>
    <title>Inicio</title>
</head>

<body>

    <main class="contenido">
        <div class="container">
            <div class="row mb-4">
                <!-- INGRESOS TOTALES -->
                <div class="col-md-3">
                    <div class="card tarjeta">
                        <div class="numero-cant">$<?php echo number_format($resultTotal['ingresos_totales'], 0, ',', '.') ?></div>
                        <p class="card-text">Ingresos mensuales</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card tarjeta">
                        <div class="numero-cant"><?php echo $resulHab['habitaciones_totales'] ?></div>
                        <p class="card-text">Total de habitaciones</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card tarjeta">
                        <div class="numero-cant"><?php echo $resulCli['clientes_totales'] ?></div>
                        <p class="card-text">Total de clientes registrados</p>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card tarjeta">
                        <div class="numero-cant"><?php echo $resultEm['empleados_totales'] ?></div>
                        <p class="card-text">Total de Recepcionistas</p>
                    </div>
                </div>
            </div>

            <div class="row mx-3 text-center">
                <div class="col contenidoPrincipal">
                    <div class="grafica d-flex justify-content-center">
                        <div class="col-md-4">
                            <select class="form-select" name="mesHab" id="mesHab" aria-label="Seleccione un mes">
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-10 mx-auto">
                            <canvas id="myChart" width="200" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>


    <!-- PIE DE PAGINA -->
    <footer class="pie-de-pagina mt-4">
        <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../js/scriptInicioAdmin.js"></script>

</body>

</html>