<?php

include "../procesos/config/conex.php";

$sql = $dbh->prepare("SELECT id_rol  FROM usuarios WHERE id_rol = 1"); // consulta sobre el tipo de usuario

$sql->execute();

$validarTipoUsuario = false;

if ($sql->fetch()) { // si ya existe un administrador en el tipo de usuario entonces pasa a true la variable
    $validarTipoUsuario = true;
}

$sql2 = "SELECT id_tipoDocumento, documento FROM tipo_documento WHERE 1";

?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../iconos/logo_icono.png">
    <link rel="stylesheet" href="../librerias/bootstrap-icons-1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/estilosRegistroUsuarios.css">
    <title>Registro</title>
</head>

<body>

    <!-- FORMULARIO DE REGISTRAR A LOS USUARIOS  -->

    <div class="contenedorPrincipal">
        <div class="fondoRegistro">
            <img src="../img/fondoRegistro.png" alt="Foto">
        </div>

    <?php
        if($validarTipoUsuario){
            ?>
                <a href="../vistas/vistasAdmin/usuarios.php"><i class="bi bi-arrow-bar-left"></i> REGRESAR</a>
            <?php
       }else{
        ?>
                 <a href="login.php"><i class="bi bi-arrow-bar-left"></i> REGRESAR</a>
            <?php
       }
    ?>

        <div class="contenedorRegistro">

            <h1>REGISTRO</h1>

            <form class="formularioRegistro" action="../procesos/registroUsuario/conRegistrarUsuarios.php" method="post" id="form">

                <div class="grupoPrimerNombre" id="grupoPrimerNombre">
                    <label for="pNombre">Primer Nombre*</label>
                    <input class="formularioInput" type="text" placeholder="Primer nombre" name="primerNombre" id="pNombre" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Ingresa solo texto">
                    <p></p>
                </div>

                <div class="grupoSegundoNombre" id="grupoSegundoNombre">
                    <label for="sNombre">Segundo Nombre</label>
                    <input class="formularioInput" type="text" placeholder="Segundo nombre" name="segundoNombre" id="sNombre" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Ingresa solo texto">
                    <!-- <p class="inputError">Llena este campo</p> -->
                </div>

                <div class="grupoPrimerApellido" id="grupoPrimerApellido">
                    <label for="pApellido">Primer Apellido*</label>
                    <input class="formularioInput" type="text" placeholder="Primer apellido" name="primerApellido" id="pApellido" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Ingresa solo texto" required>
                    <p></p>
                </div>

                <div class="grupoSegundoApellido" id="grupoSegundoApellido">
                    <label for="sApellido">Segundo Apellido</label>
                    <input class="formularioInput" type="text" placeholder="Segundo apellido" name="segundoApellido" id="sApellido" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" title="Ingresa solo texto">
                    <!-- <p class="inputError">Llena este campo</p> -->
                </div>

                <div class="grupoTipoIdentificacion" id="grupoTipoIdentificacion">
                    <label for="tDocumento">Tipo de Documento*</label>
                    <select class="formularioInput" name="tipoDocumento" id="tDocumento" required>
                        <option disabled selected value="">Seleccione</option>
                        <?php

                        foreach($dbh -> query($sql2) as $row):
                            if(strtolower($row['documento']) != "tarjeta de identidad"):
                            ?>
                                <option value="<?php echo $row['id_tipoDocumento'] ?>"><?php echo $row['documento'] ?></option>
                            <?php
                            endif;
                        endforeach;

                        ?>
                    </select>
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
                    <select class="formularioInput" name="tipoUsuario" id="deshabilitado" >
                    <?php if (!$validarTipoUsuario) {
                    ?>
                        <option value="1">Administrador</option>
                    <?php
                    } else {
                    ?>
                        <option value="2">Recepcionista</option>
                    <?php
                    } ?>
                    </select>
                    <p></p>
                </div>

                <div class="grupoUsuario" id="grupoUsuario">
                    <label for="usuario">Usuario*</label>
                    <input class="formularioInput" type="text" placeholder="Usuario" name="usuario" id="usuario" required>
                    <p></p>
                </div>

                <div class="grupoContraseña" id="grupoContraseña">
                    <label for="contraseña">Contraseña*</label>
                    <div class="inputContra">
                        <span class="verContraseña"><i class="bi bi-eye"></i></span>
                        <input class="formularioInput" type="password" placeholder="Contraseña" name="contraseña" id="contraseña" required>
                        <p></p>
                    </div>
                </div>

                <div class="grupoContraseña" id="grupoContraseña">
                    <label for="contraseña2">Confirmar Contraseña*</label>
                    <div class="inputContra">
                        <span class="verContraseña2"><i class="bi bi-eye"></i></i></span>
                        <input class="formularioInput" type="password" placeholder="Contraseña" name="contraseña2" id="contraseña2" required>
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


    <script src="../js/validarRegistroUsuario.js"></script>
    

</body>

</html>