<?php

session_start();

include_once "../../procesos/config/conex.php";


$idCliente = $_SESSION['id_cliente_registrado'];
$nombres = explode(" ", $_SESSION['nombres']);
$apellidos = explode(" ", $_SESSION['apellidos']);

$primerNombre = $nombres[0];
$primerApellido = $apellidos[0];

$sqlConsulta = "SELECT clientes_registrados.id_cliente_registrado, clientes_registrados.id_info_cliente, clientes_registrados.id_rol, clientes_registrados.usuario, clientes_registrados.estado, info_clientes.documento, info_clientes.nombres, info_clientes.apellidos, info_clientes.celular, info_clientes.sexo, info_clientes.email, info_clientes.estadoRegistro, info_clientes.id_nacionalidad, info_clientes.id_departamento, info_clientes.id_municipio, nacionalidad.nacionalidad, departamento.departamento, municipio.municipio FROM clientes_registrados INNER JOIN info_clientes ON info_clientes.id_info_cliente = clientes_registrados.id_info_cliente INNER JOIN nacionalidad ON info_clientes.id_nacionalidad = nacionalidad.id_nacionalidad INNER JOIN departamento ON info_clientes.id_departamento = departamento.id_departamento INNER JOIN municipio ON info_clientes.id_municipio = municipio.id_municipio WHERE clientes_registrados.id_cliente_registrado = " . $idCliente . " AND clientes_registrados.estado = 1";

$rowConsulta = $dbh->query($sqlConsulta)->fetch();

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include "dependencias.php" ?>
    <title>Gestionar datos</title>
</head>

