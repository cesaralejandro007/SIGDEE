/*-------------------FUNCIONES DE HERRAMIENTAS-------------------*/
function comentar(id) {
  var datos = new FormData();
  datos.append("accion", "comentar");
  datos.append("comentario", $("#comentario-" + id).val());
  datos.append("id_publicacion", id);
  datos.append("cedula_usuario", $("#cedula_usuarioc").val());
  enviaAjaxcomentario(datos);
}

document.getElementById("enviarcomentario1").onclick = function () {
  var datos = new FormData();
  datos.append("id", $("#iddecomentario1").val());
  datos.append("accion", "modificarcomentario");
  datos.append("comentario", $("#resultadocomentario").val());
  enviaAjax(datos);
  limpiar();
};

function cargar_datos1(valor) {
  var datos = new FormData();
  datos.append("accion", "editarcomentario");
  datos.append("id", valor);
  mostrar1(datos);
}

function cargarcomentarios(valor) {
  var datos = new FormData();
  datos.append("accion", "cargarcomentarios");
  datos.append("id", valor);
  cargarcomentariosajax(datos);
}

function eliminarcoment(id) {
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
  }).then(function(result){
    if (result.isConfirmed) {
      setTimeout(function () {
        var datos = new FormData();
        datos.append("accion", "eliminarcomentarios");
        datos.append("id", id);
        enviaAjax(datos);
      }, 10);
    }
  });
}
/*-------------------FIN DE FUNCIONES DE HERRAMIENTAS-------------------*/

/*--------------------FUNCIONES CON AJAX----------------------*/
function enviaAjaxcomentario(datos) {
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
      //alert(res.title);
      if (res.estatus == 1) {
        toastMixin.fire({

          title: res.title,
          text: res.message,
          icon: res.icon,
        });
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
    error: function(err)  {
      Toast.fire({
        icon: res.error,
      });
    },
  });
}

function mostrar1(datos) {
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
      $("#iddecomentario1").val(res.id);
      $("#resultadocomentario").val(res.mensaje);
      $("#enviarcomentario").text("Modificar comentario");
      $("#enviarcomentario1").text("Editar");
      $("#gestion-comentario").modal("show");
      $("#tituloprincipalc").text("Modificar Comentario");
    },
    error: (err) => {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

function cargarcomentariosajax(datos) {
  $.ajax({
    async: true,
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: function (response) {
      var res = JSON.parse(response);

      var toastMixin = Swal.mixin({
        toast: true,
        position: "top-right",
        showConfirmButton: false,
        timer: 1500,
        timerProgressBar: true,
      });
      if (res.estatus == 2) {
        toastMixin.fire({

          text: res.message,
          title: res.title,
          icon: res.icon,
        });
      } else {
        let etiqueta1 = document.querySelector(
          "#resulcoment" + res[0].id_publicacion
        );
        etiqueta1.innerHTML = "";

        for (let item of res) {
          etiqueta1.innerHTML +=
            '<div class="user-block">' +  
            '<img class="img-circle img-bordered-sm" src="content/usuarios/'+item.cedula+'.png" alt="User">' +
            '<span class="username">' +
            '<div class="">' +
            '<div class="d-flex">' +
            '<a href="#">' +
            item.nombre +
            " " +
            item.apellido +
            "</a>" +
            "</div>" +
            '<div class="">' +
            '<span style="font-size:12px;">' +
            item.fecha +
            "</span>" +
            "</div>" +
            "</div>";
          if (item.cedula == document.getElementById("cedula_usuarioc").value) {
            etiqueta1.innerHTML +=
              '<div class="float-right btn-tool">' +
              '<ul class="nav nav-pills ml-auto">' +
              '<li class="nav-item dropdown">' +
              '<a class="nav-link" data-toggle="dropdown" style="cursor: pointer">' +
              '<i class="fas fa-ellipsis-h"></i>' +
              '<span class="caret"></span>' +
              "</a>" +
              '<div class="dropdown-menu">' +
              '<div class="d-flex flex-column">' +
              '<a class="d-flex btn btn-sm" href=" #comentarios" type="button" onclick="cargar_datos1(' +
              item.id +
              ');">Editar</a>' +
              '<a class="d-flex btn btn-sm" href=" #comentarios" type="button" onclick="eliminarcoment(' +
              item.id +
              ');">Eliminar</a>' +
              "</div>" +
              "</div>" +
              "</li>" +
              "</ul>" +
              "</div>";
          }
          etiqueta1.innerHTML +=
            "</span>" +
            "</div><!-- /.user-block -->" +
            "<p>" +
            item.mensaje +
            "</p>" +
            "<hr>";
        }
      }
    },
  });
}
/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
