$(document).ready(function() {
  notificaciones();
  var table = $('#paginacion').DataTable({      
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
      dom: "<'row'<'col-sm-6'l><'col-sm-6'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'i><'col-sm-7'p>>",
      responsive:"true",
      colReorder: true,
      lengthMenu: [5, 10, 20, 30, 40, 50, 100],   
    
  });     
});

function notificaciones() {
  var datos = new FormData();
  datos.append("accion", "cargar");
  cargarnotificaciones(datos);
};

function cargarnotificaciones(datos) {
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: (response) => {
      var res = JSON.parse(response);
          $("#notificacion1").html(res.modulo);
          $("#notificaciones2").html(res.icono);
        
    },
  });
}
