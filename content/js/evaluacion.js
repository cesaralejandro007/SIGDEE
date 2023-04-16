var keyup_nombre = /^[A-ZÁÉÍÓÚa-zñáéíóú,.#%$^&*:\s]{3,30}$/;
var keyup_descripcion = /^[A-ZÁÉÍÓÚa-zñáéíóú,.#%$^&*:\s]{3,200}$/;
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
        return "EXCEL-Evaluaciones"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Evaluaciones"
      },
      text:      '<i class="fas fa-file-excel text-success"></i> ',
      titleAttr: 'Exportar a Excel',
      className: 'btn border border-success bg-white mr-1',
      exportOptions: {
        columns: [1,2,3]
    }
    },
    {
      extend:    'pdfHtml5',
      filename: function() {
        return "PDF-Evaluaciones"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Evaluaciones"
      },
      text:      '<i class="fas fa-file-pdf text-danger "></i> ',
      titleAttr: 'Exportar a PDF',
      className: 'btn border border-danger bg-white mr-1',
      exportOptions: {
        columns: [1,2,3]
    }
  },
    {
      extend:    'print',
      filename: function() {
        return "Print-Evaluaciones"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Evaluaciones"
      },
      text:      '<i class="fa fa-print text-info"></i> ',
      titleAttr: 'Imprimir',
      className: 'btn border border-info bg-white mr-1',
      exportOptions: {
        columns: [1,2,3]
    }
    },    
  ]  
  });     
});


document.onload = carga();
function carga() {
  /*--------------VALIDACION PARA NOMBRE--------------------*/
  document.getElementById("nombre").maxLength = 30;
  document.getElementById("nombre").onkeypress = function (e) {
    er = /^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("nombre").onkeyup = function () {
    r = validarkeyup(
      keyup_nombre,
      this,
      document.getElementById("snombre"),
      "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
  };
  /*--------------FIN VALIDACION PARA NOMBRE--------------------*/

  /*--------------VALIDACION PARA descripcion--------------------*/
  document.getElementById("descripcion").maxLength = 200;
  document.getElementById("descripcion").onkeypress = function (e) {
    er = /^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("descripcion").onkeyup = function () {
    r = validarkeyup(
      keyup_descripcion,
      this,
      document.getElementById("sdescripcion"),
      "* El campo debe contener de 2 a 200 letras."
    );
  };

  /*----------------------CRUD DEL MODULO------------------------*/
  document.getElementById("enviar").onclick = function () {
    a = valida_registrar();
    if (a != "") {
    } else {
      var datos = new FormData();

      datos.append("accion", $("#accion").val());
      datos.append("id", $("#id").val());
      datos.append("nombre", $("#nombre").val());
      datos.append("descripcion", $("#descripcion").val());
      //Si se cambia el archivo entonces se pasa la informacion al controlador
      if ($("#archivo_adjunto")[0].files[0] != null) {
        datos.append("archivo", $("#archivo_adjunto")[0].files[0]);
        datos.append("nombre_antes", $("#nombre_antes").val());
      }
      enviaAjax(datos);
    }
  };

  document.getElementById("nuevo").onclick = function () {
    limpiar();
    $("#archivo-anterior").hide();

    $("#accion").val("registrar");
    $("#titulo").text("Registrar nueva evaluación");
    $("#enviar").text("Registrar");
    $("#gestion-evaluacion").modal("show");
  };
}

/*--------------------FIN DE CRUD DEL MODULO----------------------*/

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
  } else {
    etiquetamensaje.innerText = "";
    etiqueta.classList.remove("is-invalid");
    etiqueta.classList.add("is-valid");
    return 1;
  }
}

function limpiar() {
  $("#nombre").val("");
  $("#descripcion").val("");
  document.getElementById("snombre").innerText = "";
  document.getElementById("sdescripcion").innerText = "";
  document.getElementById("nombre").classList.remove("is-invalid", "is-valid");
  document
    .getElementById("descripcion")
    .classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
  var error = false;
  nombre = validarkeyup(
    keyup_nombre,
    document.getElementById("nombre"),
    document.getElementById("snombre"),
    "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
  );
  descripcion = validarkeyup(
    keyup_descripcion,
    document.getElementById("descripcion"),
    document.getElementById("sdescripcion"),
    "* El campo debe contener de 2 a 100 letras."
  );
  if (nombre == 0 || descripcion == 0) {
    //variable==0, indica que hubo error en la validacion de la etiqueta
    error = true;
  }
  return error;
}

$(document).ready(function () {
  $("#buscarb").click(function (e) {});
});

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
/*-------------------FIN DE FUNCIONES DE HERRAMIENTAS-------------------*/

/*--------------------FUNCIONES CON AJAX----------------------*/
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
      if (res.estatus == 1) {
        toastMixin.fire({
          animation: true,
          title: res.title,
          text: res.message,
          icon: res.icon,
        });

        limpiar();
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

function buscadorAjax(datos) {
  $.ajax({
    async: true,
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: function (response) {
      $("#titulo1").text("Resultados de busqueda");
      $("#elementosEncontrados").modal("show");
      $("#consulta-base").html(response);
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
      limpiar();
      $("#id").val(res.id);
      $("#nombre").val(res.nombre);
      $("#descripcion").val(res.descripcion);
      $("#nombre_antes").val(res.archivo_adjunto);
      document.getElementById("archivo_antes").href =
        "../content/evaluaciones/" + res.archivo_adjunto;
      $("#enviar").text("Modificar");
      $("#gestion-evaluacion").modal("show");
      $("#archivo-anterior").show();
      $("#accion").val("modificar");
      document.getElementById("accion").innerText = "modificar";
      $("#titulo").text("Modificar evaluacion");
      $("#elementosEncontrados").modal("hide");
    },
    error: function (err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}
/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
