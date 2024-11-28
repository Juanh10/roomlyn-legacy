<?php
session_start();

if (empty($_SESSION['id_caja'])) { //* Si el id de la caja es vacio es porque esta intentando ingresar sin iniciar sesion
    header("location: inicio.php");
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caja Abierta</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../css/estilosMenuAdmin.css">
    <link rel="stylesheet" href="../../css/estilosPlataformaAdmin.css">
    <link rel="stylesheet" href="../../css/estilosReservasAdmin.css">
    <style>
        .product-card {
            width: 350px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 10px;
        }

        .contenedorImagen{
            width: 150px;
            height: 100px;
        }

        .contenedorImagen img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item {
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 16px;
        }
    </style>
</head>

<body>
    <!--* CABECERA DEL MENU  -->

    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" style="background-color: #86726b;">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link fw-bold active" aria-current="page" href="#"><?php echo $_SESSION['nombre_caja'] ?></a>
                    </li>
                </ul>
                <div class="ms-auto">
                    <span class="navbar-text">
                        <?php echo $_SESSION['pNombre'] . " " . $_SESSION['pApellido']; ?>
                    </span>
                </div>
            </div>
        </div>
    </nav>

    <div class="container-fluid my-4 mt-5 pt-5">
        <div class="row">
            <div class="col-md-8">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Buscar" aria-label="Buscar" aria-describedby="button-addon2">
                    <button class="btn botonRoomlyn" type="button" id="button-addon2">Buscar</button>
                </div>
                <div class="row row-cols-1 row-cols-md-2 g-4">
                    <div class="col">
                        <div class="product-card d-flex">
                            <div class="contenedorImagen">
                                <img src="https://via.placeholder.com/150" class="card-img-top" alt="Producto 1">
                            </div>
                            <div class="card-body ms-4">
                                <h5 class="card-title">Producto 1</h5>
                                <p class="card-text">$67.00</p>
                                <a href="#" class="btn botonRoomlyn">Agregar al carrito</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="cart-item mb-3">
                    <h5 class="mb-3">Carrito</h5>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <span>Vaso</span>
                        <div class="d-flex align-items-center">
                            <button class="btn btn-sm btn-outline-secondary">-</button>
                            <span class="mx-2">1</span>
                            <button class="btn btn-sm btn-outline-secondary">+</button>
                        </div>
                        <span>$50000</span>
                    </div>
                    <!-- Agrega más elementos del carrito aquí -->
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <strong>Total</strong>
                        <strong>$131.08</strong>
                    </div>
                    <button class="btn botonRoomlyn w-100 mt-3">Pagar $131000</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>