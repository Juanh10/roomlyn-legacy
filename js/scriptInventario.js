$(document).ready(function () {
    const formCategorias = $('#formularioCategorias');
    const formEditCategorias = $('#formularioEditCategorias');
    const msjError = $('.errorValidacion');

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
                            respuesta.id,
                            respuesta.nombre,
                            `
                            <div class="accion">
                                <span class="bi bi-pencil-square btn btn-warning btn-sm botonEditar btnEditarCategoria" data-id="${respuesta.id}" title="Editar"></span>
                                <form class="formEliminarCategoria">
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
                        let filaIndex = tablaCat.rows().indexes().filter(function(index) {
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
    $('#tablaCategorias').on('submit', '.formEliminarCategoria', function(e) {
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
        $('.formEliminarCategoria').submit(function(e) {
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
});