var keyup_cedula = /^[0-9]{7,8}$/;
var keyup_nombre = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{2,30}$/;
var keyup_apellido = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{2,30}$/;
var keyup_telefono = /^[0-9]{11}$/;
var keyup_correo =/^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]{3,25}[@]{1}[A-Za-z0-9]{3,8}[.]{1}[A-Za-z]{2,4}$/;
var keyup_direccion = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{2,100}$/;

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
        return "EXCEL-Estudiantes"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Estudiantes"
      },
      text:      '<i class="fas fa-file-excel text-success"></i> ',
      titleAttr: 'Exportar a Excel',
      className: 'btn border border-success bg-white mr-1',
      exportOptions: {
        columns: [1,2,3,4,5,6]
    }
    },
    {
      extend:    'pdfHtml5',
      filename: function() {
        return "PDF-Estudiantes"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Estudiantes"
      },
      text:      '<i class="fas fa-file-pdf text-danger "></i> ',
      titleAttr: 'Exportar a PDF',
      className: 'btn border border-danger bg-white mr-1',
      exportOptions: {
        columns: [1,2,3,4,5,6]
    }
  },
    {
      extend:    'print',
      filename: function() {
        return "Print-Estudiantes"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Estudiantes"
      },
      text:      '<i class="fa fa-print text-info"></i> ',
      titleAttr: 'Imprimir',
      className: 'btn border border-info bg-white mr-1',
      exportOptions: {
        columns: [1,2,3,4,5,6]
    }
    },    
  ]  
  });     
});

//FUNCION DE BUSQUEDA :V
$("#buscarb").click(function (e) {
  if ($("#buscar").val() == "") {
    $("#buscar").addClass("is-invalid");
    preventDefault(e);
  } else {
    $("#buscar").removeClass("is-invalid");
    var valor = $("#buscar").val();
    var search = new FormData();
    search.append("buscarE", valor);
    search.append("accion", "buscar");
    buscadorAjax(search);
  }
});

