var keyup_nombre = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{3,30}$/;
function cerrarmodalpermisos() {
  window.location.reload();
}
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
        return "EXCEL-Roles"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Roles"
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
        return "PDF-Roles"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Roles"
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
        return "Print-Roles"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Roles"
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

function cargar_usuario(id) {
  var nombre = document.getElementById("usuario" + id).textContent;
  $("#userpermisos").html(":" + nombre);
}

function activar(id) {
  if ($("#check1" + id).prop("checked") == false) {
    $("#registrar" + id).prop("disabled", true);
    $("#consultar" + id).prop("disabled", true);
    $("#eliminar" + id).prop("disabled", true);
    $("#modificar" + id).prop("disabled", true);
  } else {
    $("#registrar" + id).prop("disabled", false);
    $("#consultar" + id).prop("disabled", false);
    $("#eliminar" + id).prop("disabled", false);
    $("#modificar" + id).prop("disabled", false);
  }
}
function activarboton(id) {
  $("#botonguardar" + id).attr("disabled", false);
}
document.onload = carga();
function carga() {
  /*--------------VALIDACION PARA NOMBRE--------------------*/
  document.getElementById("nombre").maxLength = 30;
  document.getElementById("nombre").onkeypress = function (e) {
    er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
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

  /*----------------------CRUD DEL MODULO------------------------*/
  document.getElementById("enviar").onclick = function () {
    a = valida_registrar();
    if (a != "") {
    } else {
      var datos = new FormData();

      datos.append("accion", $("#accion").val());
      datos.append("id", $("#id").val());
      datos.append("nombre", $("#nombre").val());
      enviaAjax(datos);
      limpiar();
    }
  };

  document.getElementById("nuevo").onclick = function () {
    limpiar();
    $("#accion").val("registrar");
    $("#titulo").text("Registrar nuevo rol");
    $("#enviar").text("Registrar");
    $("#gestion-rol").modal("show");
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
  document.getElementById("snombre").innerText = "";
  document.getElementById("nombre").classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
  var error = false;
  nombre = validarkeyup(
    keyup_nombre,
    document.getElementById("nombre"),
    document.getElementById("snombre"),
    "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
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

function cargar_modulos(id_rol) {
  $("#crear-permisos").modal({ backdrop: "static", keyboard: false });
  var datos = new FormData();
  datos.append("accion", "cargarpermisos");
  document.getElementById("id_rol").value = id_rol;
  enviarpermisos(datos);
}

function cargar_checkbox(nombre) {
  document.getElementById("f1").reset();
  var datos = new FormData();
  datos.append("accion", "cargarp");
  datos.append("rol", document.getElementById("id_rol").value);
  enviarpermisos1(datos);
}

function gestionar_permisos(id) {
  $("#botonguardar" + id).attr("disabled", true);
  var datos = new FormData();
  datos.append("accion", "registrarpermisos");
  datos.append("id_entorno", id);
  datos.append("id_rol", $("#id_rol").val());
  datos.append("entorno", $("#check1" + id).prop("checked"));

  if($("#registrar" + id).prop("checked")==undefined){
    datos.append("registrar", "null");
  }else{
    datos.append("registrar", $("#registrar" + id).prop("checked"));
  }

  if($("#consultar" + id).prop("checked")==undefined){
    datos.append("consultar", "null");
  }else{
  datos.append("consultar", $("#consultar" + id).prop("checked"));
  }

  if($("#eliminar" + id).prop("checked")==undefined){
    datos.append("eliminar", "null");
  }else{
  datos.append("eliminar", $("#eliminar" + id).prop("checked"));
  }
  
  if($("#modificar" + id).prop("checked")==undefined){
    datos.append("modificar", "null");
  }else{
  datos.append("modificar", $("#modificar" + id).prop("checked"));
  }
  enviarpermisosajax(datos);
}

function enviarpermisos(datos) {
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: function (data) {},
  });
  $("#crear-permisos").modal("show");
}

function enviarpermisos1(datos) {
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
          if (res[propiedad]["id_entorno"] != undefined) {
            $("#check1" + res[propiedad]["id_entorno"]).prop("checked", true);
            $("#registrar" + res[propiedad]["id_entorno"]).prop(
              "disabled",
              false
            );
            $("#consultar" + res[propiedad]["id_entorno"]).prop(
              "disabled",
              false
            );
            $("#eliminar" + res[propiedad]["id_entorno"]).prop(
              "disabled",
              false
            );
            $("#modificar" + res[propiedad]["id_entorno"]).prop(
              "disabled",
              false
            );
          } else {
            $("#check1" + res[propiedad]["id_entorno"]).prop("checked", false);
          }
        } else {
          $("#check1" + res[propiedad]["id_entorno"]).prop("checked", false);
        }

        if (res[propiedad]["registrar"] != undefined) {
          if (res[propiedad]["registrar"] == "true") {
            $("#registrar" + res[propiedad]["id_entorno"]).prop(
              "checked",
              true
            );
          } else {
            $("#registrar" + res[propiedad]["id_entorno"]).prop(
              "checked",
              false
            );
          }
        } else {
          $("#registrar" + res[propiedad]["id_entorno"]).prop("checked", false);
        }

        if (res[propiedad]["consultar"] != undefined) {
          if (res[propiedad]["consultar"] == "true") {
            $("#consultar" + res[propiedad]["id_entorno"]).prop(
              "checked",
              true
            );
          } else {
            $("#consultar" + res[propiedad]["id_entorno"]).prop(
              "checked",
              false
            );
          }
        } else {
          $("#consultar" + res[propiedad]["id_entorno"]).prop("checked", false);
        }

        if (res[propiedad]["eliminar"] != undefined) {
          if (res[propiedad]["eliminar"] == "true") {
            $("#eliminar" + res[propiedad]["id_entorno"]).prop("checked", true);
          } else {
            $("#eliminar" + res[propiedad]["id_entorno"]).prop(
              "checked",
              false
            );
          }
        } else {
          $("#eliminar" + res[propiedad]["id_entorno"]).prop("checked", false);
        }

        if (res[propiedad]["modificar"] != undefined) {
          if (res[propiedad]["modificar"] == "true") {
            $("#modificar" + res[propiedad]["id_entorno"]).prop(
              "checked",
              true
            );
          } else {
            $("#modificar" + res[propiedad]["id_entorno"]).prop(
              "checked",
              false
            );
          }
        } else {
          $("#modificar" + res[propiedad]["id_entorno"]).prop("checked", false);
        }
      }
    },
  });
}

function configurar() {
  var arrayPermiso = JSON.stringify($("#permiso").val());
  var datos = new FormData();
  datos.append("accion", "configurar");
  datos.append("id_rol", $("#id_c").val());
  datos.append("modulo", arrayPermiso);
  enviaAjax(datos);
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
  }).then((result) => {
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
    error: (err) => {
      Toast.fire({
        icon: res.error,
      });
    },
  });
}

function enviarpermisosajax(datos) {
  var toastMixin = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 1500,
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

function mostrar(datos) {
  $.ajax({
    async: true,
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: (response) => {
      var res = JSON.parse(response);
      limpiar();
      $("#id").val(res.id);
      $("#nombre").val(res.nombre);
      $("#enviar").text("Modificar");
      $("#gestion-rol").modal("show");
      $("#accion").val("modificar");
      document.getElementById("accion").innerText = "modificar";
      $("#titulo").text("Modificar rol");
    },
    error: (err) => {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

function mostrar_modulos(datos) {
  $.ajax({
    async: true,
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: (response) => {
      var res = JSON.parse(response);
      $("#id_c").val(res.id);
      $("#nombre_c").val(res.nombre);
    },
    error: (err) => {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}
/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
