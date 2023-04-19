var keyup_cedula = /^[0-9]{7,8}$/;
var keyup_nombre = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{2,30}$/;
var keyup_apellido = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{2,30}$/;
var keyup_telefono = /^[0-9]{11}$/;
var keyup_correo =/^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]{3,25}[@]{1}[A-Za-z0-9]{3,8}[.]{1}[A-Za-z]{2,4}$/;
var keyup_direccion = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{2,100}$/;

/* function mostrarPassword() {
  var cambio = document.getElementById("clave");
  if (cambio.type == "password") {
    cambio.type = "text";
    $(".icon").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
  } else {
    cambio.type = "password";
    $(".icon").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
  }
} */


/* $(document).ready(function () {
  //CheckBox mostrar contraseña
  $("#ShowPassword").click(function () {
    $("#Password").attr("type", $(this).is(":checked") ? "text" : "password");
  });
}); */

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
        return "EXCEL-Usuarios"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Usuarios"
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
        return "PDF-Usuarios"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Usuarios"
      },
      text:      '<i class="fas fa-file-pdf text-danger "></i> ',
      titleAttr: 'Exportar a PDF',
      className: 'btn border border-danger bg-white mr-1',
      customize: function ( doc ) {
        doc.pageMargins = [30, 60, 30,20 ];
        var cols = [];
        cols[0] = {        
        margin: [ 10, 0, 0, 2 ],
        alignment: 'start',
        image: 'data:image/png;base64,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',
        width: 575,
        height: 50};
        cols[1] = {text: ""};
        var objFooter = {};
        objFooter['columns'] = cols;
        doc['header']=objFooter;
        // Splice the image in after the header, but before the table
        },
      exportOptions: {
        columns: [1,2,3,4,5,6]
    }
  },
    {
      extend:    'print',
      filename: function() {
        return "Print-Usuarios"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Usuarios"
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
      "* Solo numeros de 11 digitos"
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
  /*--------------FIN VALIDACION PARA CLAVE--------------------*/

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
      datos.append("correo", $("#correo").val());
      datos.append("direccion", $("#direccion").val());
      datos.append("telefono", $("#telefono").val());
      datos.append("id_rol", $("#rol").val());
      datos.append("clave", "Diplomado2023");
      enviaAjax(datos);
    }
  };

  document.getElementById("nuevo").onclick = function () {
    limpiar();
    $("#accion").val("registrar");
    $("#titulo").text("Registrar nuevo usuario");
    $("#enviar").text("Registrar");
    $("#gestion-usuario").modal("show");
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
  document.getElementById("direccion").classList.remove("is-invalid", "is-valid");
  document
    .getElementById("apellido")
    .classList.remove("is-invalid", "is-valid");
  document.getElementById("correo").classList.remove("is-invalid", "is-valid");
  document
    .getElementById("telefono")
    .classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
  var error = false;
  cedula = validarkeyup(
    keyup_cedula,
    document.getElementById("cedula"),
    document.getElementById("scedula"),
    "* El formato debe ser 99999999."
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
    "* El formato debe ser ejemplo@gmail.com"
  );
  telefono = validarkeyup(
    keyup_telefono,
    document.getElementById("telefono"),
    document.getElementById("stelefono"),
    "* Solo numeros de 11  digitos"
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

function cerrarmodalrol() {
  window.location.reload();
}
//alert($("#id_usuario").val());

function cargar_rol(iduser) {
  $("#crear-rol").modal({ backdrop: "static", keyboard: false });
  document.getElementById("id_usuario").value = iduser;
  var cedula = document.getElementById("cedulausuario" + iduser).textContent;
  var nombre = document.getElementById("nombreusuario" + iduser).textContent;
  var apellido = document.getElementById(
    "apellidousuario" + iduser
  ).textContent;
  $("#usuariocargar").html(
    "Usuario: " + cedula + ", " + nombre + " " + apellido
  );
  $("#crear-rol").modal("show");
}

function cargar_checkbox(id) {
  document.getElementById("f2").reset();
  var datos = new FormData();
  datos.append("accion", "cargarroles");
  datos.append("id_usuario", id);
  mostrar_roles(datos);
}

function gestionar_rol(id) {
  var datos = new FormData();
  datos.append("accion", "registrarroles");
  datos.append("idrol", id);
  datos.append("idusuario", $("#id_usuario").val());
  datos.append("status", $("#check2" + id).prop("checked"));
  enviadatosAjax(datos);
}

/*-------------------FIN DE FUNCIONES DE HERRAMIENTAS-------------------*/

/*--------------------FUNCIONES CON AJAX----------------------*/
function eliminar(id) {
  Swal.fire({
    title: "¿Está seguro de eliminar el registro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCloseButton: true,
    showCancelButton: true,
    confirmButtonColor: "#0C72C4",
    cancelButtonColor: "#9D2323",
    confirmButtonText: "Confirmar",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      setTimeout(function () {
        var datos = new FormData();
        datos.append("accion", "eliminar");
        datos.append("id", id);
        datos.append("cedula", $("#idusuario-"+id).val());
        enviaAjax(datos);
      }, 10);
    }
  });
}

function enviaAjax(datos) {
  var toastMixin = Swal.mixin({
    position: "top-center",
    showConfirmButton: false,
    width: 450,
    padding: '3.5em',
    timer: 3000,
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

        limpiar();
        setTimeout(function () {
          window.location.reload();
        }, 3000);
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

function enviadatosAjax(datos) {
  var toastMixin = Swal.mixin({
    toast: true,
    width: 300,
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
    success: (response) => {
      var res = JSON.parse(response);
      limpiar();
      $("#id").val(res.id);
      $("#cedula").val(res.cedula);
      $("#nombre").val(res.nombre);
      $("#apellido").val(res.apellido);
      $("#correo").val(res.correo);
      $("#direccion").val(res.direccion);
      $("#telefono").val(res.telefono);
      $("#rol").val(res.id_rol);
      $("#enviar").text("Modificar");
      $("#gestion-usuario").modal("show");
      $("#accion").val("modificar");
      document.getElementById("accion").innerText = "modificar";
      $("#titulo").text("Modificar usuario");
      $("#elementosEncontrados").modal("hide");
    },
    error: (err) => {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
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

function mostrar_roles(datos) {
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
          if (res[propiedad]["cedula"] != undefined) {
            $("#check2" + res[propiedad]["id_rol"]).prop("checked", true);
          } else {
            $("#check2" + res[propiedad]["id_rol"]).prop("checked", false);
          }
        } else {
          $("#check1" + res[propiedad]["id_entorno"]).prop("checked", false);
        }
      }
    },
  });
}

/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
