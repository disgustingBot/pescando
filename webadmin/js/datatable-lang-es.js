  $(function () {

    $.extend( $.fn.dataTable.defaults, {
      language: {
        processing:     "Procesando...",
        search:         "Filtrar :",
        lengthMenu:     "Mostrar _MENU_ registros",
        info:           "Mostrando registros del _START_ al _END_ (en total hay _TOTAL_)",
        infoEmpty:      "&nbsp;",
        infoFiltered:   "(filtrados de un total de _MAX_ filas)",
        infoPostFix:    "",
        loadingRecords: "Cargando datos...",
        zeroRecords:    "Sin registros que mostrar",
        emptyTable:     "No hay datos disponibles para esta tabla",
        paginate: {
          first:      "Inicial",
          previous:   "Anterior",
          next:       "Siguiente",
          last:       "Final"
        },
        aria: {
          sortAscending:  ": para ordenar de menor a mayor",
          sortDescending: ": para ordenar de mayor a menor"
        }
      }
    } );

  })
