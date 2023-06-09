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

$("#recuperarcontrasena").click(function () {
  $("#gestion-recuperar").modal("show");
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

var info = "";
document.getElementById("modificarContrasenia").onclick = function() {
    var toastMixin = Swal.mixin({
      showConfirmButton: false,
      width: 450,
      padding: '3.5em',
      timer: 3000,
      timerProgressBar: true,
    });
    if (document.getElementById("modificarContrasenia").value == "Consultar") {
        if (document.getElementById("cedulaEmergente").value == "") {
            document.getElementById("cedulaEmergente").style.borderColor = "red";
            document.getElementById("textoCedula").innerHTML = "Ingrese la cédula por favor";
            document.getElementById("textoCedula").style.color = 'red';
            document.getElementById("cedulaEmergente").focus();
        } else {
            document.getElementById("cedulaEmergente").style.borderColor = "";
            document.getElementById("textoCedula").innerHTML = "";
            var formData = new FormData();
            formData.append("accion", "verificar_usuario");
            formData.append("cedula", document.getElementById("cedulaEmergente").value);
            $.ajax({
                url: '',
                type: 'POST',
                contentType: false,
                data:formData,
                processData: false,
            }).done(function(result) {
              var resultado = JSON.parse(result);
                if (result == 0) {
                    document.getElementById("cedulaEmergente").style.borderColor = "red";
                    document.getElementById("textoCedula").innerHTML = "Usuario no válido";
                    document.getElementById("textoCedula").style.color = 'red';
                    document.getElementById("cedulaEmergente").focus();
                } else {
                    if (resultado.preguntas_seguridad == "" || resultado.preguntas_seguridad == null) {
                      toastMixin.fire({
                        title: "Error",
                        text: "Su usuario no posee preguntas de seguridad registradas. Colóquese en contacto con un super usuario para recuperar su contraseña",
                        icon: "error",
                      });
                    } else {
                        document.getElementById("cedulaEmergente").style.borderColor = "";
                        document.getElementById("textoCedula").innerHTML = "";
                        document.getElementById("cedulaEmergente").readOnly = "readOnly";
                        document.getElementById("textoCedula").style.color = "green";
                        pregunta_bd = resultado.preguntas_seguridad;
                        document.getElementById("textoCedula").innerHTML = resultado.primer_nombre + " " + resultado.primer_apellido;
                        document.getElementById("modificarContrasenia").value = 'Listo';
                        $("#info").show(500);
                    }
                }
            });
        }
    } else {
        if (document.getElementById("mascota").value == "" || document.getElementById("animFav").value == "" || document.getElementById("colorFav").value == "") {
            toastMixin.fire({
              title: "Error",
              text: "Ingrese todas las preguntas de seguridad",
              icon: "error",
            });
        } else {
            var pregunta = document.getElementById("colorFav").value + document.getElementById("animFav").value + document.getElementById("mascota").value;
            if (pregunta.toLowerCase() == pregunta_bd.toLowerCase()) {
                if (document.getElementById("passwordEmergente").value == "" || document.getElementById("passwordEmergente2").value == "" || document.getElementById("passwordEmergente").value != document.getElementById("passwordEmergente2").value) {
                    toastMixin.fire({
                      title: "Error",
                      text: "Debe ingresar la clave y la confirmación de la contraseña. Ambos campos deben ser iguales",
                      icon: "error",
                    });
                } else {
                  var formData = new FormData();
                  formData.append("accion", "cambiar_clave");
                  formData.append("cedula", document.getElementById("cedulaEmergente").value);
                  formData.append("clave_actualizada", document.getElementById("passwordEmergente").value);
                    $.ajax({
                        url: "",
                        type: "POST",
                        contentType: false,
                        data: formData,
                        processData: false,
                        cache: false,
                    }).done(function(datos) {
                        if (datos == 1) {
                            toastMixin.fire({
                              title: "Éxito",
                              text: "Su contraseña ha sido cambiada exitosamente",
                              icon: "success",
                            });
                            $('#gestion-recuperar').modal('hide');
                            setTimeout(function () {
                              window.location.replace("?pagina=Login");
                            }, 3000);
                        }else{
                          toastMixin.fire({
                            title: "Error",
                            text: "error BD",
                            icon: "error",
                          });
                        }
                    })
                }
            } else {
              toastMixin.fire({
                title: "Error",
                text: "Los datos de seguridad ingresados son incorrectos",
                icon: "error",
              });
            }
        }
    }
}

/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