<body>

    <div class="contenedorPreloader" id="onload">
        <div class="lds-default">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- MENU PRINCIPAL -->

    <header class="cabecera">
        <div class="contenedor navContenedor">
            <div class="logoPlahot">
                <a href="../../index.php"><img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web"></a>
            </div>
            <div class="menuRespon">
                <div class="icono">
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
            <nav class="navegacion">
                <ul>
                    <li class="inicioSesionCliente" title="Conectado">
                        <a href="configuracionCuenta.php" class="inicioSesion"><span class="conexion"></span><?php echo $primerNombre . " " . $primerApellido ?></a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="container contenedorPrincipal">
            <h1>Gestionar datos</h1>

            <form class="formularioRegistro" action="../../procesos/registroClientes/conActualizarClientes.php" method="post" id="form">

                <input type="hidden" name="idCliente" id="idCliente" value="<?php echo $idCliente ?>">

                <div class="grupoNombres" id="grupoNombres">
                    <label for="pNombre">Nombres*</label>
                    <input class="formularioInput form-control" type="text" placeholder="Nombres" name="nombres" id="nombres" pattern="[A-Za-z\s]+" title="Ingresa solo texto" value="<?php echo $rowConsulta['nombres'] ?>" required>
                    <p></p>
                </div>

                <div class="grupoApellidos" id="grupoApellidos">
                    <label for="pApellido">Apellidos*</label>
                    <input class="formularioInput form-control" type="text" placeholder="Apellidos" name="apellidos" id="apellidos" pattern="[A-Za-z\s]+" title="Ingresa solo texto" value="<?php echo $rowConsulta['apellidos'] ?>" required>
                    <p></p>
                </div>

                <div class="grupoDocumento" id="grupoDocumento">
                    <label for="documento">Documento*</label>
                    <input class="formularioInput form-control" type="text" name="documento" id="documento" placeholder="Documento" maxlength="15" pattern="[0-9]*" title="Ingresa solo números" value="<?php echo $rowConsulta['documento'] ?>" required>
                    <p></p>
                </div>

                <div class="grupoCelular" id="grupoCelular">
                    <label for="nCelular">Teléfono*</label>
                    <input class="formularioInput form-control" type="text" name="celular" id="nCelular" placeholder="Celular" maxlength="15" pattern="[0-9]*" title="Ingresa solo números" value="<?php echo $rowConsulta['celular'] ?>" required>
                    <p></p>
                </div>

                <div class="grupoEmail" id="grupoEmail">
                    <label for="email">Email*</label>
                    <input class="formularioInput form-control" type="email" name="email" id="email" placeholder="Email" value="<?php echo $rowConsulta['email'] ?>" required>
                    <p></p>
                </div>

                <div class="grupoSexo" id="grupoSexo">
                    <label for="deshabilitado">Sexo*</label>
                    <select class="formularioInput" name="sexo">
                        <?php

                        if (strtolower($rowConsulta['sexo']) == "masculino") :
                        ?>
                            <option value="Masculino" selected>Masculino</option>
                            <option value="Femenino">Femenino</option>
                        <?php
                        else :
                        ?>
                            <option value="Femenino" selected>Femenino</option>
                            <option value="Masculino">Masculino</option>
                        <?php
                        endif;

                        ?>
                    </select>
                    <p></p>
                </div>

                <div class="grupoNacionalidad" id="grupoNacionalidad">
                    <label for="nacionalidad">Nacionalidad</label>
                    <select class="formularioInput" name="nacionalidad" id="nacionalidad" required>
                        <option value="<?php echo $rowConsulta['id_nacionalidad'] ?>"><?php echo $rowConsulta['nacionalidad'] ?></option>
                        <?php
                        $sqlNacionalidad = "SELECT id_nacionalidad, nacionalidad FROM nacionalidad WHERE 1";

                        foreach ($dbh->query($sqlNacionalidad) as $rowNacionalidad) :
                            if ($rowNacionalidad['id_nacionalidad'] != 1 && $rowNacionalidad['id_nacionalidad'] != $rowConsulta['id_nacionalidad']) :
                        ?>
                                <option value="<?php echo $rowNacionalidad['id_nacionalidad'] ?>"><?php echo $rowNacionalidad['nacionalidad'] ?></option>
                        <?php
                            endif;
                        endforeach;

                        ?>
                    </select>
                </div>

                <div class="grupoDepartamento" id="grupoDepartamento">
                    <label for="departamento">Departamento</label>
                    <select class="formularioInput" name="departamento" id="departamento" required>

                    </select>
                </div>

                <div class="grupoCiudad" id="grupoCiudad">
                    <label for="ciudad">Ciudad de origen</label>
                    <select class="formularioInput" name="ciudad" id="ciudad" required>

                    </select>
                </div>

                <div class="formularioMensaje">
                    <p><i class="bi bi-exclamation-circle-fill"></i>¡Por favor rellene los campos correctamente!</p>
                </div>

                <div class="btnRegistrar">
                    <input class="btnInput" type="submit" value="Actualizar">
                </div>

            </form>
        </div>
    </main>

    <!--* PIE DE PAGINA -->

    <footer>
        <div class="piePagina">
            <div class="copyPiePagina">
                <div class="logoPiePagina">
                    <img src="../../iconos/logoPlahot2.png" alt="Logo de la plataforma web">
                </div>
                <p>Copyright 2023 ROOMLYN | Todos los derechos reservados</p>
            </div>
            <div class="contenidoPiePagina">
                <div class="redes-sociales">
                    <ul>
                        <li><a href="https://www.facebook.com/profile.php?id=61550262616792" class="face" target="_blank" title="Facebook"><i class="bi bi-facebook"></i></a></li>
                        <li><a href="https://www.instagram.com/hotelcolonialci2/" class="insta" target="_blank" title="Instagram"><i class="bi bi-instagram"></i></a></li>
                        <li><a href="https://www.tiktok.com/@colonialespinal2023" class="what" target="_blank" title="Whatsapp"><i class="bi bi-whatsapp"></i></a></li>
                        <li><a href="https://www.tiktok.com/@colonialespinal2023" class="tiktok" target="_blank" title="Tik tok"><i class="bi bi-tiktok"></i></a></li>
                    </ul>
                </div>
                <div class="contPreguntas">
                    <a href="../../comoFunciona.html">Como funciona ROOMLYN</a>
                    <a href="#">Politicas de privacidad</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- ALERTAS -->

    <?php

    if (isset($_SESSION['msjAct'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '<?php echo $_SESSION['msjAct']; ?>',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    <?php
        unset($_SESSION['msjAct']);
    endif;

    ?>



</body>

</html>