document.onload = carga();
function carga() {
  /*--------------VALIDACION PARA CEDULA--------------------*/
  document.getElementById("cedula").maxLength = 8;
  document.getElementById("cedula").onkeypress = function (e) {
    er = /^[JGVEP0-9-]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("cedula").onkeyup = function () {
    r = validarkeyup(
      keyup_cedula,
      this,
      document.getElementById("scedula"),
      "* El formato debe ser 99999999"
    );
  };
  /*--------------FIN VALIDACION PARA CEDULA--------------------*/

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

  /*--------------VALIDACION PARA APELLIDO--------------------*/
  document.getElementById("apellido").maxLength = 30;
  document.getElementById("apellido").onkeypress = function (e) {
    er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("apellido").onkeyup = function () {
    r = validarkeyup(
      keyup_apellido,
      this,
      document.getElementById("sapellido"),
      "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
  };
  /*--------------FIN VALIDACION PARA APELLIDO--------------------*/

  /*--------------VALIDACION PARA TELEFONO--------------------*/
  document.getElementById("telefono").maxLength = 11;
  document.getElementById("telefono").onkeypress = function (e) {
    er = /^[JGVEP0-9-]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("telefono").onkeyup = function () {
    r = validarkeyup(
      keyup_telefono,
      this,
      document.getElementById("stelefono"),
      "* Solo numeros de 11  digitos"
    );
  };
  /*--------------FIN VALIDACION PARA TELEFONO--------------------*/

  /*--------------VALIDACION PARA CORREO--------------------*/
  document.getElementById("correo").maxLength = 30;
  document.getElementById("correo").onkeypress = function (e) {
    er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@.-]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("correo").onkeyup = function () {
    r = validarkeyup(
      keyup_correo,
      this,
      document.getElementById("scorreo"),
      "* El formato debe ser ejemplo@gmail.com"
    );
  };
  /*--------------FIN VALIDACION PARA CORREO--------------------*/

  /*--------------VALIDACION PARA DIRECCION--------------------*/
  document.getElementById("direccion").maxLength = 100;
  document.getElementById("direccion").onkeypress = function (e) {
    er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("direccion").onkeyup = function () {
    r = validarkeyup(
      keyup_direccion,
      this,
      document.getElementById("sdireccion"),
      "* El campo debe contener de 2 a 100 letras."
    );
  };
  /*--------------FIN VALIDACION PARA DIRECCION--------------------*/


  /*----------------------CRUD DEL MODULO------------------------*/
  document.getElementById("enviar").onclick = function () {
    a = valida_registrar();
    if (a != "") {
    } else {
      var datos = new FormData();
      datos.append("accion", $("#accion").val());
      datos.append("cedula", $("#cedula").val());
      datos.append("id", $("#id").val());
      datos.append("nombre", $("#nombre").val());
      datos.append("apellido", $("#apellido").val());
      datos.append("telefono", $("#telefono").val());
      datos.append("correo", $("#correo").val());
      datos.append("direccion", $("#direccion").val());
      datos.append("clave", "Diplomado2023");
      enviaAjax(datos);
    }
  };

  document.getElementById("nuevo").onclick = function () {
    limpiar();
    $("#accion").val("registrar");
    $("#titulo").text("Registrar nuevo estudiante");
    $("#enviar").text("Registrar");
    $("#gestion-estudiante").modal("show");
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
  $("#cedula").val("");
  $("#nombre").val("");
  $("#apellido").val("");
  $("#correo").val("");
  $("#telefono").val("");
  $("#direccion").val("");
  document.getElementById("scedula").innerText = "";
  document.getElementById("snombre").innerText = "";
  document.getElementById("sapellido").innerText = "";
  document.getElementById("scorreo").innerText = "";
  document.getElementById("stelefono").innerText = "";
  document.getElementById("sdireccion").innerText = "";
  document.getElementById("cedula").classList.remove("is-invalid", "is-valid");
  document.getElementById("nombre").classList.remove("is-invalid", "is-valid");
  document
    .getElementById("apellido")
    .classList.remove("is-invalid", "is-valid");
  document.getElementById("correo").classList.remove("is-invalid", "is-valid");
  document
    .getElementById("telefono")
    .classList.remove("is-invalid", "is-valid");
  document
    .getElementById("direccion")
    .classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
  var error = false;
  cedula = validarkeyup(
    keyup_cedula,
    document.getElementById("cedula"),
    document.getElementById("scedula"),
    "* El formato debe ser 99999999"
  );
  nombre = validarkeyup(
    keyup_nombre,
    document.getElementById("nombre"),
    document.getElementById("snombre"),
    "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
  );
  apellido = validarkeyup(
    keyup_apellido,
    document.getElementById("apellido"),
    document.getElementById("sapellido"),
    "Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
  );
  correo = validarkeyup(
    keyup_correo,
    document.getElementById("correo"),
    document.getElementById("scorreo"),
    "* Solo numeros de 11  digitos"
  );
  telefono = validarkeyup(
    keyup_telefono,
    document.getElementById("telefono"),
    document.getElementById("stelefono"),
    "* El formato debe ser ejemplo@gmail.com"
  );
  direccion = validarkeyup(
    keyup_direccion,
    document.getElementById("direccion"),
    document.getElementById("sdireccion"),
    "* El campo debe contener de 2 a 100 letras."
  );
  if (
    cedula == 0 ||
    nombre == 0 ||
    apellido == 0 ||
    correo == 0 ||
    telefono == 0 ||
    direccion == 0 
  ) {
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

$("#cedula").change(function (e) { 
  var datos = new FormData();
  datos.append("accion", "editarregistrar");
  datos.append("cedula",$("#cedula").val());
  mostrarregistrar(datos);
});


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
      //alert(res.title);
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
      $("#cedula").val(res.cedula);
      $("#nombre").val(res.nombre);
      $("#apellido").val(res.apellido);
      $("#telefono").val(res.telefono);
      $("#correo").val(res.correo);
      $("#direccion").val(res.direccion);
      $("#enviar").text("Modificar");
      $("#gestion-estudiante").modal("show");
      $("#accion").val("modificar");
      document.getElementById("accion").innerText = "modificar";
      $("#titulo").text("Modificar estudiante");
      $("#elementosEncontrados").modal("hide");
    },
    error: function (err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

function mostrarregistrar(datos) {
  var toastMixin = Swal.mixin({
    toast: true,
    position: "top-right",
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
  });
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

      if (res.estatus == 0) {
        toastMixin.fire({
          animation: true,
          title: res.title,
          text: res.message,
          icon: res.icon,
        });
      }else{
      limpiar();
      $("#id").val(res.id);
      $("#cedula").val(res.cedula);
      $("#nombre").val(res.nombre);
      $("#apellido").val(res.apellido);
      $("#telefono").val(res.telefono);
      $("#correo").val(res.correo);
      $("#direccion").val(res.direccion);
      $("#enviar").text("Registrar");
      $("#gestion-estudiante").modal("show");
      $("#accion").val("registrar");
      document.getElementById("accion").innerText = "Registrar";
      $("#titulo").text("Registrar nuevo estudiante");
    }
    },
    error: function (err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
