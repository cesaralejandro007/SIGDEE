var keyup_nombre = /^(([A-ZÁÉÍÓÚ]+[a-zñáéíóú.,-]*[\s]?)*)$/;

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
        return "EXCEL-MóduloEmprendimiento"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Módulo de Emprendimiento"
      },
      text:      '<i class="fas fa-file-excel text-success"></i> ',
      titleAttr: 'Exportar a Excel',
      className: 'btn border border-success bg-white mr-1',
      exportOptions: {
        columns: [1]
    }
    },
    {
      extend:    'pdfHtml5',
      filename: function() {
        return "PDF-MóduloEmprendimiento"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Módulo de Emprendimiento"
      },
      text:      '<i class="fas fa-file-pdf text-danger "></i> ',
      titleAttr: 'Exportar a PDF',
      className: 'btn border border-danger bg-white mr-1',
      exportOptions: {
        columns: [1]
    }
  },
    {
      extend:    'print',
      filename: function() {
        return "Print-MóduloEmprendimiento"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Módulo de Emprendimiento"
      },
      text:      '<i class="fa fa-print text-info"></i> ',
      titleAttr: 'Imprimir',
      className: 'btn border border-info bg-white mr-1',
      exportOptions: {
        columns: [1]
    }
    },    
  ]  
  });     
});

document.onload = carga();
function carga() {
  /*--------------VALIDACION PARA NOMBRE--------------------*/

  /*--------------FIN VALIDACION PARA NOMBRE--------------------*/

  document.getElementById("enviar").onclick = function () {

      var datos = new FormData();
      datos.append("accion", $("#accion").val());
      datos.append("id", $("#id").val());
      datos.append("nombre", $("#nombre").val());
      enviaAjax(datos);
      limpiar();

  };

  document.getElementById("nuevo").onclick = function () {
    limpiar();
    $("#accion").val("registrar");
    $("#titulo").text("Registrar Modulo de Emprendimiento");
    $("#enviar").text("Registrar");
    $("#gestion-modulo").modal("show");
  };
}

/*-------------------FUNCIONES DE HERRAMIENTAS-------------------*/
function validarkeypress(er, e) {
  key = e.keyCode || e.which;
  tecla = String.fromCharCode(key);
  a = er.test(tecla);
  if (!a) {
    e.preventDefault();
  }
}

function validarkeyup(er, etiqueta, etiquetamensaje, mensaje) {
  a = er.test(etiqueta.value);
  if (!a) {
    etiquetamensaje.innerText = mensaje;
    etiquetamensaje.style.color = "red";
    etiqueta.classList.add("is-invalid");
    return 0;
  } else if (etiqueta.value == "") {
    etiquetamensaje.innerText = mensaje;
    etiquetamensaje.style.color = "red";
    etiqueta.classList.add("is-invalid");
    return 0;
  } else {
    etiquetamensaje.innerText = "";
    etiqueta.classList.remove("is-invalid");
    etiqueta.classList.add("is-valid");
    return 1;
  }
}

function limpiar() {
  $("#nombre").val("");
  document.getElementById("snombre").innerText = "";
  document.getElementById("nombre").classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
  var error = false;
  nombre = validarkeyup(
    keyup_nombre,
    document.getElementById("nombre"),
    document.getElementById("snombre"),
    "* Solo letras de 1 a 30, siendo la primera letra en mayúscula de cada palabra."
  );
  if (nombre == 0) {
    //variable==0, indica que hubo error en la validacion de la etiqueta
    error = true;
  }
  return error;
}

function cargar_datos(valor) {
  var datos = new FormData();
  datos.append("accion", "editar");
  datos.append("id", valor);
  mostrar(datos);
}

function eliminar(idnombre) {
  Swal.fire({
    title: "¿Desea Eliminar el Registro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCloseButton: true,
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
  }).then(function (result) {
    if (result.isConfirmed) {
      setTimeout(function () {
        var datos = new FormData();
        datos.append("accion", "eliminar");
        datos.append("id", idnombre);
        enviaAjax(datos);
      }, 10);
    }
  });
}

function enviaAjax(datos) {
  var toastMixin = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
  });
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: function (response) {
      var res = JSON.parse(response);
      //alert(res.title);
      if (res.estatus == 1) {
        toastMixin.fire({
          animation: true,
          title: res.title,
          text: res.message,
          icon: res.icon,
        });
        setTimeout(function () {
          window.location.reload();
        }, 2000);
      } else {
        toastMixin.fire({
          animation: true,
          text: res.message,
          title: res.title,
          icon: res.icon,
        });
      }
    },
    error: function (err) {
      Toast.fire({
        icon: res.error,
      });
    },
  });
}

function mostrar(datos) {
  $.ajax({
    async: true,
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: function (response) {
      var res = JSON.parse(response);
      $("#id").val(res.id);
      $("#nombre").val(res.nombre);
      $("#enviar").text("Modificar");
      $("#gestion-modulo").modal("show");
      $("#accion").val("modificar");
      document.getElementById("accion").innerText = "modificar";
      $("#titulo").text("Editar Modulo");
    },
    error: function (err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}
