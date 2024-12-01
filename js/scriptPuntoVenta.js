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
            $(".productoCheck").prop("checked", true);
        } else {
            // Habitaciones: permitir seleccionar productos
            $(".productoCheck").prop("checked", false);
        }
        actualizarTotal();
    });

    // Actualizar total dinámicamente
    $("#listaFactura").on("change", ".productoCheck", actualizarTotal);

    function actualizarTotal() {
        let total = 0;
        $(".productoFactura").each(function () {
            const isChecked = $(this).find(".productoCheck").is(":checked");
            if (isChecked) {
                const precio = parseFloat($(this).data("precio"));
                const cantidad = parseInt($(this).find(".cantidad").text());
                total += precio * cantidad;
            }
        });
        $("#totalFactura").text(`$${formatearPrecio(total)}`);
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

    // Generar venta
    $("#generarVenta").click(function () {
        const productos = [];
        $(".productoFactura").each(function () {
            const id = $(this).data("id");
            const cantidad = parseInt($(this).find(".cantidad").text());
            const isChecked = $(this).find(".productoCheck").is(":checked");

            productos.push({
                id: id,
                cantidad: cantidad,
                pagar: isChecked // True si se paga ahora, false si queda pendiente
            });
        });

        const tipoCliente = $("#tipoCliente").val();

        $.ajax({
            url: 'generar_venta.php',
            method: 'POST',
            data: {
                tipoCliente: tipoCliente,
                productos: JSON.stringify(productos)
            },
            success: function (response) {
                alert("Venta generada con éxito");
                console.log(response);
            },
            error: function (xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });


});
