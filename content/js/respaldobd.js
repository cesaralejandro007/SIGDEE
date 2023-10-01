

document.getElementById("verificar_password"). onclick = function(){
  Swal.fire({
      title: 'Ingrese su contraseña:',
      html:                     
        '<span id="validarcontrasena1"></span>' +
        '<span id="v1" style="font-size:14px"></span><div class="input-group mt-1"><input id="input1" maxlength="15" class="form-control mb-2" type="password" placeholder="Ingrese la contraseña actual"/><div class="input-group-append"><button id="show_password" class="btn border border-left-0 mb-2" type="button" onclick="mostrarPassword()"><i class="fas fa-low-vision" style="font-size:16px; color:#8C8F92"></i></div></div>',
      confirmButtonColor: '#007BFF',
      confirmButtonText: "Continuar",
      focusConfirm: true,
      preConfirm: () => {
          if(document.getElementById('input1').value != ""){
            var formData = new FormData();
            formData.append("accion", "verificar_password");
            formData.append("clave_actual", document.getElementById("input1").value);
            formData.append("cedula", document.getElementById("cedula_usuario").value);
            $.ajax({
              url: '',
              type: 'POST',
              contentType: false,
              data:formData,
              processData: false,
              cache: false,
              }).done(function (result) {
                var res = JSON.parse(result);
                  if(res.estatus==1){
                      verificarClave();
                      return true;
                  }else if(res.estatus==2){
                      document.getElementById("validarcontrasena1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">Usted no posee permisos para realizar el respaldo de la BD.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
                      setTimeout(function () {
                          $("#cerraralert").click();
                        }, 3000);
                      return false;
                  }else if(res.estatus == 0){
                    document.getElementById("validarcontrasena1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">La contraseña no coincide.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
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

  function mostrarPassword() {
    var cambio = document.getElementById("input1");
    if (cambio.type == "password") {
      cambio.type = "text";
    } else {
      cambio.type = "password";
    }
  }


  function verificarClave(){
    Swal.fire({
      title: 'Ingrese su clave privada:',
      html:                     
        '<span id="validarclave1"></span>' +
        '<span id="vc1" style="font-size:14px"></span><input id="inputclave" class="form-control mb-2" placeholder="Ingrese su clave privada">',
      confirmButtonColor: '#007BFF',
      confirmButtonText: "Continuar",
      focusConfirm: true,
      preConfirm: () => {
          if(document.getElementById('inputclave').value != ""){
            var formData = new FormData();
            formData.append("accion", "verificar_clave_privada");
            formData.append("clave_privada", document.getElementById("inputclave").value);
            formData.append("clave_publica", document.getElementById("clave_publica").value);
            $.ajax({
              url: '',
              type: 'POST',
              contentType: false,
              data:formData,
              processData: false,
              cache: false,
              }).done(function (result) {
                var res = JSON.parse(result);
                  if(res.estatus==1){
                    respaldarBD();
                      return true;
                  }else if(res.estatus == 0){
                    document.getElementById("validarclave1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">La clave privada no coincide.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
                    setTimeout(function () {
                        $("#cerraralert").click();
                      }, 3000);
                    return false;
                  }else{
                      document.getElementById("validarclave1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">Error del RSA.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
                      setTimeout(function () {
                          $("#cerraralert").click();
                        }, 3000);
                      return false;
                  }
              });
              return false;
        }else{
          document.getElementById("validarclave1").innerHTML = '<div class="alert alert-dismissible fade show pl-5" style="background:#9D2323; color:white" role="alert">Complete los campos solicitados.<i class="far fa-backspace p-0 m-0 d-none" id="cerraralert" data-dismiss="alert" aria-label="Close"></i></div>';
          setTimeout(function () {
              $("#cerraralert").click();
            }, 3000);
          return false;
        }
      }
    })
  }

function respaldarBD(){
$(function() {
    var toastMixin = Swal.mixin({
      showConfirmButton: false,
      width: 450,
      padding: '3.5em',
      timer: 3000,
      timerProgressBar: true,
    });
    var formData = new FormData();
    formData.append("accion", "respaldarbd");
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: formData,
    processData: false,
    cache: false
  }).done(function(datos) {
      var blob = new Blob([datos]);
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = "respaldo.sql";
      link.click();
      toastMixin.fire({
        title: "Respaldo BD",
        text: "La Base de datos fue respaldado con exito",
        icon: "success",
      });
});
});
}