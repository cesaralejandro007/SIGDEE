var keyup_nombre = /^[A-ZÁÉÍÓÚ][A-ZÁÉÍÓÚa-zñáéíóú\s]{2,50}$/;
var keyup_descripcion = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{2,100}$/;

document.onload = carga();
function carga() {
  /*--------------VALIDACION PARA NOMBRE--------------------*/
  document.getElementById("nombre").maxLength = 30;
  document.getElementById("nombre").onkeypress = function (e) {
    er = /^[A-Za-z0-9\s\u00f1\u00d1\u00E0-\u00FC]*$/;
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

  /*--------------VALIDACION PARA CEDULA--------------------*/
  document.getElementById("descripcion").maxLength = 100;
  document.getElementById("descripcion").onkeypress = function (e) {
    er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("descripcion").onkeyup = function () {
    r = validarkeyup(
      keyup_descripcion,
      this,
      document.getElementById("sdescripcion"),
      "* El campo debe contener de 2 a 100 letras."
    );
  };
  /*--------------FIN VALIDACION PARA CEDULA--------------------*/

  /*----------------------CRUD DEL MODULO------------------------*/
  document.getElementById("enviar").onclick = function () {

      var datos = new FormData();
      datos.append("accion", "unidad");
      datos.append("nombre", $("#nombre").val());
      datos.append("descripcion", $("#descripcion").val());
      datos.append("id_aula", $("#aula_id").val());
      enviaAjax(datos);

  };

  document.getElementById("nuevo").onclick = function () {
    limpiar1();
    $("#accion").val("registrar");
    $("#titulo").text("Registrar nueva Unidad");
    $("#enviar").text("Registrar");
    $("#gestion-unidad").modal("show");
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
function validarkeyup1(er, etiqueta, etiquetamensaje, mensaje) {
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

function limpiar1() {
  $("#nombre").val("");
  $("#descripcion").val("");
  document.getElementById("snombre").innerText = "";
  document.getElementById("sdescripcion").innerText = "";
  document.getElementById("nombre").classList.remove("is-invalid", "is-valid");
  document
    .getElementById("descripcion")
    .classList.remove("is-invalid", "is-valid");
}

function valida_registrar1() {
  nombre = validarkeyup1(
    keyup_nombre,
    document.getElementById("nombre"),
    document.getElementById("snombre"),
    "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
  );
  descripcion = validarkeyup1(
    keyup_descripcion,
    document.getElementById("descripcion"),
    document.getElementById("sdescripcion"),
    "* El campo debe contener de 2 a 100 letras."
  );
  if (nombre == 0 || descripcion == 0) {
    return true;
  } else {
    return false;
  }
}
function enviaAjax(datos) {
  var toastMixin = Swal.mixin({
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
    success: function(response)  {
      var res = JSON.parse(response);
      //alert(res.title);
      if (res.estatus == 1) {
        toastMixin.fire({

          title: res.title,
          text: res.message,
          icon: res.icon,
        });

        limpiar1();
        setTimeout(function () {
          window.location.reload();
        }, 2000);
      } else {
        toastMixin.fire({

          text: res.message,
          title: res.title,
          icon: res.icon,
        });
      }
    },
    error: function(err) {
      alert(err);
    },
  });
}
