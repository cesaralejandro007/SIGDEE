var keyup_descripcion = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{2,100}$/;

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
        return "EXCEL-Censo"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Censo"
      },
      text:      '<i class="fas fa-file-excel"></i> ',
      titleAttr: 'Exportar a Excel',
      className: 'btn btn-success',
      exportOptions: {
        columns: [1,2,3]
    }
    },
    {
      extend:    'pdfHtml5',
      filename: function() {
        return "PDF-Censo"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Censo"
      },
      text:      '<i class="fas fa-file-pdf"></i> ',
      titleAttr: 'Exportar a PDF',
      className: 'btn btn-danger',
      exportOptions: {
        columns: [1,2,3]
    }
  },
    {
      extend:    'print',
      filename: function() {
        return "Print-Censo"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Censo"
      },
      text:      '<i class="fa fa-print"></i> ',
      titleAttr: 'Imprimir',
      className: 'btn btn-info',
      exportOptions: {
        columns: [1,2,3]
    }
    },    
  ]  
  });     
});

document.onload = carga();
function carga() {
  /*--------------VALIDACION PARA descripcion--------------------*/
  document.getElementById("descripcion").maxLength = 50;
  document.getElementById("descripcion").onkeypress = function (e) {
    er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("descripcion").onkeyup = function () {
    r = validarkeyup(
      keyup_descripcion,
      this,
      document.getElementById("sdescripcion"),
      "* Solo letras de 1 a 50"
    );
  };
  /*--------------FIN VALIDACION PARA descripcion--------------------*/

  document.getElementById("enviar").onclick = function () {
    a = valida_registrar();
    if (a != "") {
    } else {
      var datos = new FormData();
      datos.append("accion", $("#accion").val());
      datos.append("id", $("#id").val());
      datos.append("fecha_apertura", $("#fecha_apertura").val());
      datos.append("fecha_cierre", $("#fecha_cierre").val());
      datos.append("descripcion", $("#descripcion").val());
      enviaAjax(datos);
    }
  };

  document.getElementById("nuevo").onclick = function () {
    limpiar();
    $("#accion").val("registrar");
    $("#titulo").text("Aperturar Censo");
    $("#enviar").text("Aperturar");
    $("#gestion-censo").modal("show");
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
  $("#fecha_apertura").val("");
  $("#fecha_cierre").val("");
  $("#descripcion").val("");
  document.getElementById("sdescripcion").innerText = "";
  document
    .getElementById("descripcion")
    .classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
  var error = false;
  descripcion = validarkeyup(
    keyup_descripcion,
    document.getElementById("descripcion"),
    document.getElementById("sdescripcion"),
    "* Solo letras de 1 a 30, siendo la primera letra en mayúscula de cada palabra."
  );
  if (descripcion == 0) {
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

function eliminar(iddescripcion) {
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
        datos.append("id", iddescripcion);
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
      } else if (res.estatus == 2){
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
      $("#descripcion").val(res.descripcion);
      $("#fecha_apertura").val(res.fecha_apertura);
      $("#fecha_cierre").val(res.fecha_cierre);
      $("#enviar").text("Modificar");
      $("#gestion-censo").modal("show");
      $("#accion").val("modificar");
      document.getElementById("accion").innerText = "modificar";
      $("#titulo").text("Editar Censo");
    },
    error: function (err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

function cargar_emprendimiento(id_rol) {
  var ob = { id_rol: id_rol };
  $.ajax({
    type: "POST",
    url: "controlador/Permiso.php",
    data: ob,
    beforeSend: function (objeto) {},
    success: function (data) {
      $("#listado_modulos").html(data);
    },
  });
  $("#crear-permisos").modal("show");
}
