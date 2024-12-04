$(document).ready(function () {
    const formCategorias = $('#formularioCategorias');
    const formEditCategorias = $('#formularioEditCategorias');
    const msjError = $('.errorValidacion');


    //* CATEGORIAS

    // Inicializar la tabla como instancia de DataTables
    let tablaCat = $('#tablaCategorias').DataTable({
        "order": [],
        "bSort": false,
        "lengthMenu": [5, 10, 20, 30],
        responsive: true,
        language: {
            "decimal": ",",
            "thousands": ".",
            "lengthMenu": "Mostrar _MENU_ registros",
            "info": "Total registros: _TOTAL_",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros en total)",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros",
            "emptyTable": "No hay datos disponibles en la tabla",
            "paginate": {
                "first": "<<",
                "previous": "<",
                "next": ">",
                "last": ">>"
            },
            "aria": {
                "sortAscending": ": activar para ordenar la columna de manera ascendente",
                "sortDescending": ": activar para ordenar la columna de manera descendente"
            }
        }
    });

    // Función general para enviar datos con AJAX
    function enviarFormularioAjax(metodo, datos, successCallback) {
        $.ajax({
            type: metodo,
            url: "../../procesos/inventario/categorias/conCategorias.php",
            data: datos,
            success: function (response) {
                let respuesta = JSON.parse(response);

                // Manejar diferentes tipos de operaciones
                if (metodo === 'POST') {
                    // Lógica de agregar categoría
                    if (respuesta.id) {
                        tablaCat.row.add([
                            `<div class="text-center">${respuesta.id}</div>`,
                            `<div class="text-center">${respuesta.nombre}</div>`,
                            `
                            <div class="text-center">
                                <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar btnEditarCategoria" data-id="${respuesta.id}" title="Editar"></span>
                                <form class="formEliminarCategoria d-inline">
                                    <input type="hidden" name="id_categoria" value="${respuesta.id}">
                                    <button type="submit" class="btn btn-danger btn-sm eliminarbtn" title="Deshabilitar">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                            `
                        ]).draw(false);

                        // Limpiar input
                        $('#categoria').val('');
                    }

                    // Mostrar alerta de éxito
                    Swal.fire({
                        icon: 'success',
                        title: 'Categoría agregada',
                        text: 'La categoría se ha agregado correctamente.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
                else if (metodo === 'PUT') {
                    // Lógica de editar categoría
                    if (respuesta.id) {
                        let filaIndex = tablaCat.rows().indexes().filter(function (index) {
                            return tablaCat.row(index).data()[0] == respuesta.id;
                        });

                        if (filaIndex.length > 0) {
                            let filaData = tablaCat.row(filaIndex[0]).data();
                            filaData[1] = respuesta.nombre;
                            tablaCat.row(filaIndex[0]).data(filaData).draw(false);
                        }

                        // Mostrar alerta de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Categoría actualizada',
                            text: 'La categoría se ha actualizado correctamente.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }
                else if (metodo === 'DELETE') {
                    if (respuesta.resultado) {
                        // Eliminar la fila de la tabla
                        let filaIndex = tablaCat.rows().indexes().filter(function (index) {
                            return tablaCat.row(index).data()[0] == respuesta.id;
                        });

                        if (filaIndex.length > 0) {
                            tablaCat.row(filaIndex[0]).remove().draw(false);
                        }

                        // Mostrar alerta de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Categoría deshabilitada',
                            text: 'La categoría se ha deshabilitado correctamente.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000
                        });
                    }
                }

                // Ejecutar callback si existe
                if (successCallback) {
                    successCallback();
                }
            },
            error: function (error) {
                console.error(error);

                // Mostrar alerta de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            }
        });
    }

    // Enviar formulario de agregar categoría
    formCategorias.submit(function (e) {
        e.preventDefault();
        let inputCategoria = $('#categoria').val().trim();

        if (inputCategoria === "") {
            msjError.show();
        } else {
            msjError.hide();
            enviarFormularioAjax("POST", { categoria: inputCategoria });
        }
    });

    // Editar categoría
    $('#tablaCategorias').on('click', '.btnEditarCategoria', function () {
        formCategorias.addClass('d-none');
        formEditCategorias.removeClass('d-none');

        let fila = $(this).closest('tr');
        let nombreCategoria = fila.find('td:nth-child(2)').text();
        let idCategoria = $(this).data('id');

        $('#editcategoria').val(nombreCategoria);
        $('#editcategoria').data('id', idCategoria);
    });

    // Enviar el formulario de edición
    $('#formularioEditCategorias').submit(function (e) {
        e.preventDefault();
        let inputEditCategoria = $('#editcategoria').val().trim();
        let idCategoria = $('#editcategoria').data('id');

        if (inputEditCategoria === "") {
            msjError.show();
        } else {
            msjError.hide();
            enviarFormularioAjax("PUT", {
                id_categoria: idCategoria,
                categoria: inputEditCategoria
            }, function () {
                formEditCategorias.addClass('d-none');
                formCategorias.removeClass('d-none');
            });
        }
    });

    // Volver al formulario de agregar
    $('.btnVolverHab').click(function () {
        formEditCategorias.addClass('d-none');
        formCategorias.removeClass('d-none');
    });

    // Evento para deshabilitar categoría
    $('#tablaCategorias').on('submit', '.formEliminarCategoria', function (e) {
        e.preventDefault();


        let filas = $(this).closest('tr');
        let idCategoria = filas.find('td:nth-child(1)').text();

        console.log(idCategoria);


        // Confirmación con SweetAlert
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, deshabilitar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                enviarFormularioAjax('DELETE', {
                    id_categoria: idCategoria
                });
            }
        });
    });

    // Volver a asignar eventos después de cada redibujado de la tabla
    tablaCat.on('draw', function () {
        // Eventos de edición
        $('.btnEditarCategoria').click(function () {
            formCategorias.addClass('d-none');
            formEditCategorias.removeClass('d-none');

            let fila = $(this).closest('tr');
            let nombreCategoria = fila.find('td:nth-child(2)').text();
            let idCategoria = $(this).data('id');

            $('#editcategoria').val(nombreCategoria);
            $('#editcategoria').data('id', idCategoria);
        });

        // Eventos de deshabilitar
        $('.formEliminarCategoria').submit(function (e) {
            e.preventDefault();

            let idCategoria = $(this).find('input[name="id_categoria"]').val();

            // Confirmación con SweetAlert
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No podrás revertir esta acción!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, deshabilitar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    enviarFormularioAjax('DELETE', {
                        id_categoria: idCategoria
                    });
                }
            });
        });
    });

    //* PRODUCTOS


    const formProductos = $('#formularioProducto');

    // VALIDACION DE PRODUCTOS
    formProductos.submit(function (e) {
        // Definir los campos a validar
        const campos = [
            {
                id: '#categoria_cat',
                tipo: 'select',
                error: 'Seleccione una categoría',
            },
            {
                id: '#referencia_cat',
                tipo: 'input',
                error: 'Completa este campo',
            },
            {
                id: '#nombre_cat',
                tipo: 'input',
                error: 'Completa este campo',
            },
            {
                id: '#imagen_cat',
                tipo: 'file',
                error: 'Sube un archivo de imagen válido (jpg, png, gif, bmp, webp, svg, ico)',
            },
            {
                id: '#cantidad_cat',
                tipo: 'input',
                error: 'Completa este campo con solo números',
            },
            {
                id: '#precio_cat',
                tipo: 'input',
                error: 'Completa este campo con un valor válido',
            },
        ];

        let formularioValido = true;

        // Funcion de validacion
        function validarCampo(campo) {
            const valor = $(campo.id).val();

            if (campo.tipo === 'file') {
                const archivo = $(campo.id)[0].files[0];

                // Validar si se selecciono un archivo
                /*             if (!archivo) {
                              $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                              $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                              return false;
                            } */

                // Validar tipo de extension
                const tiposValidos = [
                    'image/jpeg', 'image/png', 'image/gif',
                    'image/bmp', 'image/webp', 'image/svg+xml',
                    'image/x-icon'
                ];

                if (!tiposValidos.includes(archivo.type)) {
                    $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                    $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                    return false;
                }

                // validar otros campos
            } else if (valor === null || valor === "" || (campo.tipo === 'input' && valor.trim() === "")) {
                $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                return false;
            } else {
                $(campo.id).closest('div').find('p').eq(0).removeClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text('');
                return true;
            }

            return true;
        }

        // Validar todos los campos
        campos.forEach(function (campo) {
            if (!validarCampo(campo)) {
                formularioValido = false;
            }
        });

        // Prevenir envio del formulario si hay errores
        if (!formularioValido) {
            e.preventDefault();
        }
    });

    // EDITAR PRODUCTO
    // Evento de clic en el botón de edición
    $(".botonEditar").on("click", function () {
        const idProducto = $(this).data("id"); // Obtener el ID del data-id
        const fila = $(this).closest("tr"); // Obtener la fila del botón

        // Obtener los valores de las celdas
        const referencia = fila.find("td").eq(0).text().trim();
        const categoria = fila.find("td").eq(1).text().trim();
        const nombre = fila.find("td").eq(2).text().trim();
        const cantidad = fila.find("td").eq(3).text().trim();
        const precio = fila.find("td").eq(4).text().replace("$", "").replace(",", "").trim();
        const descripcion = fila.find("td").eq(6).text().trim();
        const imagenSrc = fila.find("td").eq(5).find("img").attr("src"); // Obtener el src de la imagen

        // Llenar los campos del formulario
        $("#id_producto").val(idProducto);
        $("#referencia_catEdit").val(referencia);
        $("#nombre_catEdit").val(nombre);
        $("#cantidad_catEdit").val(cantidad);
        $("#precio_catEdit").val(precio);
        $("#descripcion_catEdit").val(descripcion);

        // Seleccionar la categoría (si el select tiene texto)
        $("#categoria_catEdit option").filter(function () {
            return $(this).text().trim() === categoria;
        }).prop("selected", true);

        // Mostrar la imagen actual
        if (imagenSrc) {
            $("#imagenPreview").attr("src", imagenSrc).show();
        } else {
            $("#imagenPreview").hide();
        }
    });

    const formProductosEdit = $('#formularioProductoEdit');

    // VALIDACION DE PRODUCTOS
    formProductosEdit.submit(function (e) {
        // Definir los campos a validar
        const campos = [
            {
                id: '#categoria_catEdit',
                tipo: 'select',
                error: 'Seleccione una categoría',
            },
            {
                id: '#referencia_catEdit',
                tipo: 'input',
                error: 'Completa este campo',
            },
            {
                id: '#nombre_catEdit',
                tipo: 'input',
                error: 'Completa este campo',
            },
            {
                id: '#imagen_catEdit',
                tipo: 'file',
                error: 'Sube un archivo de imagen válido (jpg, png, gif, bmp, webp, svg, ico)',
            },
            {
                id: '#cantidad_catEdit',
                tipo: 'input',
                error: 'Completa este campo con solo números',
            },
            {
                id: '#precio_catEdit',
                tipo: 'input',
                error: 'Completa este campo con un valor válido',
            },
        ];

        let formularioValido = true; // Bandera de validación

        // Función de validación
        function validarCampo(campo) {
            const valor = $(campo.id).val();

            if (campo.tipo === 'file') {
                const archivo = $(campo.id)[0].files[0];

                // Validar si se seleccionó un archivo
                /* if (!archivo) {
                    $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                    $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                    return false;
                } */

                // Validar tipo de extensión
                const tiposValidos = [
                    'image/jpeg', 'image/png', 'image/gif',
                    'image/bmp', 'image/webp', 'image/svg+xml',
                    'image/x-icon'
                ];

                if (!tiposValidos.includes(archivo.type)) {
                    $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                    $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                    return false;
                }
            } else if (valor === null || valor === "" || (campo.tipo === 'input' && valor.trim() === "")) {
                $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                return false;
            } else {
                $(campo.id).closest('div').find('p').eq(0).removeClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text('');
                return true;
            }

            return true;
        }

        // Validar todos los campos
        campos.forEach(function (campo) {
            if (!validarCampo(campo)) {
                formularioValido = false;
            }
        });

        // Prevenir envío del formulario si hay errores
        if (!formularioValido) {
            e.preventDefault();
        }
    });

    // DESHABILITAR PRODUCTO
    $('.eliminarbtn').on('click', function () {
        const idProducto = $(this).data('id'); // Obtener el ID del producto
        const form = $(`#formEliminarProducto_${idProducto}`); // Seleccionar el formulario correspondiente

        Swal.fire({
            title: '¿Estás seguro?',
            text: 'No podrás revertir esta acción',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Sí, deshabilitar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit(); // Enviar el formulario
            }
        });
    });

    // CAMBIAR DE ESTADO DEL PRODUCTO
    $('.estadoToggle').on('change', function () {
        const idProducto = $(this).data('id');
        const estadoProducto = $(this).is(':checked') ? 1 : 0;

        console.log(idProducto);
        console.log(estadoProducto);


        // Enviar la actualización al servidor
        $.ajax({
            url: '../../procesos/inventario/productos/conProductos.php',
            type: 'POST',
            data: {
                id_producto: idProducto,
                estadoProducto: estadoProducto,
                action: 'updateEstado'
            },
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Estado actualizado',
                    text: 'El estado del producto se ha cambiado exitosamente',
                    toast: true,
                    position: 'top-end',
                    timer: 1500,
                    showConfirmButton: false
                });
            },
            error: function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo actualizar el estado del producto',
                    toast: true,
                    position: 'top-end',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        });
    });

    //* PUNTO DE VENTA

    const formCaja = $('#formulariCajaVenta');

    // VALIDACION DE REGISTRO DE CAJAS PUNTO DE VENTA
    formCaja.submit(function (e) {
        // Definir los campos a validar
        const campos = [
            {
                id: '#nombreCaja',
                tipo: 'input',
                error: 'Completa este campo',
            },
            {
                id: '#ubicacionCaja',
                tipo: 'input',
                error: 'Completa este campo',
            },
            {
                // Contraseña
                id: '#contrasena',
                tipo: 'input',
                error: 'La contraseña debe tener al menos 4 caracteres',
                validar: function (valor) {
                    return valor.length >= 4;
                },
            },
            {
                // Confirmar contraseña
                id: '#contrasenaTwo',
                tipo: 'input',
                error: 'Las contraseñas no coinciden',
                validar: function (valor) {
                    // Validar que las contraseñas coincidan
                    return valor === $('#contrasena').val();
                },
            },
        ];

        let formularioValido = true;

        // Funcion de validacion
        function validarCampo(campo) {
            const valor = $(campo.id).val();

            if (valor === null || valor === "" || (campo.tipo === 'input' && valor.trim() === "")) {
                $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                return false;
            } else if (campo.validar && !campo.validar(valor)) {
                $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                return false;
            } else {
                $(campo.id).closest('div').find('p').eq(0).removeClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text('');
                return true;
            }
        }

        // Validar todos los campos
        campos.forEach(function (campo) {
            if (!validarCampo(campo)) {
                formularioValido = false;
            }
        });

        // Prevenir envio del formulario si hay errores
        if (!formularioValido) {
            e.preventDefault();
        }
    });

    // Cambiar entre inputs en la parte de administrar punto de venta
    $('.inforContra').hide();
    function toggleSections(showSelector, hideSelector) {
        $(showSelector).show();
        $(hideSelector).hide();
    }

    $('#editarContra').click(function () {
        toggleSections('.inforContra', '.inforCaja');
    });

    $('#editarInformacion').click(function () {
        toggleSections('.inforCaja', '.inforContra');
    });

    const idCajaEdit = $('#idCaja');
    const nombreCajaEdit = $('#nombreEditCaja');
    const ubicacionEditCaja = $('#ubicacionEditCaja');

    $('#tablaCajas tbody').on('click', '.botonEditar', function () {
        // Encuentra la fila correspondiente al botón de editar
        const fila = $(this).closest('tr');

        // Obtener los valores de las celdas de la fila
        const idCaja = fila.find('td').eq(0).text();
        const nombreCaja = fila.find('td').eq(1).text();
        const ubicacionCaja = fila.find('td').eq(2).text();

        idCajaEdit.val(idCaja);
        nombreCajaEdit.val(nombreCaja);
        ubicacionEditCaja.val(ubicacionCaja);

    });


    const formCajaEdit = $('#formulariREditCajaVenta');

    // VALIDACION DE EDITAR CAJAS PUNTO DE VENTA
    formCajaEdit.submit(function (e) {
        // Definir los campos a validar
        const campos = [
            {
                id: '#nombreEditCaja',
                tipo: 'input',
                error: 'Completa este campo',
            },
            {
                id: '#ubicacionEditCaja',
                tipo: 'input',
                error: 'Completa este campo',
            }
        ];

        let formularioValido = true;

        // Funcion de validacion
        function validarCampo(campo) {
            const valor = $(campo.id).val();

            if (valor === null || valor === "" || (campo.tipo === 'input' && valor.trim() === "")) {
                $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                return false;
            } else if (campo.validar && !campo.validar(valor)) {
                $(campo.id).closest('div').find('p').eq(0).addClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text(campo.error);
                return false;
            } else {
                $(campo.id).closest('div').find('p').eq(0).removeClass('errorValidacionInput');
                $(campo.id).closest('div').find('p').eq(0).text('');
                return true;
            }
        }

        // Validar todos los campos
        campos.forEach(function (campo) {
            if (!validarCampo(campo)) {
                formularioValido = false;
            }
        });

        // Prevenir envio del formulario si hay errores
        if (!formularioValido) {
            e.preventDefault();
        }
    });

    // CERRAR SESION CAJA

    const formCerrarSesionCaja = $('#formCerrarSesionCaja');

    formCerrarSesionCaja.submit(function (e) {

        e.preventDefault();

        // Confirmación con SweetAlert
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¡No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Aceptar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "../../procesos/inventario/punto_venta/conCerrarPuntoVenta.php";
            }
        });

    });


    // SECCION DE AGREGAR CANTIDAD EN LOS PRODUCTOS

    $(document).on('click', '.btnEditarCantidadProducto', function () {
        const idProducto = $(this).data('id');
        $('#id_productoCant').val(idProducto);
    });

    // Evento para validar los campos y enviar el formulario
    $('#agregarCantidad').click(function (e) {
        e.preventDefault();

        const cantidad = $('#cantidad_stock').val().trim();
        const precioCant = $('#precio_unitario').val().trim();
        const idProducto = $('#id_productoCant').val();

        // Validar que todos los campos requeridos están llenos
        if (!idProducto) {
            console.error("No se ha seleccionado un producto.");
            return;
        }

        if (!cantidad || isNaN(cantidad) || cantidad <= 0) {
            $('.cantidadStock').find('p').addClass('errorValidacionInput');
            $('.cantidadStock').find('p').text("Por favor, ingresa una cantidad válida.");
            return;
        } else {
            $('.cantidadStock').find('p').removeClass('errorValidacionInput');
            $('.cantidadStock').find('p').text("");
        }

        if (!precioCant || isNaN(precioCant) || precioCant <= 0) {
            $('.PrecioStock').find('p').addClass('errorValidacionInput');
            $('.PrecioStock').find('p').text("Por favor, ingresa un valor válido.");
            return;
        } else {
            $('.PrecioStock').find('p').removeClass('errorValidacionInput');
            $('.PrecioStock').find('p').text("");
        }

        // Si todo es válido, enviar el formulario
        $('#formularioProductoCantidad').submit();
    });

    //* SECCION DE SALIDAS

    // Inicializar la tabla como instancia de DataTables
    let table = $('#tablaSalidas').DataTable({
        "order": [],
        "bSort": false,
        "lengthMenu": [5, 10, 20, 30],
        info: true,
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        responsive: true,
        language: {
            "decimal": ",",
            "thousands": ".",
            "lengthMenu": "Mostrar _MENU_ registros",
            "info": "Total registros: _TOTAL_",
            "infoEmpty": "Mostrando 0 a 0 de 0 registros",
            "infoFiltered": "(filtrado de _MAX_ registros en total)",
            "search": "Buscar:",
            "zeroRecords": "No se encontraron registros",
            "emptyTable": "No hay datos disponibles en la tabla",
            "paginate": {
                "first": "<<",
                "previous": "<",
                "next": ">",
                "last": ">>"
            },
            "aria": {
                "sortAscending": ": activar para ordenar la columna de manera ascendente",
                "sortDescending": ": activar para ordenar la columna de manera descendente"
            }
        }
    });

    // Función para cargar y mostrar los detalles de la venta
    function format(idVenta) {
        let contenido = '<table class="table table-condensed display nowrap">';
        contenido += '<thead><tr><th class="text-center">Producto</th><th class="text-center">Referencia</th><th class="text-center">Cantidad</th><th class="text-center">Precio Unitario</th><th class="text-center">Precio Total</th></tr></thead>';
        contenido += '<tbody>';

        // Realizar una llamada AJAX para obtener los detalles de la venta
        $.ajax({
            url: 'inventario_obtener_detalles_salidas.php', // Archivo que procesa la consulta
            type: 'POST',
            data: {
                id_venta: idVenta
            },
            async: false, // Necesario para completar antes de renderizar
            success: function (response) {
                const detalles = JSON.parse(response);
                detalles.forEach(function (detalle) {
                    contenido += `<tr>
                        <td class="text-center">${detalle.producto_nombre}</td>
                        <td class="text-center">${detalle.producto_referencia}</td>
                        <td class="text-center">${detalle.cantidad_producto}</td>
                        <td class="text-center">${detalle.precio_unitario}</td>
                        <td class="text-center">${detalle.precio_total}</td>
                    </tr>`;
                });
            },
            error: function () {
                contenido += '<tr><td colspan="5">Error al cargar los detalles</td></tr>';
            }
        });

        contenido += '</tbody></table>';
        return contenido;
    }

    // Manejo de clic para expandir o contraer detalles
    $('#tablaSalidas tbody').on('click', 'td#detallesVenta', function () {
        const tr = $(this).closest('tr');
        const row = table.row(tr);
        const idVenta = $(this).data('id'); // Obtener el id_venta desde la celda
        const icon = $(this).find('i'); // Seleccionar el ícono dentro de la celda

        if (row.child.isShown()) {
            // Contraer
            row.child.hide();
            tr.removeClass('shown');
            // Cambiar el ícono a caret-down
            icon.removeClass('bi-caret-up-fill').addClass('bi-caret-down-fill');
        } else {
            // Expandir
            row.child(format(idVenta)).show();
            tr.addClass('shown');
            // Cambiar el ícono a caret-up
            icon.removeClass('bi-caret-down-fill').addClass('bi-caret-up-fill');
        }
    });


   /*  //* DRIVERJS GUIA PARA INVENTARIO

    const driver = window.driver.js.driver;

    if (!localStorage.getItem('mensajeMostrado')) {

        const driverObj = driver({
            showProgress: false,
            steps: [
                {
                    element: '.btn-buscadorNfc',
                    popover: {
                        title: 'Buscar reservas con NFC',
                        description: 'Haz clic en el botón para ver información de una reservación. Una vez que lo hagas, podrás visualizar detalles importantes como el número de la reserva, el estado actual, fechas de entrada y salida, así como cualquier solicitud o servicio adicional que hayas solicitado.',
                        side: "bottom",
                        align: 'center'
                    }
                }
            ],
            doneBtnText: 'Aceptar',
            nextBtnText: 'Siguiente',
            prevBtnText: 'Anterior',
        });

        driverObj.drive();

        // guardar en localStorage 
        localStorage.setItem('mensajeMostrado', 'true');
    } */


});