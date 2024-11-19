<?php

include_once "../../procesos/config/conex.php";

$idHab = $_GET['id'];

$sql = "SELECT habitaciones.id_habitacion, habitaciones.id_servicio, habitaciones.nHabitacion, habitaciones.id_hab_tipo, habitaciones.tipoCama, habitaciones.id_hab_estado, habitaciones.observacion, habitaciones_estado.estado_habitacion, habitaciones_tipos.tipoHabitacion, habitaciones_tipos.cantidadCamas FROM habitaciones INNER JOIN habitaciones_estado ON habitaciones.id_hab_estado = habitaciones_estado.id_hab_estado INNER JOIN habitaciones_tipos ON habitaciones.id_hab_tipo = habitaciones_tipos.id_hab_tipo WHERE habitaciones.id_habitacion = " . $idHab . ""; // consulta sobre todos los datos de las habitaciones

$sql2 = "SELECT id_hab_tipo, tipoHabitacion FROM habitaciones_tipos WHERE 1 AND estado = 1"; // consulta de los tipos de habitaciones

// consulta para obtener los servicios que estan relacionados con el tipo de habitacion
$sqlServicios = "SELECT habitaciones_elementos_selec.id_hab_tipo_elemento, habitaciones_elementos_selec.id_habitacion, habitaciones_elementos.elemento, habitaciones_elementos.id_hab_elemento, habitaciones_elementos_selec.estado FROM habitaciones_elementos_selec INNER JOIN habitaciones_elementos ON habitaciones_elementos_selec.id_hab_elemento = habitaciones_elementos.id_hab_elemento WHERE habitaciones_elementos_selec.estado = 1 AND habitaciones_elementos_selec.id_habitacion = " . $idHab . "";

?>

<!DOCTYPE html>

