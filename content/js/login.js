var keyup_cedula = /^[0-9]{7,8}$/;
var keyup_clave = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{6,15}$/;
var keyup_seguridad = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.@#%$^&*!?:]{3,25}$/;
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

function mostrarpasswordr() {
  var cambio = document.getElementById("passwordEmergente");
  if (cambio.type == "password") {
    cambio.type = "text";
  } else {
    cambio.type = "password";
  }
}

function mostrarpasswordr2() {
  var cambio = document.getElementById("passwordEmergente2");
  if (cambio.type == "password") {
    cambio.type = "text";
  } else {
    cambio.type = "password";
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
    allowOutsideClick: false
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
      if(res.estatus == 3){
        document.getElementById("validarusuario").innerHTML = '<div class="alert alert-dismissible fade show p-2" style="background:#9D2323; color:white" " role="alert">'+ res.message +'<button type="button" id="cerraralert" class="btn-close p-2" style="font-size:10px;" data-dismiss="alert" aria-label="Close"></button></div>';
        setTimeout(function () {
          $("#cerraralert").click();
        }, 6000);
      }
      else if(res.estatus == 2){
        document.getElementById("validarusuario").innerHTML = '<div class="alert alert-dismissible fade show p-2" style="background:#9D2323; color:white" " role="alert">'+ res.message +'<button type="button" id="cerraralert" class="btn-close p-2" style="font-size:10px;" data-dismiss="alert" aria-label="Close"></button></div>';
        setTimeout(function () {
          $("#cerraralert").click();
        }, 6000);
      }
      else if (res.estatus == 1) {
        var formData = new FormData();
        formData.append("accion", "codificarURL");
        $.ajax({
          url: "",
          type: "POST",
          contentType: false,
          data: formData,
          processData: false,
          cache: false,
          success: function (response) {
            toastMixin.fire({
              title: res.title,
              text: res.message,
              icon: res.icon
            });
            limpiar();
            setTimeout(function () {
              window.location.replace("?pagina="+response);
            }, 2000);
        }
        });
      } else {
        document.getElementById("validarusuario").innerHTML = '<div class="alert alert-dismissible fade show p-2" style="background:#9D2323; color:white" " role="alert">'+res.message+'<button type="button" id="cerraralert" class="btn-close p-2" style="font-size:10px;" data-dismiss="alert" aria-label="Close"></button></div>';
        setTimeout(function () {
          $("#cerraralert").click();
        }, 6000);
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
                if (resultado.status == 0) {
                    document.getElementById("cedulaEmergente").style.borderColor = "red";
                    document.getElementById("textoCedula").innerHTML = resultado.message;
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
                        document.getElementById("modificarContrasenia").value = 'Recuperar';
                        $("#info").show(500);
                    }
                }
            });
        }
    } else {
      a = valida_registrar1();
      if (a != "") {
          return false;
          } else {
        if (document.getElementById("mascota").value == "" || document.getElementById("animFav").value == "" || document.getElementById("colorFav").value == "") {
            toastMixin.fire({
              title: "Error",
              text: "Ingrese todas las preguntas de seguridad",
              icon: "error",
            });
        } else {

          var pregunta = document.getElementById("colorFav").value + document.getElementById("animFav").value + document.getElementById("mascota").value;
          var formData = new FormData();
          formData.append("accion", "Verificar_preguntas");
          formData.append("cedula", document.getElementById("cedulaEmergente").value);
          formData.append("preguntas_ingresadas", pregunta.toLowerCase());
          $.ajax({
              url: '',
              type: 'POST',
              contentType: false,
              data:formData,
              processData: false,
          }).done(function(result) {
            var resultado = JSON.parse(result);
            if (resultado.status == 1) {
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
                      var res = JSON.parse(datos);
                        if (res.estatus == 1) {
                            toastMixin.fire({
                              title: res.title,
                              text: res.message,
                              icon: res.icon
                            });
                            $('#gestion-recuperar').modal('hide');
                            setTimeout(function () {
                              window.location.reload();
                            }, 3000);
                        }else{
                          toastMixin.fire({
                            title: res.title,
                            text: res.message,
                            icon: res.icon
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
      

          });

        }
      }
    }
    document.getElementById("passwordEmergente").onkeypress = function (e) {
      er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@,.#%$^&*!?:]*$/;
      validarkeypress(er, e);
    };
    document.getElementById("passwordEmergente").onkeyup = function () {
      r = validarkeyup(
        keyup_clave,
        this,
        document.getElementById("vcontrasena"),
        "El campo debe contener de 6 a 15 caracteres"
      );
    };
    document.getElementById("passwordEmergente2").onkeypress = function (e) {
      er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@,.#%$^&*!?:]*$/;
      validarkeypress(er, e);
    };
    document.getElementById("passwordEmergente2").onkeyup = function () {
      r = validarkeyup(
        keyup_clave,
        this,
        document.getElementById("vcontrasena"),
        "El campo debe contener de 6 a 15 caracteres"
      );
    };
    document.getElementById("colorFav").onkeypress = function (e) {
      er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@,.#%$^&*!?:]*$/;
      validarkeypress(er, e);
    };
  document.getElementById("colorFav").onkeyup = function () {
      r = validarkeyup(
        keyup_seguridad,
        this,
        document.getElementById("vcolor"),
        "El campo debe contener de 3 a 25 caracteres"
      );
    };
      document.getElementById("animFav").onkeypress = function (e) {
        er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@,.#%$^&*!?:]*$/;
        validarkeypress(er, e);
      };
    document.getElementById("animFav").onkeyup = function () {
        r = validarkeyup(
          keyup_seguridad,
          this,
          document.getElementById("vanimal"),
          "El campo debe contener de 3 a 25 caracteres"
        );
      };
    
    document.getElementById("mascota").onkeypress = function (e) {
      er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@,.#%$^&*!?:]*$/;
        validarkeypress(er, e);
      };
    document.getElementById("mascota").onkeyup = function () {
        r = validarkeyup(
          keyup_seguridad,
          this,
          document.getElementById("vmascota"),
          "El campo debe contener de 3 a 25 caracteres"
        );
    };
}

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

function valida_registrar1() {
  var error = false;
  contrasena1 = validarkeyup(
    keyup_clave,
    document.getElementById("passwordEmergente"),
    document.getElementById("vcontrasena"),
    "El campo debe contener de 5 a 8 caracteres"
  );
  contrasena2 = validarkeyup(
    keyup_clave,
    document.getElementById("passwordEmergente2"),
    document.getElementById("vcontrasena"),
    "El campo debe contener de 5 a 8 caracteres"
  );
  color = validarkeyup(
    keyup_seguridad,
    document.getElementById("colorFav"),
    document.getElementById("vcolor"),
    "El campo debe contener de 3 a 25 caracteres"
  );
  animal = validarkeyup(
    keyup_seguridad,
    document.getElementById("animFav"),
    document.getElementById("vanimal"),
    "El campo debe contener de 3 a 25 caracteres"
  );
  mascota = validarkeyup(
    keyup_seguridad,
    document.getElementById("mascota"),
    document.getElementById("vmascota"),
    "El campo debe contener de 3 a 25 caracteres"
  );

  if (
    contrasena1 == 0 ||
    contrasena2 == 0 ||
    color == 0 || 
    animal == 0 || 
    mascota == 0 
  ) {
    //variable==0, indica que hubo error en la validacion de la etiqueta
    error = true;
  }
  return error;
}

/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
