var keyup_cedula = /^[0-9]{7,8}$/;

document.onload = carga();
function carga() {
  /*--------------VALIDACION PARA CEDULA--------------------*/
  document.getElementById("floatingInput").maxLength = 8;
  document.getElementById("floatingInput").onkeypress = function (e) {
    er = /^[JGVEP0-9-]*$/;
    validarkeypress(er, e);
  };
  function validarkeypress(er, e) {
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if (!a) {
      e.preventDefault();
    }
  }
}

function mostrarPassword() {
  var cambio = document.getElementById("floatingPassword");
  if (cambio.type == "password") {
    cambio.type = "text";
    $(".icon").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
  } else {
    cambio.type = "password";
    $(".icon").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
  }
}

$(document).ready(function () {
  //CheckBox mostrar contraseña
  $("#ShowPassword").click(function () {
    $("#Password").attr("type", $(this).is(":checked") ? "text" : "password");
  });

  $("#recuperarcontrasena").click(function () {
    $("#gestion-recuperar").modal("show");
  });

  $("#recuperarc").click(function () {
    var datos = new FormData();
    datos.append("accion", "recuperar");
    datos.append("user", $("#usuarior").val());
    datos.append("nombre", $("#nombrer").val());
    datos.append("apellido", $("#apellidor").val());
    datos.append("correo", $("#correor").val());
    datos.append("telefono", $("#telefonor").val());
    enviaAjaxcorreo(datos);
  });
});

$("#entrar").click(function (e) {
  var datos = new FormData();
  datos.append("accion", "ingresar");
  datos.append("tipo", $("#tipodeusuario").val());
  datos.append("user", $("#floatingInput").val());
  datos.append("password", $("#floatingPassword").val());
  enviaAjax(datos);
});

function limpiar() {
  setTimeout(function () {
    $("#floatingCapcha").val("");
    $("#floatingInput").val("");
    $("#floatingPassword").val("");
  }, 2000);
}

function limpiar() {
  setTimeout(function () {
    $("#usuarior").val("");
    $("#nombrer").val("");
    $("#apellidor").val("");
    $("#correor").val("");
    $("#telefonor").val("");
  }, 2000);
}

function enviaAjax(datos) {
  var toastMixin = Swal.mixin({
    showConfirmButton: false,
    width: 450,
    padding: '3.5em',
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

          title: res.title,
          text: res.message,
          icon: res.icon,
        });
        limpiar();
        setTimeout(function () {
          window.location.replace("?pagina=principal");
        }, 2000);
      } else {
        toastMixin.fire({

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

function enviaAjaxcorreo(datos) {
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
    success: function (response) {
      var res = JSON.parse(response);
      //alert(res.title);
      if (res.estatus == 1) {
        toastMixin.fire({

          title: res.title,
          text: res.message,
          icon: res.icon,
        });
        setTimeout(function () {
          limpiar();
          $("#gestion-recuperar").modal("hide");
          var etiquetacorreo = document.getElementById("mensajedecorreo");
          etiquetacorreo.innerHTML =
            '<div class="alert alert-success alert-dismissible fade show" role="alert">' +
            "Se envio la informacion de su clave al correo electronico." +
            '<button type="button" id="cerrarventanamensaje" class="btn-close" data-dismiss="alert" aria-label="Close"></button>' +
            "</div>";
        }, 3000);
        setTimeout(function () {
          $("#cerrarventanamensaje").click();
        }, 10000);
      } else {
        toastMixin.fire({

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

/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
