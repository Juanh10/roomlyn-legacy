<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <?php

    $id = $_GET['idTipoHab'];
    include "listaHabitaciones.php";


    if (!empty($_GET['opServicios'])) {
        $opServicio = $_GET['opServicios'];
        $ventSelec = false;
        $aireSelec = false;

        foreach ($opServicio as $opciones) { // recorrer el arreglo de los checkbox
            if ($opciones == "ventilador") { // si seleccionó ventilador me cambia la variable boolean a true
                $ventSelec = true;
            } else if ($opciones == "aire") { // si seleccionó aire me cambia la variable boolean a true
                $aireSelec = true;
            }
        }

        if ($ventSelec && $aireSelec) :
            mostrarTituloTipo($id, $dbh);
            mostrarDatosHabitaciones("ventilador", $id, $dbh);
            mostrarDatosHabitaciones("aire", $id, $dbh);
        elseif ($ventSelec) :
            mostrarTituloTipo($id, $dbh);
            mostrarDatosHabitaciones("ventilador", $id, $dbh);
        elseif ($aireSelec) :
            mostrarTituloTipo($id, $dbh);
            mostrarDatosHabitaciones("aire", $id, $dbh);
        endif;
    } else {
        mostrarTituloTipo($id, $dbh);
        mostrarDatosHabitaciones("ventilador", $id, $dbh);
        mostrarDatosHabitaciones("aire", $id, $dbh);
    }

    ?>

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
                        <li><a href="https://wa.link/ys192u" class="what" target="_blank" title="Whatsapp"><i class="bi bi-whatsapp"></i></a></li>
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