<body>

    <div class="container mb-4">
        <div class="row">
            <span class="btnVolverHab">
                < Volver</span>
                    <div class="col-md-7 me-5 ">
                        <h1 class="tituloPrincipal mb-4">Editar habitación</h1>
                        <div class="formEditHab formularioRegTipoHabi">
                            <form action="../../procesos/registroHabitaciones/registroHabi/conActualizarHabitaciones.php" id="formEditarHab" method="post">
                                <?php
                                foreach ($dbh->query($sql) as $rowHab) : // mostrar datos
                                ?>
                                    <input type="hidden" name="idHab" value="<?php echo $idHab ?>">
                                    <label for="numHabitacion" class="borrar">Número de la habitación</label>
                                    <input type="number" class="form-control mt-2" min="0" name="numHabitacion" id="numHabitacionEdit" value="<?php echo $rowHab['nHabitacion'] ?>" required>
                                    <p></p>

                                    <label for="tipoHabEdit" class="mt-2">Tipo de habitación</label>
                                    <select class="form-select mt-2 mb-3" name="tipoHab" id="tipoHabEdit" required>
                                        <option selected value="<?php echo $rowHab['id_hab_tipo'] ?>"><?php echo $rowHab['tipoHabitacion'] ?></option>
                                        <?php
                                        foreach ($dbh->query($sql2) as $rowTipo) :
                                            if ($rowHab['id_hab_tipo'] != $rowTipo['id_hab_tipo']) :
                                        ?>
                                                <option value="<?php echo $rowTipo['id_hab_tipo'] ?>"><?php echo $rowTipo['tipoHabitacion'] ?></option>
                                        <?php
                                            endif;
                                        endforeach;
                                        ?>
                                    </select>
                                    <p></p>

                                    <div id="addSelect">
                                        <?php
                                        include "editTipoCama.php";
                                        ?>
                                    </div>

                                    <label class="mt-2" for="serv">Sistema de climatización</label>
                                    <select class="form-select mt-2" name="sisClimatizacion" id="sisClimatizacionEdit" required>
                                        <?php
                                        if ($rowHab['id_servicio'] == 1) :
                                        ?>
                                            <option value="1" selected>Ventilador</option>
                                            <option value="2">Aire acondicionado</option>
                                        <?php
                                        else :
                                        ?>
                                            <option value="2" selected>Aire acondicionado</option>
                                            <option value="1">Ventilador</option>
                                        <?php
                                        endif;
                                        ?>
                                    </select>
                                    <p></p>

                                    <label for="observaciones" class="mt-2">Observaciones</label>
                                    <textarea class="form-control mt-2 mb-3" name="observaciones" id="observacionesEdit" required><?php echo $rowHab['observacion'] ?></textarea>
                                    <p class=""></p>
                                <?php
                                endforeach;
                                ?>
                                <input type="submit" class="botonActualizar" name="btnActualizar" value="Actualizar Datos">
                            </form>
                            <button type="button" class="btn bg-primary-subtle w-100 mt-2" data-bs-toggle="modal" data-bs-target="#modalEditNFC">
                                Actualizar llavero NFC
                            </button>
                        </div>
                    </div>
                    <div class="col-4 responsiveServicios">

                        <div class="serviciosHabitaciones">
                            <h1 class="tituloServicios mb-10"><i class="bi bi-check-square"></i> Elementos</h1>
                            <ul class="listaServTipo ">
                                <div class="elementosHabitacion">
                                    <?php
                                    // mostrar datos de los servicios
                                    foreach ($dbh->query($sqlServicios) as $rowServ) :
                                    ?>
                                        <li class="border border-bottom"><span><?php echo $rowServ['elemento'] ?></span>
                                            <form id="formEliminarServicio">
                                                <input type="hidden" name="idTipoHab" id="tipoHab<?php echo $idHab ?>" value="<?php echo $idHab ?>">
                                                <input type="hidden" name="idServicio" id="idServicio<?php echo $rowServ['id_hab_tipo_elemento'] ?>" value="<?php echo $rowServ['id_hab_tipo_elemento'] ?>">
                                                <button type="button" name="btnElmServ" title="Deshabilitar"><i class="bi bi-trash"></i></button>
                                            </form>
                                        </li>
                                    <?php
                                    endforeach;
                                    ?>
                                </div>
                                <li class="btnAñadirServ" id="btnAddServ3" title="Añadir servicio"><button data-bs-toggle="modal" data-bs-target="#modalAddServ3" id="<?php echo $rowHab['id_habitacion'] ?>">Añadir</button></li>
                            </ul>
                        </div>

                    </div>
        </div>
    </div>


    <!-- MODAL DE AÑADIR MAS SERVICIOS-->

    <div class="modal fade" id="modalAddServ3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header fondo-modal">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Añadir servicios</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="contenidoModalAddServ3"></div>
            </div>
        </div>
    </div>

    <!-- MODAL PARA REGISTRAR NFC -->

    <div class="modal fade" id="modalEditNFC" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="llaveroNfc">
                            <label for="codNfc">Acerque el llavero al sensor</label>
                            <input type="hidden" id="idHabitacionNFC" name="idHab" value="<?php echo $idHab ?>">
                            <input type="text" id="codNfc" name="codigoNfc" autocomplete="off">
                        <div class="icono-llaveroNfc">
                            <img src="../../iconos/iconoNfc.png" alt="Icono de llavero NFC">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../js/validarEdicionHab.js"></script>
    <script src="../../js/scriptModalAdmit.js"></script>

    <script>
        // Manejar el clic en el botón de eliminación
        $(".serviciosHabitaciones").on("click", "[name='btnElmServ']", function() {
            // Obtener los datos necesarios para la solicitud AJAX
            var idTipoHab = $(this).closest("li").find("[name='idTipoHab']").val();
            var idServicio = $(this).closest("li").find("[name='idServicio']").val();

            // Realizar la solicitud AJAX
            $.ajax({
                type: "POST",
                url: "../../procesos/registroHabitaciones/registroHabi/conElementosHab.php",
                data: {
                    btnElmServ: true,
                    idTipoHab: idTipoHab,
                    idServicio: idServicio
                },
                success: function(response) {
                    // Actualizar la sección de servicios con la respuesta del servidor
                    $(".elementosHabitacion").html(response);
                },
                error: function() {
                    alert("Error al enviar la solicitud AJAX");
                }
            });
        });


        const btnAddServ3 = $('#btnAddServ3');
        const contenidoModalAddServ3 = $('#contenidoModalAddServ3');

        btnAddServ3.click(function(e) {
            let idTipoHab = e.target.id;

            // Datos para enviar
            let datos = new FormData();
            datos.append('idTipoHab', idTipoHab);

            fetch('mostrarElementohab.php', {
                    method: 'POST',
                    body: datos,
                })
                .then(response => response.text())
                .then(data => {
                    // Manipula los datos recibidos (si es necesario)
                    contenidoModalAddServ3.html(data);
                })
                .catch(error => {
                    console.error('Error en la solicitud fetch:', error);
                });
        });

        $('.btnVolverHab').click(function() {

            location.reload();

        });
    </script>




</body>

</html>