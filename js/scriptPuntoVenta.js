$(document).ready(function () {
    // SELECT2 PARA SELECCIONAR VARIAS CATEGORIAS
    $('#filtroCategoria').select2();

    // Filtro de categorías con AJAX
    const categoria = $('#filtroCategoria');
    const buscador = $('#buscadorProducto'); // Seleccionar el campo de búsqueda

    function enviarAjax(datosBusqueda, categoriasSeleccionadas) {
        $.ajax({
            url: 'inventarioPuntoVentaProductos.php',
            type: 'GET',
            data: {
                buscadorProducto: datosBusqueda, // El texto de búsqueda
                valorCat: categoriasSeleccionadas // Las categorías seleccionadas
            },
            success: function (respuesta) {
                $('#contenedorProductos').html(respuesta); // Actualiza el contenedor de productos
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    // Enviar la petición AJAX cuando se carga la página, con los valores iniciales
    enviarAjax(buscador.val(), categoria.val());



    // Detectar cambios en el campo de búsqueda
    buscador.on('input', function () {
        let valorBusqueda = buscador.val(); // Obtener el valor del campo de búsqueda
        let categoriasSeleccionadas = categoria.val(); // Obtener las categorías seleccionadas
        enviarAjax(valorBusqueda, categoriasSeleccionadas); // Enviar los datos al servidor
    });

    // Detectar cambios en las categorías seleccionadas
    categoria.on('change', function () {
        let valorBusqueda = buscador.val(); // Obtener el valor del campo de búsqueda
        let categoriasSeleccionadas = categoria.val(); // Obtener las categorías seleccionadas
        enviarAjax(valorBusqueda, categoriasSeleccionadas); // Enviar los datos al servidor
    });

    //* FACTURA DINAMICAMENTE

    // Agregar producto a la factura
    $(document).on("click", ".agregarProducto", function () {
        const producto = $(this).find(".product-card");
        const id = producto.data("id");
        const nombre = producto.data("nombre");
        const precio = producto.data("precio");

        // Agregar producto a la factura
        const itemHTML = `
        <div class="d-flex justify-content-between align-items-center mb-3 productoFactura" data-id="${id}" data-precio="${precio}">
            <input type="checkbox" class="form-check-input productoCheck me-2" checked>
            <span class="flex-grow-1 nombreProducto">${nombre}</span>
            <div class="d-flex align-items-center cantidadProducto">
                <button class="btn btn-sm btn-outline-secondary disminuirCantidad me-1">-</button>
                <span class="mx-2 cantidad text-center">1</span>
                <button class="btn btn-sm btn-outline-secondary aumentarCantidad ms-1">+</button>
            </div>
            <span class="precioProducto p-1 ms-3">${formatearPrecio(precio)}</span>
            <button class="btn btn-sm btn-danger eliminarProducto ms-3">X</button>
        </div>
    `;
        $("#listaFactura").append(itemHTML);

        // Actualizar el total
        actualizarTotal();
    });

    // Cambiar cantidad de productos
    $("#listaFactura").on("click", ".aumentarCantidad", function () {
        const cantidadSpan = $(this).closest(".cantidadProducto").find(".cantidad");
        let cantidad = parseInt(cantidadSpan.text());
        cantidad++;
        cantidadSpan.text(cantidad);
        actualizarTotal();
    });

    $("#listaFactura").on("click", ".disminuirCantidad", function () {
        const cantidadSpan = $(this).closest(".cantidadProducto").find(".cantidad");
        let cantidad = parseInt(cantidadSpan.text());
        if (cantidad > 1) {
            cantidad--;
            cantidadSpan.text(cantidad);
            actualizarTotal();
        }
    });


    // Eliminar producto de la factura
    $("#listaFactura").on("click", ".eliminarProducto", function () {
        $(this).closest(".productoFactura").remove();
        actualizarTotal();
    });

    // Seleccionar productos según tipo de cliente
    $("#tipoCliente").change(function () {
        const tipoCliente = $(this).val();
        if (tipoCliente === "0") {
            // Público general: seleccionar todos los productos automáticamente
            $(".productoCheck").prop("checked", true).prop("disabled", true);
        } else {
            // Habitaciones: permitir seleccionar productos
            $(".productoCheck").prop("checked", false).prop("disabled", false);
        }
        actualizarTotal();
    });

    // Actualizar total dinámicamente
    $("#listaFactura").on("change", ".productoCheck", actualizarTotal);

    function actualizarTotal() {
        let total = 0;
        let totalFactura = 0;
        $(".productoFactura").each(function () {
            const isChecked = $(this).find(".productoCheck").is(":checked");
            const precio = parseFloat($(this).data("precio"));
            const cantidad = parseInt($(this).find(".cantidad").text());
            if (isChecked) {
                total += precio * cantidad;
            }
            totalFactura += precio * cantidad;
        });
        $("#totalPagar").text(`$${formatearPrecio(total)}`);
        $("#totalFactura").text(`$${formatearPrecio(totalFactura)}`);
    }

    // Función para formatear precios
    function formatearPrecio(precio) {
        precio = parseFloat(precio);
        if (isNaN(precio)) {
            return 0;
        }
        let precioFormateado = precio.toFixed(0);
        precioFormateado = precioFormateado.replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return precioFormateado;
    }

    $("#cantidadCliente").on("input", function () {
        const cantidadCliente = $(this).val();
        const totalPagar = parseFloat($("#totalPagar").text().replace(/[$,]/g, ""));

        //Calcuar cuanto toca devolver
        let totalDevolver = Math.max(cantidadCliente - totalPagar, 0);

        // Actualizar el campo de devolución
        $("#cantidadDevolver").text(`$${formatearPrecio(totalDevolver)}`);

    });

    // Generar venta
    $("#generarVenta").click(function () {
        const productos = [];
        $(".productoFactura").each(function () {
            const id = $(this).data("id");
            const cantidadTexto = $(this).find(".cantidad").text().trim();
            const cantidad = parseInt(cantidadTexto, 10);
            const isChecked = $(this).find(".productoCheck").is(":checked");

            if (!isNaN(cantidad)) { // Validar que la cantidad sea un número válido
                productos.push({
                    id: id,
                    cantidad: cantidad,
                    pagar: isChecked
                });
            } else {
                console.error("Cantidad inválida para el producto con ID: " + id);
            }
        });


        const tipoCliente = $("#tipoCliente").val();
        const caja = $(".factura").data("caja");


        if (tipoCliente == null) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Selecciona el destinario de la venta',
                toast: true,
                position: 'top-end',
                timer: 1500,
                showConfirmButton: false
            });
        } else {
            $.ajax({
                url: '../../procesos/inventario/punto_venta/conGenerarVenta.php',
                method: 'POST',
                data: {
                    caja: caja,
                    tipoCliente: tipoCliente,
                    productos: JSON.stringify(productos)
                },
                success: function (response) {
                    if (response.status === "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Venta generada',
                            text: response.message,
                            toast: true,
                            position: 'top-end',
                            timer: 1500,
                            showConfirmButton: false
                        });

                        // Vaciar la factura
                        $("#listaFactura").empty(); // Limpia los productos de la factura

                        // Resetear el total a pagar y total de la factura
                        $("#totalPagar").text("$0");
                        $("#totalFactura").text("$0");
                        $("#cantidadCliente").val(''); 
                        $("#cantidadDevolver").text('$0');
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message,
                            toast: true,
                            position: 'top-end',
                            timer: 1500,
                            showConfirmButton: false
                        });
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                }
            });
        }

    });

});
