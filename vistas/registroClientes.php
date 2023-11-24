<?php

session_start();

include_once "../procesos/config/conex.php";

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../iconos/logo_icono.png">
    <link rel="stylesheet" href="../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../librerias/select2/dist/css/select2.min.css">
    <link rel="stylesheet" href="../css/estilosRegistroUsuarios.css">
    <link rel="stylesheet" href="../librerias/sweetAlert2/css/sweetalert2.min.css">
    <script src="../librerias/sweetAlert2/js/sweetalert2.all.min.js"></script>
    <title>Registro</title>
</head>

<body>

    <!-- FORMULARIO DE REGISTRO DE LOS CLIENTES  -->

    <div class="contenedorPrincipal">
        <div class="fondoRegistro">
            <img src="../img/fondoRegistro.png" alt="Foto">
        </div>

        <a href="login.php"><i class="bi bi-arrow-bar-left"></i> REGRESAR</a>

        <div class="contenedorRegistro">

            <h1>REGISTRO</h1>

            <form class="formularioRegistro" action="../procesos/registroClientes/conRegistroClientes.php" method="post" id="form">

                <div class="grupoNombres" id="grupoNombres">
                    <label for="pNombre">Nombres*</label>
                    <input class="formularioInput" type="text" placeholder="Nombres" name="nombres" id="nombres" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Ingresa solo texto" required>
                    <p></p>
                </div>

                <div class="grupoApellidos" id="grupoApellidos">
                    <label for="pApellido">Apellidos*</label>
                    <input class="formularioInput" type="text" placeholder="Apellidos" name="apellidos" id="apellidos" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Ingresa solo texto" required>
                    <p></p>
                </div>

                <div class="grupoDocumento" id="grupoDocumento">
                    <label for="documento">Documento*</label>
                    <input class="formularioInput" type="text" name="documento" id="documento" placeholder="Documento" maxlength="15" pattern="[0-9]*" title="Ingresa solo números" required>
                    <p></p>
                </div>

                <div class="grupoCelular" id="grupoCelular">
                    <label for="nCelular">Teléfono*</label>
                    <input class="formularioInput" type="text" name="celular" id="nCelular" placeholder="Celular" maxlength="15" pattern="[0-9]*" title="Ingresa solo números" required>
                    <p></p>
                </div>

                <div class="grupoEmail" id="grupoEmail">
                    <label for="email">Email*</label>
                    <input class="formularioInput" type="email" name="email" id="email" placeholder="Email" required>
                    <p></p>
                </div>

                <div class="grupoTipoUsuario" id="grupoTipoUsuario">
                    <label for="deshabilitado">Tipo de usuario*</label>
                    <select class="formularioInput" name="tipoUsuario" id="deshabilitado">
                        <option value="3">Cliente</option>
                    </select>
                    <p></p>
                </div>

                <div class="grupoSexo" id="grupoSexo">
                    <label for="deshabilitado">Sexo*</label>
                    <select class="formularioInput" name="sexo" id="sexo">
                        <option selected disabled value="">Escoja una opción</option>
                        <option value="Masculino">Masculino</option>
                        <option value="Femenino">Femenino</option>
                    </select>
                    <p></p>
                </div>

                <div class="grupoNacionalidad" id="grupoNacionalidad">
                    <label for="nacionalidad">Nacionalidad</label>
                    <select class="formularioInput" name="nacionalidad" id="nacionalidad" required>
                        <option selected disabled value="">Escoja una opción</option>
                        <?php
                        $sqlNacionalidad = "SELECT id_nacionalidad, nacionalidad FROM nacionalidades WHERE 1";

                        foreach ($dbh->query($sqlNacionalidad) as $rowNacionalidad) :
                            if ($rowNacionalidad['id_nacionalidad'] != 1) :
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

                <div class="grupoContraseña" id="grupoContraseña">
                    <label for="contraseña">Contraseña*</label>
                    <div class="inputContra">
                        <span class="verContraseña"><i class="bi bi-eye"></i></span>
                        <input class="formularioInput" type="password" placeholder="Contraseña" name="contrasena" id="contrasena" required>
                        <p></p>
                    </div>
                </div>

                <div class="grupoContraseña" id="grupoContraseña">
                    <label for="contraseña2">Confirmar Contraseña*</label>
                    <div class="inputContra">
                        <span class="verContraseña2"><i class="bi bi-eye"></i></i></span>
                        <input class="formularioInput" type="password" placeholder="Contraseña" name="contrasena2" id="contrasena2" required>
                        <p></p>
                    </div>
                </div>

                <div class="formularioMensaje">
                    <p><i class="bi bi-exclamation-circle-fill"></i>¡Por favor rellene los campos correctamente!</p>
                </div>

                <div class="btnRegistrar">
                    <input class="btnInput" type="submit" value="Registrar">
                </div>

            </form>
        </div>
    </div>

    <!-- ALERTAS -->

    <?php

    if (isset($_SESSION['msjError'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'error',
                title: '¡Ocurrió un error!',
                text: '<?php echo $_SESSION['msjError']; ?>',
                showConfirmButton: true
            });
        </script>
    <?php
        unset($_SESSION['msjError']);
    endif;

    if (isset($_SESSION['msjExito'])) :
    ?>
        <script>
            Swal.fire({
                position: '',
                icon: 'success',
                title: '<?php echo $_SESSION['msjExito']; ?>',
                showConfirmButton: false,
                timer: 1000
            });
        </script>
    <?php
        unset($_SESSION['msjExito']);
    endif;

    ?>

    <script src="../librerias/jquery-3.7.0.min.js"></script>
    <script src="../librerias/select2/dist/js/select2.min.js"></script>
    <script src="../js/scriptClientes.js"></script>
    <script src="../js/validarRegistroClientes.js"></script>

    <script src="https://cdn.userway.org/widget.js" data-account="5f8ySwz5CA"></script>

    <script>
        window.addEventListener('mouseover', initLandbot, {
            once: true
        });
        window.addEventListener('touchstart', initLandbot, {
            once: true
        });
        var myLandbot;

        function initLandbot() {
            if (!myLandbot) {
                var s = document.createElement('script');
                s.type = 'text/javascript';
                s.async = true;
                s.addEventListener('load', function() {
                    var myLandbot = new Landbot.Livechat({
                        configUrl: 'https://storage.googleapis.com/landbot.online/v3/H-1781515-UV9UMH34F70SNUM3/index.json',
                    });
                });
                s.src = 'https://cdn.landbot.io/landbot-3/landbot-3.0.0.js';
                var x = document.getElementsByTagName('script')[0];
                x.parentNode.insertBefore(s, x);
            }
        }
    </script>

</body>

</html>