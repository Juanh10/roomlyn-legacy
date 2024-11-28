<?php
session_start();

if (empty($_SESSION['id_empleado'])) {
    header("location: ../login.php");
}

include_once "../../procesos/config/conex.php";

$sql = "SELECT id_punto_venta, nombre FROM inventario_punto_venta WHERE estado = 1";
$stmt = $dbh->prepare($sql);
$stmt->execute();
$cajas = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Caja Punto de Venta</title>

    <!-- Estilos de Bootstrap y otros -->
    <link rel="icon" href="../../iconos/logo_icono.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@1.0.1/dist/driver.css" />
    <link rel="stylesheet" href="../../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../../librerias/bootstrap5/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../librerias/sweetAlert2/css/sweetalert2.min.css">
    <link rel="stylesheet" href="../../librerias/datatables/css/datatables.min.css">
    <link rel="stylesheet" href="../../librerias/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../../css/estilosMenuAdmin.css">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <link rel="stylesheet" href="../../css/estilosReservasAdmin.css">

    <style>
        body {
            background: linear-gradient(to top, #86726B, #53433f);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            max-width: 400px;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #9d8070;
            color: white;
            font-size: 1.5rem;
            border-top-left-radius: 12px;
            border-top-right-radius: 12px;
            padding: 20px;
        }

        .card-body {
            background-color: #b59f93;
            padding: 30px;
            border-bottom-left-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .form-label {
            font-weight: 600;
        }

        .btn {
            background-color: #76645d;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
        }

        .btn:hover {
            background-color: #5a4a3b;
        }

        .form-select,
        .form-control {
            border-radius: 8px;
        }

        .container {
            max-width: 100%;
        }
    </style>
</head>

<body>
    <div class="container d-flex justify-content-center">
        <div class="card border border-0">
            <div class="card-header text-center">
                <h3 class="my-2">Acceso a Punto de Venta</h3>
            </div>
            <div class="card-body">
                <form action="../../procesos/inventario/punto_venta/conLoginPuntoVenta.php" method="POST">
                    <input type="hidden" value="<?php echo $_SESSION['id_empleado'] ?>" name="usuario">
                    <div class="mb-3">
                        <label for="caja" class="form-label">Seleccionar Caja</label>
                        <select class="form-select" id="caja" name="caja" required>
                            <option value="" disabled selected>Seleccione una caja...</option>
                            <?php foreach ($cajas as $caja): ?>
                                <option value="<?php echo $caja['id_punto_venta']; ?>"><?php echo $caja['nombre']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Introduce la contraseña" required>
                    </div>

                    <button type="submit" class="btn w-100">Iniciar sesión</button>
                </form>
            </div>
        </div>
    </div>

    <?php

    if (isset($_SESSION['msjExito'])) :
    ?>
        <div class="alert alert-success alerta" role="alert">
            <strong><i class="bi bi-check-circle-fill"></i><?php echo $_SESSION['msjExito'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjExito']);
    endif;

    if (isset($_SESSION['msjError'])) :
    ?>
        <div class="alert alert-danger alerta" role="alert">
            <strong><i class="bi bi-exclamation-triangle-fill"></i><?php echo $_SESSION['msjError'] ?></strong>
        </div>
    <?php
        unset($_SESSION['msjError']);
    endif;

    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-0iP8SXTnIAqF1BI3lgWouAN42mRzdbV9nn6e1QmnZsCoJWZjxxn1yRdVEebayDZ0" crossorigin="anonymous"></script>
</body>

</html>