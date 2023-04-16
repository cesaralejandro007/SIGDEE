var keyup_titulo1 = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:()!¡?¿\s]{3,50}$/;
var keyup_mensaje = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:()!¡?¿\s]{3,100}$/;

document.onload = carga();
function carga() {
  /*--------------VALIDACION PARA TITULO--------------------*/
  document.getElementById("titulopublic").maxLength = 50;
  document.getElementById("titulopublic").onkeypress = function (e) {
    er = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9.,()!¡?¿#\s]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("titulopublic").onkeyup = function () {
    r = validarkeyup(
      keyup_titulo1,
      this,
      document.getElementById("stitulopublic"),
      "* Solo letras de 3 a 50 letras."
    );
  };
  /*--------------FIN VALIDACION PARA TITULO--------------------*/

  /*--------------VALIDACION PARA MENSAJE--------------------*/
  document.getElementById("mensaje").maxLength = 100;
  document.getElementById("mensaje").onkeypress = function (e) {
    er = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9.,()!¡?¿#\s]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("mensaje").onkeyup = function () {
    r = validarkeyup(
      keyup_mensaje,
      this,
      document.getElementById("smensaje"),
      "* El campo debe contener de 3 a 100 letras."
    );
  };
  /*--------------FIN VALIDACION PARA MANESAJE--------------------*/

  /*----------------------CRUD DEL MODULO------------------------*/
  document.getElementById("enviarforo").onclick = function () {
    a = valida_registrar();
    if (a != "") {
    } else {
      var datos = new FormData();
      datos.append("accion", $("#accion").val());
      datos.append("id", $("#id").val());
      datos.append("titulo", $("#titulopublic").val());
      datos.append("mensaje", $("#mensaje").val());
      datos.append("id_aula", $("#id_aula").val());
      datos.append("cedula_usuario", $("#cedula_usuario").val());
      enviaAjax(datos);
      limpiar();
    }
  };

  document.getElementById("publicarforo").onclick = function () {
    limpiar();
    $("#accion").val("registrarforo");
    $("#enviarforo").text("Registrar foro");
    $("#tituloprincipal").text("Registrar foro");
    $("#gestion-foro").modal("show");
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
  $("#titulopublic").val("");
  $("#mensaje").val("");
  $("#accion").val("");
  document.getElementById("titulopublic").innerText = "";
  document.getElementById("smensaje").innerText = "";
  document
    .getElementById("titulopublic")
    .classList.remove("is-invalid", "is-valid");
  document.getElementById("mensaje").classList.remove("is-invalid", "is-valid");
}

function valida_registrar() {
  var error = false;
  titulo = validarkeyup(
    keyup_titulo1,
    document.getElementById("titulopublic"),
    document.getElementById("stitulopublic"),
    "* Solo letras de 3 a 50 caracteres, siendo la primera en mayúscula."
  );
  mensaje = validarkeyup(
    keyup_mensaje,
    document.getElementById("mensaje"),
    document.getElementById("smensaje"),
    "* El campo debe contener de 2 a 100 letras."
  );
  if (titulo == 0 || mensaje == 0) {
    //variable==0, indica que hubo error en la validacion de la etiqueta
    error = true;
  }
  return error;
}

function cargar_datos(valor) {
  limpiar();
  var datos = new FormData();
  datos.append("accion", "editarforo");
  datos.append("id", valor);
  mostrar(datos);
}

function cargarcomentarios(valor) {
  var datos = new FormData();
  datos.append("accion", "cargarcomentarios");
  datos.append("id", valor);
  cargarcomentariosajax(datos);
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
  }).then(function(result) {
    if (result.isConfirmed) {
      setTimeout(function () {
        var datos = new FormData();
        datos.append("accion", "eliminarforo");
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
    position: "top-center",
    showConfirmButton: false,
    width: 450,
    padding: '3.5em',
    timer: 2500,
    timerProgressBar: true,
  });
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: function(response) {
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
    error: function(err) {
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
    success: function(response) {
      var res = JSON.parse(response);
      limpiar();
      $("#accion").val("modificarforo");
      $("#id").val(res.id);
      $("#titulopublic").val(res.titulo);
      $("#mensaje").val(res.mensaje);
      $("#id_aula").val(res.id_aula);
      $("#enviarforo").text("Modificar foro");
      $("#gestion-foro").modal("show");
      $("#tituloprincipal").text("Modificar foro");
    },
    error: function(err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}
/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
