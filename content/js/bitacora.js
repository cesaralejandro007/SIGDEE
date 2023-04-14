$(document).ready(function() {    
    var table = $('#funcionpaginacion').DataTable({      
        language: {
                "lengthMenu": "Mostrar _MENU_ registros",
                "zeroRecords": "No se encontraron resultados",
                "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "infoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast":"Último",
                    "sNext":"Siguiente",
                    "sPrevious": "Anterior"
           },
           "sProcessing":"Procesando...",
            },
        //para usar los botones   
        dom: "B<'row'<'col-sm-6'><'col-sm-6'f>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-5'il><'col-sm-7'p>>",
        colReorder: true,
        lengthMenu: [5, 10, 20, 30, 40, 50, 100],   
        buttons:[ 
      {
        extend:    'excelHtml5',
        filename: function() {
          return "EXCEL-Bitacora"      
        },          
        title: function() {
          var searchString = table.search();        
          return searchString.length? "Search: " + searchString : "Reporte de Bitacora"
        },
        text:      '<i class="fas fa-file-excel"></i> ',
        titleAttr: 'Exportar a Excel',
        className: 'btn btn-success',
        exportOptions: {
          columns: [0,1,2,3,4]
      }
      },
      {
        extend:    'pdfHtml5',
        filename: function() {
          return "PDF-Bitacora"      
        },          
        title: function() {
          var searchString = table.search();        
          return searchString.length? "Search: " + searchString : "Reporte de Bitacora"
        },
        text:      '<i class="fas fa-file-pdf"></i> ',
        titleAttr: 'Exportar a PDF',
        className: 'btn btn-danger',
        exportOptions: {
          columns: [0,1,2,3,4]
      }
    },
      {
        extend:    'print',
        filename: function() {
          return "Print-Bitacora"      
        },          
        title: function() {
          var searchString = table.search();        
          return searchString.length? "Search: " + searchString : "Reporte de Bitacora"
        },
        text:      '<i class="fa fa-print"></i> ',
        titleAttr: 'Imprimir',
        className: 'btn btn-info',
        exportOptions: {
          columns: [0,1,2,3,4]
      }
      },    
    ]  
    });     
  });