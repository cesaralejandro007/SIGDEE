var keyup_telefono = /^[0-9]{11}$/;
var keyup_correo =/^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]{3,25}[@]{1}[A-Za-z0-9]{3,8}[.]{1}[A-Za-z]{2,4}$/;
var keyup_clave = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{6,20}$/;


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
document.getElementById("floatingPassword").maxLength = 20;
document.getElementById("floatingPassword").onkeypress = function (e) {
  er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
  validarkeypress(er, e);
};
document.getElementById("floatingPassword").onkeyup = function () {
  r = validarkeyup(
    keyup_clave,
    this,
    document.getElementById("sclave"),
    "* El campo debe contener de 6 a 20 caracteres."
  );
};

function cargar_datos(valor) {
  var datos = new FormData();
  datos.append("accion", "editarperfil");
  datos.append("id", valor);
  mostrar(datos);
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

$("#modificarp").click(function () {
  a = valida_registrar();
  if (a != "") {
  } else {
    var datos = new FormData();
    datos.append("accion", "modificarperfil");
    datos.append("id", $("#id").val());
    datos.append("correo", $("#correo").val());
    datos.append("telefono", $("#telefono").val());
    datos.append("clave", $("#floatingPassword").val());
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
  clave = validarkeyup(
    keyup_clave,
    document.getElementById("floatingPassword"),
    document.getElementById("sclave"),
    "* El campo debe contener de 6 a 20 caracteres."
  );
  if (
    correo == 0 ||
    telefono == 0 ||
    clave == 0 
  ) {
    //variable==0, indica que hubo error en la validacion de la etiqueta
    error = true;
  }
  return error;
}

//$(document).ready(function () {

  //CheckBox mostrar contraseña
 /* $("#editarperfil").click(function () {
    $("#gestion-perfil").modal("show");
  });


  $("#recuperarc").click(function () {
    var datos = new FormData();
    datos.append("accion", "modificarperfil");
    datos.append("correo", $("#correor").val());
    datos.append("telefono", $("#telefonor").val());
    enviaAjaxcorreo(datos);
  }); */




//});

function limpiar() {
    $("#correo").val("");
    $("#telefono").val("");
    $("#floatingPassword").val("");
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
