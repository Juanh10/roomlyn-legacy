$(document).ready(function () {

  //! INICIALIZAR DATATABLES

  const contenidoArialLabelTablas = $('.tableAdmin').attr('aria-label');

  // fecha actual
  const actual = new Date();
  const opFormato = { year: 'numeric', month: '2-digit', day: '2-digit' };
  const formatoFecha = actual.toLocaleDateString('es-ES', opFormato);

  function initDatatables($tablaID) {

    // Verificar si la tabla ya tiene una instancia de DataTable
    if ($.fn.DataTable.isDataTable($tablaID)) {
      // Destruir la instancia existente antes de volver a inicializar
      $tablaID.DataTable().destroy();
    }

    $($tablaID).DataTable({
      "order": [],
      "bSort": false,
      "lengthMenu": [5, 10, 20, 30],
      responsive: true,

      dom: '<"dataTables_top"fB>t<"dataTables_bottom"lip>',

      buttons: [
        {
          extend: 'excelHtml5',
          text: '<i class="bi bi-file-earmark-excel-fill"></i>',
          titleAttr: 'Exportar a Excel',
          className: 'btn btn-success',
          filename: function () {
            return `reporte_${contenidoArialLabelTablas}`;
          },
          title: `Hotel Colonial City - Reporte de ${contenidoArialLabelTablas}`,
          messageTop: function () {
            return `Fecha de exportación: ${formatoFecha}`;
          },
          exportOptions: {
            columns: ':not(.no-export)'
          }
        },

        {
          extend: 'pdfHtml5',
          text: '<i class="bi bi-file-earmark-pdf-fill"></i>',
          titleAttr: 'Exportar a PDF',
          className: 'btn btn-danger',
          filename: function () {
            return `reporte_${contenidoArialLabelTablas}`;
          },
          title: '',
          exportOptions: {
            columns: ':not(.no-export)'
          },
          customize: function (doc) {
            try {
              //orientacion y margenes
              doc.pageOrientation = 'portrait';
              doc.pageMargins = [0, 0, 40, 40];

              //array de columnas para colocar el logo y el texto
              doc.content.unshift({
                columns: [
                  {
                    // Columna para el logo
                    image: logoBase64,
                    width: 150, // Ajustar el ancho según sea necesario
                    alignment: 'left', // Alinear el logo a la izquierda
                    margin: [0, 0, 20, 20] // Espaciado a la derecha del logo
                  },
                  {
                    stack: [
                      {
                        text: 'Hotel Colonial City',
                        fontSize: 16,
                        bold: true,
                        margin: [0, 0, 0, 5]
                      },
                      {
                        text: 'Calle 10 Número 3-03',
                        fontSize: 11,
                        margin: [0, 0, 0, 3]
                      },
                      {
                        text: `Reporte de ${contenidoArialLabelTablas}`,
                        fontSize: 11,
                        margin: [0, 0, 0, 3]
                      },
                      {
                        text: formatoFecha,
                        fontSize: 11
                      }
                    ],
                    alignment: 'right'
                  }
                ],
                margin: [0, 12, 0, 12] // Margen general para la fila
              });

              // estilos de la tabla
              doc.styles.tableHeader = {
                fillColor: '#c4ac9f',
                color: '#000',
                bold: true,
                fontSize: 11,
                alignment: 'center'
              };

              // estilo general del documento
              doc.defaultStyle = {
                fontSize: 10,
                alignment: 'center'
              };

              // pie de página
              doc.footer = function (currentPage, pageCount) {
                return {
                  text: 'Página ' + currentPage.toString() + ' de ' + pageCount,
                  alignment: 'center',
                  fontSize: 8,
                  margin: [0, 10, 0, 0]
                };
              };

            } catch (e) {
              console.error('Error al personalizar el PDF:', e);
            }
          }
        },

        {
          extend: 'print',
          text: '<i class="bi bi-printer-fill"></i>',
          titleAttr: 'Imprimir',
          title: ' ',
          className: 'btn btn-info',
          exportOptions: {
            columns: ':not(.no-export)'
          },
          customize: function (win) {
            try {
              // Estilos para la ventana de impresión
              $(win.document.body)
                .css('font-size', '12pt') // Ajustar el tamaño de la fuente general
                .css('text-align', 'center'); // Alinear todo el contenido al centro

              // Añadir el logo
              $(win.document.body).prepend(
                `<div style="text-align: left; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center;">
                  <div style="width: 50%; margin-right: 20px;">
                    <img src="${logoBase64}" style="max-width: 100%; height: auto;" />
                  </div>
                  <div style="display: inline-block; text-align: left;">
                    <h1 style="margin: 0;">Hotel Colonial City</h1>
                    <p style="margin: 0;">Calle 10 Número 3-03</p>
                    <p style="margin: 0;">Reporte de ${contenidoArialLabelTablas}</p>
                    <p style="margin: 0;">${formatoFecha}</p>
                  </div>
                </div>`
              );

              // Estilos de la tabla
              $(win.document.body).find('table')
                .addClass('table-bordered')
                .css('width', '100%') // Hacer la tabla de ancho completo
                .css('font-size', 'inherit'); // Mantener tamaño de fuente

              // Actualizar los números de página
              $(win).on('afterprint', function () {
                $(this).off('afterprint'); // Limpiar el evento después de usarlo
              });
            } catch (e) {
              console.error('Error al personalizar la impresión:', e);
            }
          }
        },
      ],

      "language": {
        "sEmptyTable": "No se encontraron registros",
        "sInfo": "Total de registros: _TOTAL_",
        "sInfoEmpty": "Mostrando 0 de 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sLoadingRecords": "Cargando...",
        "sProcessing": "Procesando...",
        "sSearch": "Buscar:",
        "sZeroRecords": "No se encontraron registros",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        }
      }
    });
  }

  initDatatables($('#tablaClientesFiltro'));
  initDatatables($('#tablaReservasFiltro'));
});