var keyup_telefono = /^[0-9]{11}$/;
var keyup_correo =/^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]{3,25}[@]{1}[A-Za-z0-9]{3,8}[.]{1}[A-Za-z]{2,4}$/;
var keyup_clave = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{6,15}$/;
var keyup_seguridad = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.@#%$^&*!?:]{3,25}$/;

      document.getElementById("cambiar_clave"). onclick = function(){
        Swal.fire({
            title: 'Cambiar contraseña',
            html:                     
              '<span id="validarcontrasena1"></span>' +
              '<label for="message-text" style="color: rgb(21, 64, 109);" class="col-form-label">Informacion de contraseña:</label><br>'+
              '<span id="v1" style="font-size:14px"></span><div class="input-group mt-1"><input id="input1" maxlength="15" class="form-control mb-2" type="password" placeholder="Ingrese la contraseña actual"/><div class="input-group-append"><button id="show_password" class="btn border border-left-0 mb-2" type="button" onclick="mostrarPassword()"><i class="fas fa-low-vision" style="font-size:16px; color:#8C8F92"></i></div></div>',
            confirmButtonColor: '#15406D',
            confirmButtonText: "Siguiente",
            focusConfirm: true,
            preConfirm: () => {
                if(document.getElementById('input1').value != ""){
                  var formData = new FormData();
                  formData.append("accion", "verificar_perfil");
                  formData.append("clave_actual", document.getElementById("input1").value);
                  formData.append("cedula", document.getElementById("cedula_usuario_foto").value);
                  $.ajax({
                    url: '',
                    type: 'POST',
                    contentType: false,
                    data:formData,
                    processData: false,
                    cache: false,
                    }).done(function (result) {
                        if(result==1){
                            cambiarpassword();
                            return true;
                        }else if(result == 0){
                            document.getElementById("validarcontrasena1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">La contraseña actual no coincide.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
                            setTimeout(function () {
                                $("#cerraralert").click();
                              }, 3000);
                            return false;
                        }else{
                            document.getElementById("validarcontrasena1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">Error BD.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
                            setTimeout(function () {
                                $("#cerraralert").click();
                              }, 3000);
                            return false;
                        }
                    });
                    return false;
              }else{
                document.getElementById("validarcontrasena1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">Complete los campos solicitados.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
                setTimeout(function () {
                    $("#cerraralert").click();
                  }, 3000);
                return false;
              }
            }
          })
        }

        function validarkeypress(er, e) {
          key = e.keyCode || e.which;
          tecla = String.fromCharCode(key);
          a = er.test(tecla);
          if (!a) {
            e.preventDefault();
          }
        }


        function mostrarPassword() {
          var cambio = document.getElementById("input0");
          if (cambio.type == "password") {
            cambio.type = "text";
          } else {
            cambio.type = "password";
          }
        }
        
        function cambiarpassword(){
          Swal.fire({
              title: 'Cambiar contraseña',
              html:                        
                '<span id="validarcontrasena1"></span>' +
                '<label for="message-text" style="color: rgb(21, 64, 109);" class="col-form-label">Informacion de contraseña:</label><br>'+
                '<span id="v1" style="font-size:14px"></span><div class="input-group mt-1"><input id="input1" maxlength="15" class="form-control mb-2" type="password" placeholder="Contraseña"/><div class="input-group-append"><button id="show_password" class="btn border border-left-0 mb-2" type="button" onclick="mostrarPassword()"><i class="fas fa-low-vision" style="font-size:16px; color:#8C8F92"></i></div></div>' +
                '<span id="v2" style="font-size:14px"></span><div class="input-group mt-1"><input id="input2" maxlength="15" class="form-control mb-2" type="password" placeholder="Confirmar contraseña"/><div class="input-group-append"><button id="show_password" class="btn border border-left-0 mb-2" type="button" onclick="mostrarPassword1()"><i class="fas fa-low-vision" style="font-size:16px; color:#8C8F92"></i></div></div>'+
                '<label for="message-text" style="color: rgb(21, 64, 109);" class="col-form-label">Preguntas de seguridad:</label><br>'+
                '<span id="v3" style="font-size:14px"></span><input type="text" maxlength="25" id="color" placeholder="Ingrese el color favorito" class="form-control mb-2">' +
                '<span id="v4" style="font-size:14px"></span><input type="text" maxlength="25" id="animal" placeholder="Ingrese el animal favorito" class="form-control mb-2">' +
                '<span id="v5" style="font-size:14px"></span><input type="text" maxlength="25" id="mascota" placeholder="Ingrese el nombre de la primera mascota" class="form-control mb-2">',
              confirmButtonColor: '#15406D',
              confirmButtonText: "Cambiar",
              focusConfirm: true,
              preConfirm: () => {
                  if(document.getElementById('input1').value != "" && document.getElementById('input2').value != "" && document.getElementById('color').value != "" && document.getElementById('animal').value != "" && document.getElementById('mascota').value != ""){
                  if(document.getElementById('input1').value == document.getElementById('input2').value){
                    a = valida_registrar1();
                    if (a != "") {
                        return false;
                        } else {
                      preguntas_seguridad = document.getElementById('color').value.toLowerCase()+document.getElementById('animal').value.toLowerCase()+document.getElementById('mascota').value.toLowerCase();
                      cambiarcontraseña( 
                          document.getElementById('input1').value,
                          preguntas_seguridad,
                          document.getElementById("cedula_usuario_foto").value
                          );
                      }
                  }else{
                      document.getElementById("validarcontrasena1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">La contraseña no coincide.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
                      setTimeout(function () {
                          $("#cerraralert").click();
                        }, 3000);
                      return false;
                  }
                }else{
                  document.getElementById("validarcontrasena1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">Complete los campos solicitados.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
                  setTimeout(function () {
                      $("#cerraralert").click();
                    }, 3000);
                  return false;
                }
              }
            })
                      //-------------------------------------------------------------------------------
          document.getElementById("input1").onkeypress = function (e) {
            er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@,.#%$^&*!?:]*$/;
            validarkeypress(er, e);
          };
          document.getElementById("input1").onkeyup = function () {
            r = validarkeyup(
              keyup_clave,
              this,
              document.getElementById("v1"),
              "El campo debe contener de 6 a 15 caracteres"
            );
          };
          document.getElementById("color").onkeypress = function (e) {
            er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@,.#%$^&*!?:]*$/;
            validarkeypress(er, e);
          };
        document.getElementById("color").onkeyup = function () {
            r = validarkeyup(
              keyup_seguridad,
              this,
              document.getElementById("v3"),
              "El campo debe contener de 3 a 25 caracteres"
            );
          };
            document.getElementById("animal").onkeypress = function (e) {
              er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@,.#%$^&*!?:]*$/;
              validarkeypress(er, e);
            };
          document.getElementById("animal").onkeyup = function () {
              r = validarkeyup(
                keyup_seguridad,
                this,
                document.getElementById("v4"),
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
                document.getElementById("v5"),
                "El campo debe contener de 3 a 25 caracteres"
              );
          };
      }

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

/*--------------VALIDACION PARA CLAVE--------------------*/

function cargar_datos(valor) {
  var datos = new FormData();
  datos.append("accion", "editarperfil");
  datos.append("id", valor);
  mostrar(datos);
}

function mostrarPassword() {
  var cambio = document.getElementById("input1");
  if (cambio.type == "password") {
    cambio.type = "text";
    $(".icon").removeClass("fa fa-eye-slash").addClass("fa fa-eye");
  } else {
    cambio.type = "password";
    $(".icon").removeClass("fa fa-eye").addClass("fa fa-eye-slash");
  }
}
function mostrarPassword1() {
  var cambio = document.getElementById("input2");
  if (cambio.type == "password") {
    cambio.type = "text";
  } else {
    cambio.type = "password";
  }
}


function valida_registrar1() {
  var error = false;
  contrasena1 = validarkeyup(
    keyup_clave,
    document.getElementById("input1"),
    document.getElementById("v1"),
    "El campo debe contener de 5 a 8 caracteres"
  );
  contrasena2 = validarkeyup(
    keyup_clave,
    document.getElementById("input2"),
    document.getElementById("v2"),
    "El campo debe contener de 5 a 8 caracteres"
  );
  color = validarkeyup(
    keyup_seguridad,
    document.getElementById("color"),
    document.getElementById("v3"),
    "El campo debe contener de 3 a 25 caracteres"
  );
  animal = validarkeyup(
    keyup_seguridad,
    document.getElementById("animal"),
    document.getElementById("v4"),
    "El campo debe contener de 3 a 25 caracteres"
  );
  mascota = validarkeyup(
    keyup_seguridad,
    document.getElementById("mascota"),
    document.getElementById("v5"),
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

$("#modificarp").click(function () {
  a = valida_registrar();
  if (a != "") {
  } else {
    var datos = new FormData();
    datos.append("accion", "modificarperfil");
    datos.append("id", $("#id").val());
    datos.append("correo", $("#correo").val());
    datos.append("telefono", $("#telefono").val());
    enviaAjax(datos);
  }
  }); 

  function readURL(input) {
    if (input.files && input.files[0]) {
  
      var reader = new FileReader();
  
      reader.onload = function(e) {
        $('.image-upload-wrap').hide();
  
        $('.file-upload-image').attr('src', e.target.result);
        $('.file-upload-content').show();
  
        $('.image-title').html(input.files[0].name);
      };
  
      reader.readAsDataURL(input.files[0]);
  
    } else {
      removeUpload();
    }
  }
  
  function removeUpload() {
    $('.file-upload-input').replaceWith($('.file-upload-input').clone());
    $('.file-upload-content').hide();
    $('.image-upload-wrap').show();
    $('#archivo_adjunto').val("");
  }
  $('.image-upload-wrap').bind('dragover', function () {
      $('.image-upload-wrap').addClass('image-dropping');
    });
    $('.image-upload-wrap').bind('dragleave', function () {
      $('.image-upload-wrap').removeClass('image-dropping');
  });

  $("#modificarf").click(function () {
      var datos = new FormData();
      datos.append("accion", "modificarfotoperfil");
      datos.append("cedula", $("#cedula_usuario_foto").val());
      if ($("#archivo_adjunto")[0].files[0] != null) {
          datos.append("archivo", $("#archivo_adjunto")[0].files[0]);
      }
      enviaAjax(datos);
    });  

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
  

function valida_registrar() {
  var error = false;
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
  if (
    correo == 0 ||
    telefono == 0
  ) {
    //variable==0, indica que hubo error en la validacion de la etiqueta
    error = true;
  }
  return error;
}


function limpiar() {
    $("#correo").val("");
    $("#telefono").val("");
}

function cambiarcontraseña(contrasena,preguntas,cedula){
  var formData = new FormData();
  formData.append("accion", "cambiar_pasword");
  formData.append("nueva_clave", contrasena);
  formData.append("preguntas_seguridad", preguntas);
  formData.append("cedula", cedula);
  var toastMixin = Swal.mixin({
    showConfirmButton: false,
    width: 450,
    padding: '3.5em',
    timer: 2000,
    timerProgressBar: true,
  });
  $.ajax({
      url: '',
      type: 'POST',
      contentType: false,
      data:formData,
      processData: false,
      cache: false,
      }).done(function (result){
        var res = JSON.parse(result);
        if (res.estatus == 1) {
          toastMixin.fire({
            title: res.title,
            text: res.message,
            icon: res.icon,
          });
        } else {
          toastMixin.fire({
            text: res.message,
            title: res.title,
            icon: res.icon,
          });
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
    success: function(response) {
      var res = JSON.parse(response);
      if (res.estatus == 1) {
        toastMixin.fire({

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
      $("#id").val(res.id);
      $("#telefono").val(res.telefono);
      $("#correo").val(res.correo);
      $("#gestion-modulo").modal("show");
    },
    error: function(err){
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
