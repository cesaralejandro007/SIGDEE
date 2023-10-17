document.onload = carga();
function carga(){
  document.getElementById("respaldo_parcial").onclick = function () {
    var datos = new FormData();
    datos.append('accion', 'respaldo_parcial');
    enviaAjax(datos);
  };
}

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
                      respaldarBD();
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
        '<span id="vc1" style="font-size:14px"></span><div class="input-group"><input type="text" id="inputclave" placeholder="Ingrese su clave privada" class="form-control"><button class="btn btn-outline-secondary" onclick="copiar_clave_publica();" data-placement="top" title="Usar clave publica" type="button"><i class="fas fa-key"></i></button><button class="btn btn-outline-warning" data-placement="top" title="Usar clave privada" onclick="copiar_clave_privada();" type="button"><i class="fas fa-key"></i></button></div>',
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

  function copiar_clave_privada(){
    let privadakey= document.getElementById("clave_privada").value;
    document.getElementById("inputclave").value = privadakey;
  }

  function copiar_clave_publica(){
    let publickey = document.getElementById("clave_publica").value;
    document.getElementById("inputclave").value = publickey;
  }
  
  function enviaAjax(datos) {
    var toastMixin = Swal.mixin({
      toast: true,
      position: 'top-right',
      showConfirmButton: false,
      timer: 2000,
      timerProgressBar: true
    });
    $.ajax({
      url: '',
      type: 'POST',
      contentType: false,
      data: datos,
      processData: false,
      cache: false,
      success: function(response) {
        alert(response);
        var res = JSON.parse(response);
        if (res.estatus == 1) {
          toastMixin.fire({
            animation: true,
            title: res.title,
            text: res.message,
            icon: res.icon
          });
          
          limpiar();
          setTimeout(function () {
            window.location.reload();
          }, 2000);
        }
        else {
          toastMixin.fire({
            animation: true,
            text: res.message,
            title: res.title,
            icon: res.icon
          });
        }
      },
      error: function(err) {
        
        alert(err);
      }
    });
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

function respaldoBD_semanal(){
  $(function() {
      var toastMixin = Swal.mixin({
        showConfirmButton: false,
        width: 450,
        padding: '3.5em',
        timer: 3000,
        timerProgressBar: true,
      });
      var formData = new FormData();
      formData.append("accion", "respaldo_parcial");
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