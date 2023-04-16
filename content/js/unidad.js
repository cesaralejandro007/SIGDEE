var keyup_nombre = /^[A-ZÁÉÍÓÚ][a-zñáéíóú0-9\s]{2,30}$/;
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

  /*--------------VALIDACION PARA DESCRIPCION--------------------*/
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
  /*--------------FIN VALIDACION PARA DESCRIPCION--------------------*/

  /*----------------------CRUD DEL MODULO------------------------*/
  document.getElementById("enviar").onclick = function () {
      var datos = new FormData();

      datos.append("accion", "modificar");
      datos.append("id", $("#id").val());
      datos.append("nombre", $("#nombre").val());
      datos.append("descripcion", $("#descripcion").val());
      datos.append("id_aula", $("#aula1").val());
      enviaAjax(datos);
  };

  document.getElementById("guardar-evaluacion").onclick = function () {
    var datos = new FormData();
    datos.append("accion", $("#accion_evaluacion").val());
    datos.append("id_unidad", $("#id_unidad").val());
    datos.append("evaluacion", $("#id_evaluacion").val());
    datos.append("fecha_inicio", $("#fecha_apertura").val());
    datos.append("fecha_cierre", $("#fecha_cierre").val());
    enviaAjax(datos);
  };

  document.getElementById("buscar").onclick = function () {
    $("#gestion_evaluaciones").modal("show");
  };
}

/*document.getElementById("guardar-evaluacion").onclick = function () {
  var datos = new FormData();
  datos.append("accion", "guardar_evaluacion");
  datos.append("id_unidad", $("#id_unidad").val());
  datos.append("evaluacion", $("#guardar-evaluacion").val());
  enviaAjax(datos);
};*/

document.getElementById("guardar-contenidos").onclick = function () {
  var arrayValores = JSON.stringify($("#valores-contenidos").val());
  var datos = new FormData();
  datos.append("accion", "guardar_contenidos");
  datos.append("id_unidad", $("#id_unidad").val());
  datos.append("contenidos", arrayValores);
  enviaAjax(datos);
};

/*--------------------FIN DE CRUD DEL MODULO----------------------*/

/*-------------------FUNCIONES DE HERRAMIENTAS-------------------*/
function seleccion_evaluacion(valor){
  var datos = new FormData();
  datos.append("accion", "buscar_evaluacion"); 
  datos.append("id_evaluacion", valor); 
  mostrar_evaluacion(datos);

}

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
  nombre = validarkeyup(
    keyup_nombre,
    document.getElementById("nombre"),
    document.getElementById("snombre"),
    "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
  );
  descripcion = validarkeyup(
    keyup_descripcion,
    document.getElementById("descripcion"),
    document.getElementById("sdescripcion"),
    "* El campo debe contener de 2 a 100 letras."
  );
  if (nombre == 0 || descripcion == 0) {
    //variable==0, indica que hubo error en la validacion de la etiqueta
    error = true;
  }
  return error;
}


function cargar_datosEvaluacion(valor) {
  var datos = new FormData();
  datos.append("accion", "editarEvaluacion");
  datos.append("id", valor);
  mostrarEvaUni(datos);
}

function contenidos(valor) {
  var datos = new FormData();
  datos.append("accion", "mostrar_contenidos");
  datos.append("id_unidad", valor);
  mostrar_contenidos(datos);
}

function evaluaciones(valor) {
  //$('.val').remove();
  var datos = new FormData();
  datos.append("accion", "mostrar_evaluaciones");
  datos.append("id_unidad", valor);
  mostrar_evaluaciones(datos);
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
  }).then(function (result) {
    if (result.isConfirmed) {
      setTimeout(function () {
        var datos = new FormData();
        datos.append("accion", "eliminar");
        datos.append("id", idnombre);
        confirm_eliminar(datos);
      }, 10);
    }
  });
}
function eliminar_evaluacion(id) {
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
  }).then(function (result) {
    if (result.isConfirmed) {
      setTimeout(function () {
        var datos = new FormData();
        datos.append("accion", "eliminarEvaluacion");
        datos.append("id", id);
        confirm_eliminar(datos);
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
    success: function (response) {
      var res = JSON.parse(response);
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
      } else if (res.estatus == 2) {
        toastMixin.fire({
          animation: true,
          title: res.title,
          text: res.message,
          icon: res.icon,
        });

        setTimeout(function () {
          window.location.reload();
        }, 2000);
      }else if (res.estatus == 3){
        toastMixin.fire({
          animation: true,
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



function confirm_eliminar(datos) {
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
    success: function (response) {
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
      } else if (res.estatus == 2) {
        toastMixin.fire({
          animation: true,
          title: res.title,
          text: res.message,
          icon: res.icon,
        });

        setTimeout(function () {
          window.location.reload();
        }, 2000);
      }else if (res.estatus == 3){
        toastMixin.fire({
          animation: true,
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

function mostrar_contenidos(datos) {
  $.ajax({
    async: true,
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: function (response) {
      document.getElementById("valores-contenidos").innerHTML = response;
      $("#titulo-gestion").text("Agregar contenidos");
      $("#gestion_contenidos").modal("show");
      $("#accion-gestion").val("guardar_contenidos");
      $(".contenidos").bootstrapDualListbox({
        nonSelectedListLabel: "Contenidos existentes",
        selectedListLabel: "Contenidos Seleccionados",
        infoText: "Mostrando {0}",
        infoTextFiltered:
          '<span class="badge badge-warning">Buscar</span> {0} de {1}',
        infoTextEmpty: "Lista Vacia",
      });
    },
    error: function (err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

function mostrar_evaluacion(datos) {
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
      $("#nombre_evaluacion").val(res.nombre);
      $("#accion-gestion").val("guardar_evaluaciones");
      $("#id_evaluacion").val(res.id);
      $("#gestion_evaluaciones").modal("hide");
    },
    error: function (err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

function mostrarEvaUni(datos) {
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
      $("#id_evaluacion").val(res.id);
      $("#nombre_evaluacion").val(res.nombre);
      $("#fecha_apertura").val(res.fechai);
      $("#fecha_cierre").val(res.fechac);
      $("#Evaluacionesactive").click();
      $("#guardar-evaluacion").text("Modificar");
      document.getElementById("accion_evaluacion").value = "modificarevaluacion";
    },
    error: function (err) {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}
/*--------------------FIN DE FUNCIONES CON AJAX----------------------*/
