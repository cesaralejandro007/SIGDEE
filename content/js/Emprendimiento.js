var keyup_nombre = /^(([A-ZÁÉÍÓÚ]+[a-zñáéíóú.,-]*[\s]?)*)$/;
document.onload = carga();

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
        return "EXCEL-Emprendimiento"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Emprendimiento"
      },
      text:      '<i class="fas fa-file-excel text-success"></i> ',
      titleAttr: 'Exportar a Excel',
      className: 'btn border border-success bg-white mr-1',
      exportOptions: {
        columns: [1,2]
    }
    },
    {
      extend:    'pdfHtml5',
      filename: function() {
        return "PDF-Emprendimiento"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Emprendimiento"
      },
      text:      '<i class="fas fa-file-pdf text-danger "></i> ',
      titleAttr: 'Exportar a PDF',
      className: 'btn border border-danger bg-white mr-1',
      exportOptions: {
        columns: [1,2]
    }
  },
    {
      extend:    'print',
      filename: function() {
        return "Print-Emprendimiento"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Emprendimiento"
      },
      text:      '<i class="fa fa-print text-info"></i> ',
      titleAttr: 'Imprimir',
      className: 'btn border border-info bg-white mr-1',
      exportOptions: {
        columns: [1,2]
    }
    },    
  ]  
  });     
});

function carga() {
  $(".modulos").bootstrapDualListbox({
    nonSelectedListLabel: "Modulos existentes",
    selectedListLabel: "Modulos Seleccionados",
    infoText: "Mostrando {0}",
    infoTextFiltered:
      '<span class="badge badge-warning">Buscar</span> {0} de {1}',
    infoTextEmpty: "Lista Vacia",
  });
  /*--------------VALIDACION PARA NOMBRE--------------------*/
  document.getElementById("nombre").maxLength = 30;
  document.getElementById("nombre").onkeypress = function (e) {
    er = /^[A-Za-z.,-\s\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("nombre").onkeyup = function () {
    r = validarkeyup(
      keyup_nombre,
      this,
      document.getElementById("snombre"),
      "* Solo letras de 1 a 30, siendo la primera letra en mayúscula de cada palabra."
    );
  };
  /*--------------FIN VALIDACION PARA NOMBRE--------------------*/

  document.getElementById("enviar").onclick = function () {
    a = valida_registrar();
    if (a != "") {
    } else {
      var datos = new FormData();
      datos.append("accion", $("#accion").val());
      datos.append("id", $("#id").val());
      datos.append("nombre", $("#nombre").val());
      datos.append("id_area", $("#area").val());
      enviaAjax(datos);
      limpiar();
    }
  };

  document.getElementById("nuevo").onclick = function () {
    limpiar();
    $("#accion").val("registrar");
    $("#titulo").text("Registrar Emprendimiento");
    $("#enviar").text("Registrar");
    $("#gestionar-tip_emprendimiento").modal("show");
  };
}

function activar(id) {
  $("#botonasignar" + id).attr("disabled", false);
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
function validaronclick(etiqueta, etiquetamensaje, mensaje) {
  if (etiqueta.value == 0) {
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
  $("#area").val("");
  document.getElementById("snombre").innerText = "";
  document.getElementById("sarea").innerText = "";
  document.getElementById("nombre").classList.remove("is-invalid", "is-valid");
  document.getElementById("area").classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
  var error = false;
  nombre = validarkeyup(
    keyup_nombre,
    document.getElementById("nombre"),
    document.getElementById("snombre"),
    "* Solo letras de 1 a 30, siendo la primera letra en mayúscula de cada palabra."
  );
  area = validaronclick(
    document.getElementById("area"),
    document.getElementById("sarea"),
    "* Seleccione una opcion."
  );
  if (nombre == 0 || area == 0) {
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

function cerrarmodalme() {
  window.location.reload();
}

function asignarmodulo(valor) {
  $("#asignarmodulo").modal({ backdrop: "static", keyboard: false });
  document.getElementById("id_emprendimiento").value = valor;
  var nombreemprendimiento = document.getElementById(
    "nomemprendimiento" + valor
  ).textContent;
  $("#cargaremprendimiento").html("Emprendimiento: " + nombreemprendimiento);
  $("#asignarmodulo").modal("show");
}

function cargar_checkboxme(id) {
  document.getElementById("f3").reset();
  var datos = new FormData();
  datos.append("accion", "cargarme");
  datos.append("id_emprendimiento", id);
  mostrar_emprendimiento(datos);
}

function gestionar_em(id) {
  $("#botonasignar" + id).attr("disabled", true);
  var datos = new FormData();
  datos.append("accion", "registrarme");
  datos.append("idmodulo", id);
  datos.append("idemprendimiento", $("#id_emprendimiento").val());
  datos.append("status", $("#check2" + id).prop("checked"));
  enviadatosAjax(datos);
}

function activarod(id) {
  if ($("#desh" + id).prop("checked")) {
    $("#labelad" + id).html("Activado");
  } else {
    $("#labelad" + id).html("Desactivado");
  }
  var datos = new FormData();
  datos.append("accion", "act_des");
  datos.append("idemprendimiento", id);
  datos.append("status", $("#desh" + id).prop("checked"));
  enviadatosAjax(datos);
}

(function () {
  var datos = new FormData();
  datos.append("accion", "cargarcheckem");
  cargaremprendimiento(datos);
})();

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
        }, 2100);
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
      limpiar();
      $("#id").val(res.id);
      $("#nombre").val(res.nombre);
      $("#area").val(res.id_area);
      $("#enviar").text("Modificar");
      $("#gestionar-tip_emprendimiento").modal("show");
      $("#accion").val("modificar");
      $("#titulo").text("Editar Emprendimiento");
    },
    error: function (err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

function enviadatosAjax(datos) {
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
    success: (response) => {
      var res = JSON.parse(response);
      //alert(res.title);
      if (res.estatus == 1) {
        toastMixin.fire({
          animation: true,
          title: res.title,
          text: res.message,
          icon: res.icon,
        });
      } else {
        toastMixin.fire({
          animation: true,
          text: res.message,
          title: res.title,
          icon: res.icon,
        });
      }
    },
    error: (err) => {
      Toast.fire({
        icon: res.error,
      });
    },
  });
}

function mostrar_emprendimiento(datos) {
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: (response) => {
      var res = JSON.parse(response);
      for (let propiedad in res) {
        if (res != undefined) {
          if (res[propiedad]["idemprendimiento"] != undefined) {
            $("#check2" + res[propiedad]["idmodulo"]).prop("checked", true);
          } else {
            $("#check2" + res[propiedad]["idmodulo"]).prop("checked", false);
          }
        } else {
          $("#check1" + res[propiedad]["idmodulo"]).prop("checked", false);
        }
      }
    },
  });
}

function cargaremprendimiento(datos) {
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: (response) => {
      var res = JSON.parse(response);
      for (let propiedad in res) {
        if (res != undefined) {
          if (res[propiedad]["estatus"] != "false") {
            $("#labelad" + res[propiedad]["id"]).html("Activado");
            $("#desh" + res[propiedad]["id"]).prop("checked", true);
          } else {
            $("#labelad" + res[propiedad]["id"]).html("Desactivado");
            $("#desh" + res[propiedad]["id"]).prop("checked", false);
          }
        } else {
          $("#desh" + res[propiedad]["id"]).prop("checked", false);
        }
      }
    },
  });
}
