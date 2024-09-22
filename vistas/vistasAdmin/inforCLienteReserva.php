<?php

include_once "../../procesos/config/conex.php";

$idCliente = $_GET['id'];

$sql = "SELECT info_clientes.documento, info_clientes.nombres, info_clientes.apellidos, info_clientes.celular, info_clientes.sexo, info_clientes.email, info_clientes.estadoRegistro, info_clientes.id_nacionalidad, info_clientes.id_departamento, info_clientes.id_municipio, nacionalidades.nacionalidad, departamentos.departamento, municipios.municipio FROM info_clientes INNER JOIN nacionalidades ON info_clientes.id_nacionalidad = nacionalidades.id_nacionalidad INNER JOIN departamentos ON info_clientes.id_departamento = departamentos.id_departamento INNER JOIN municipios ON info_clientes.id_municipio = municipios.id_municipio WHERE info_clientes.id_info_cliente = ".$idCliente."";

$resultado = $dbh->query($sql)->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>

<body>

    <main class="container">

        <?php

        if ($resultado != false) :
        ?>
            <div class="informacionCliente">
                <h1 class="fs-3 text-center mb-3">Información del cliente</h1>

                <p><span class="pInforCLi">Nombre:</span> <?php echo $resultado['nombres'] . " " . $resultado['apellidos'] ?></p>
                <p><span class="pInforCLi">Documento:</span> <?php echo $resultado['documento'] ?></p>
                <p><span class="pInforCLi">Celular:</span> <?php echo $resultado['celular'] ?></plass=>
                <p> <span class="pInforCLi">Sexo:</span> <?php echo $resultado['sexo'] ?></ps=>
                <p> <span class="pInforCLi">email:</span> <?php echo $resultado['email'] ?></p>
                <p> <span class="pInforCLi">Nacionalidad:</span> <?php echo $resultado['nacionalidad'] ?></p>
                <p> <span class="pInforCLi">Departamento:</span> <?php echo $resultado['departamento'] ?></p>
                <p> <span class="pInforCLi">Ciudad de origen:</span> <?php echo $resultado['municipio'] ?></p>
            </div>
        <?php   
        else :
        ?>
            <span>No se encontraron registros</span>
        <?php
        endif;

        ?>
    </main>

</body>

</html>