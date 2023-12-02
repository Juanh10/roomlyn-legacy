$(document).ready(function(){

      //! INICIALIZAR DATATABLES

  function initDatatables($tablaID) {

    // Verificar si la tabla ya tiene una instancia de DataTable
    if ($.fn.DataTable.isDataTable($tablaID)) {
      // Destruir la instancia existente antes de volver a inicializar
      $tablaID.DataTable().destroy();
    }

    $($tablaID).DataTable({

      "lengthMenu": [5, 10, 20, 30],

      responsive: true,

      "language": {
        "sEmptyTable": "No se encontraron registros",
        "sInfo": "Total de registros: _TOTAL_",
        "sInfoEmpty": "Mostrando 0 de 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sInfoThousands": ",",
        "sLengthMenu": "Mostrar _MENU_ registros por página",
        "sLoadingRecords": "Cargando...",
        "sProcessing": "Procesando...",
        "sSearch": "Buscar:",
        "sZeroRecords": "No se encontraron registros",
        "oPaginate": {
          "sFirst": "Primero",
          "sLast": "Último",
          "sNext": "Siguiente",
          "sPrevious": "Anterior"
        },
        "oAria": {
          "sSortAscending": ": Activar para ordenar la columna ascendente",
          "sSortDescending": ": Activar para ordenar la columna descendente"
        }
      }
    });
  }

  initDatatables($('#tablaClientesFiltro'));
  initDatatables($('#tablaReservasFiltro'));
});