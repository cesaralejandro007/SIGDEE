var keyup_aula = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]{3,100}$/;
var keyup_docente = /^[A-ZÁÉÍÓÚa-zñáéíó1-9,.#%$^&*:\s]{1,100}$/;
var keyup_select = /^[0-9]{1,10}$/;

$(document).ready(function() {    
  var table = $('#funcionpaginacion').DataTable({      
      language: {
              "lengthMenu": "Mostrar _MENU_ registros",
              "zeroRecords": "No se encontraron resultados",
              "info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
              "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
              "infoFiltered": "(filtrado de un total de _MAX_ registros)",
              "sSearch": "Buscar:",
              "oPaginate": {
                  "sFirst": "Primero",
                  "sLast":"Último",
                  "sNext":"Siguiente",
                  "sPrevious": "Anterior"
         },
         "sProcessing":"Procesando...",
          },
      //para usar los botones   
      dom: "B<'row'<'col-sm-6'><'col-sm-6'f>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-5'il><'col-sm-7'p>>",
      colReorder: true,
      lengthMenu: [5, 10, 20, 30, 40, 50, 100], 
      buttons:[ 
    {
      extend:    'excelHtml5',
      filename: function() {
        return "EXCEL-Aula"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Aula"
      },
      text:      '<i class="fas fa-file-excel"></i> ',
      titleAttr: 'Exportar a Excel',
      className: 'btn btn-success',
      exportOptions: {
        columns: [1,3,5,7,9]
    }
    },
    {
      extend:    'pdfHtml5',
      filename: function() {
        return "PDF-Aula"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Aula"
      },
      text:      '<i class="fas fa-file-pdf"></i> ',
      titleAttr: 'Exportar a PDF',
      className: 'btn btn-danger',
      exportOptions: {
        columns: [1,3,5,7,9]
    }
  },
    {
      extend:    'print',
      filename: function() {
        return "Print-Aula"      
      },          
      title: function() {
        var searchString = table.search();        
        return searchString.length? "Search: " + searchString : "Reporte de Aula"
      },
      text:      '<i class="fa fa-print"></i> ',
      titleAttr: 'Imprimir',
      className: 'btn btn-info',
      exportOptions: {
        columns: [1,3,5,7,9]
    }
    },    
  ]  
  });     
});

$(document).ready(function () {
  $("#aulas").addClass("active");
  $("#aulas").addClass("show");
  $("#gestion-aula").removeClass("active");
  $("#modificar").removeClass("active");
  $("#lista").addClass("active");
  $("#estudiantes").bootstrapDualListbox({
    nonSelectedListLabel: "Aspirantes existentes",
    selectedListLabel: "Aspirantes Seleccionados",
    infoText: "Mostrando {0}",
    infoTextFiltered:
      '<span class="badge badge-warning">Buscar</span> {0} de {1}',
    infoTextEmpty: "Lista Vacia",
  });

  /*--------------VALIDACION PARA NOMBRE--------------------*/
  document.getElementById("area").onkeyup = function () {
    r = validarkeyup(
      keyup_area,
      this,
      document.getElementById("sarea"),
      "* Seleccione un area de emprendimiento."
    );
  };
  /*--------------FIN VALIDACION PARA NOMBRE--------------------*/

  /**
1- mostrar aulas con funcion muestra aulas
2- mostrar areas con funcion muestra areas
3- mostrar docentes con funcion muestra docentes
4- asociar evento a area de manera que si cambia
	cambie el emprendimiento asociado a esa area	
5- asociar evento a empredimiento de manera que cuando cambie
	muestre los modulos asociandos a ese emprendimiento, tambien
	debe mostrar los aspirantes a ese empredimiento
	**/

  //1
  muestraAulas();
  //2
  muestraAreas();
  //3
  muestraDocentes();

  //4
  $("#area").on("change", function () {
    $("#tipo").html('<option value="0" disabled selected>Seleccione</option>');
    $("#modulo").html('<option value="0" disabled selected>Seleccione</option>');
    $("#estudiantes").html("");
    muestraEmpredimientos();
  });

  //5
  $("#tipo").on("change", function () {
    $("#estudiantes").html("");
    $("#modulo").html('<option value="0" disabled selected>Seleccione</option>');
    muestraModulos();
    muestraAspirantes();
  });

  document.getElementById("enviar").onclick = function () {
    a = valida_registrar($("#accion").val());
    if (a != "") {
    }
    else{
        var arrayEstudiantes_new = JSON.stringify($("#estudiantes").val());
        var datos = new FormData();
        datos.append("accion", $("#accion").val());
        datos.append("id", $("#id").val());
        datos.append("nombre", $("#nombre").val());
        datos.append("id_tipo", $("#tipo").val());
        datos.append("id_modulo", $("#modulo").val());
        datos.append("docente", $("#docente1").val());
        datos.append("id_aula_docente", $("#id_aula_docente").val());
        datos.append("estudiantes", arrayEstudiantes_new);

        recibe_ajax(datos);
    } 
  };

  document.getElementById("nuevo").onclick = function () {
    muestraAspirantes();
    muestraAreas();
    muestraDocentes();
    muestraModulos();
    muestraEmpredimientos();
    document.getElementById("selectores").style.display = "";
  };
});

function edita_aula(id_aula, id_docente) {
  muestraDocentes_aula(id_aula, id_docente);
  muestraAspirantes_aula(id_aula);
}

function muestraAspirantes() {
  //cuando cambie el empredimiento se hace lo mismo
  //pero en este caso se le anexa el formdata
  //el id del area para filtrar los emprendimientos
  var datos = new FormData();
  //a ese datos le añadimos la informacion a enviar
  datos.append("accion", "listadoaspirantes");
  datos.append("emprendimiento", $("#tipo").val());
  //ahora se envia el formdata por ajax
  enviaAjax(datos);
}
function muestraModulos() {
  //cuando cambie el empredimiento se hace lo mismo
  //pero en este caso se le anexa el formdata
  //el id del area para filtrar los emprendimientos
  var datos = new FormData();
  //a ese datos le añadimos la informacion a enviar
  datos.append("accion", "listadomodulos");
  datos.append("emprendimiento", $("#tipo").val());
  //ahora se envia el formdata por ajax
  enviaAjax(datos);
}
function muestraEmpredimientos() {
  //cuando cambie el area se hace lo mismo
  //pero en este caso se le anexa el formdata
  //el id del area para filtrar los emprendimientos
  var datos = new FormData();
  //a ese datos le añadimos la informacion a enviar
  datos.append("accion", "listadoemprendimientos");
  datos.append("area", $("#area").val());
  //ahora se envia el formdata por ajax
  enviaAjax(datos);
}
function muestraAulas() {
  var datos = new FormData();
  //a ese datos le añadimos la informacion a enviar
  datos.append("accion", "listadoaulas"); //le digo que me muestre un listado de aulas
  //ahora se envia el formdata por ajax
  enviaAjax(datos);
}
function muestraAreas() {
  var datos = new FormData();
  //a ese datos le añadimos la informacion a enviar
  datos.append("accion", "listadoareas"); //le digo que me muestre un listado de aulas
  //ahora se envia el formdata por ajax
  enviaAjax(datos);
}
function muestraDocentes() {
  var datos = new FormData();
  //a ese datos le añadimos la informacion a enviar
  datos.append("accion", "listadodocentes"); //le digo que me muestre un listado de aulas
  //ahora se envia el formdata por ajax
  enviaAjax(datos);
}

/*------FUNCIONES PARA EDITAR EL AULA------*/
function muestraDocentes_aula(id_aula, id_docente) {
  var datos = new FormData();
  //a ese datos le añadimos la informacion a enviar
  datos.append("accion", "editarlistadodocentes"); //le digo que me muestre un listado de aulas
  datos.append("id_aula", id_aula); //le digo que me muestre un listado de aulas
  datos.append("id_docente", id_docente); //le digo que me busque el aula que imparte ese docente
  //ahora se envia el formdata por ajax
  enviaAjax(datos);
}

/*------FUNCIONES PARA EDITAR EL AULA------*/

function elimina_aula(id) {
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
        datos.append("id", id);
        recibe_ajax(datos);
      }, 10);
    }
  });
}


function activarod(id) {
  if ($("#desh" + id).prop("checked")) {
    $("#labelad" + id).html("Activado");
  } else {
    $("#labelad" + id).html("Desactivado");
  }
  var datos = new FormData();
  datos.append("accion", "act_des");
  datos.append("id_aula", id);
  datos.append("status", $("#desh" + id).prop("checked"));
  recibe_ajax(datos);
}

(function () {
  var datos = new FormData();
  datos.append("accion", "cargarcheckem");
  cargaraulas(datos);
})();



function muestraAspirantes_aula(id_aula) {
  //cuando cambie el empredimiento se hace lo mismo
  //pero en este caso se le anexa el formdata
  //el id del area para filtrar los emprendimientos
  var datos = new FormData();
  //a ese datos le añadimos la informacion a enviar
  datos.append("accion", "editarlistadoaspirantes");
  datos.append("id_aula", id_aula);
  //ahora se envia el formdata por ajax
  enviaAjax(datos);
}
/*------FIN DE FUNCIONES PARA EDITAR EL AULA------*/

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

function valida_registrar(accion) {
  if(accion!="modificar"){
  var error = false;
  docente = validarkeyup(
    keyup_select,
    document.getElementById("docente1"),
    document.getElementById("sdocente1"),
    "* Información requerida."
  );
   area = validarkeyup(
    keyup_select,
    document.getElementById("area"),
    document.getElementById("sarea"),
    "* Información requerida."
  );
  emprendimiento = validarkeyup(
    keyup_select,
    document.getElementById("tipo"),
    document.getElementById("semprendimiento"),
    "* Información requerida."
  );
  modulo = validarkeyup(
    keyup_select,
    document.getElementById("modulo"),
    document.getElementById("smodulo"),
    "* Información requerida."
  );


  if (area == 0 || docente == 0 || emprendimiento == 0 || modulo == 0 ) {
    error = true;
  }
  return error;
}else{
  var error = false;
  docente = validarkeyup(
    keyup_select,
    document.getElementById("docente1"),
    document.getElementById("sdocente1"),
    "* Información requerida."
  );

  if (docente == 0 ) {
    error = true;
  }
  return error;
}
}

function enviaAjax(datos) {
  $.ajax({
    async: true,
    url: "", //la pagina a donde se envia por estar en mvc, se omite la ruta ya que siempre estaremos en la misma pagina
    type: "POST", //tipo de envio
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    beforeSend: function () {
      //pasa antes de enviar pueden colocar un loader
      //$('.loader').show();
    },
    timeout: 10000,
    success: function (respuesta) {
      //si resulto exitosa la transmision
      vacio = '<option disabled selected>Seleccione</option>';
      area = $("#area").val();
      emprendimiento = $("#tipo").val();
      docente = $("#docente1").val();
      try {
        //			console.log(respuesta);
        var lee = JSON.parse(respuesta);
        //console.log(lee.resultado);
        if (lee.resultado == "listadoaulas") {
          $("#listaaulas").html(lee.mensaje);
        } else if (lee.resultado == "listadoareas") {
          if(lee.mensaje==vacio){
            Swal.fire({
              icon: 'info',
              title: 'Disculpe',
              text: 'No existen areas de emprendimiento',
              footer: '<a href="?pagina=AreaEmprendimiento">Deberia registrar alguna area de emprendimiento</a>'
            })
          }
          else
          $("#area").html(lee.mensaje);
        } else if (lee.resultado == "listadoemprendimientos" && area!=null) {
          if(lee.mensaje==vacio){
            Swal.fire({
              icon: 'info',
              title: 'Disculpe',
              text: 'No existen emprendimientos para esta área',
              footer: '<a href="?pagina=Emprendimiento">Deberia registrar algún emprendimiento para esta area</a>'
            })
          }
          else
          $("#tipo").html(lee.mensaje);
        } else if (lee.resultado == "listadomodulos" && emprendimiento!=null) {
          if(lee.mensaje==vacio){
            Swal.fire({
              icon: 'info',
              title: 'Disculpe',
              text: 'No existen modulos para este emprendimiento',
              footer: '<a href="?pagina=Modulo">Deberia asignarle modulos al emprendimiento</a>'
            })
          }
          else
          $("#modulo").html(lee.mensaje);
        } else if (lee.resultado == "listadodocentes") {
          if(lee.mensaje==vacio){
            Swal.fire({
              icon: 'info',
              title: 'Disculpe',
              text: 'No existen docentes',
              footer: '<a href="?pagina=Docente">Deberia registrar docentes</a>'
            })
          }
          else
          $("#docente1").html(lee.mensaje);
        } else if (lee.resultado == "listadodocentes_aula") {
          console.log(lee.mensaje);
          $("#docente1").html(lee.mensaje);
          $("#enviar").text("Modificar");
          $("#id").val(lee.aula);
          //$("#id_aula_docente").val(lee.docente_aula);
          $("#nombre").val(lee.nombre_aula);
          document.getElementById("selectores").style.display = "none";
          $("#accion").val("modificar");
          document.getElementById("accion").innerText = "modificar";
          $("#aulas").removeClass("active");
          $("#aulas").removeClass("show");
          $("#gestion-aula").addClass("active");
          $("#modificar").addClass("active");
          $("#lista").removeClass("active");
        } else if (lee.resultado == "listadoaspirantes") {
          $("#estudiantes").html(lee.mensaje);
          $("#estudiantes").bootstrapDualListbox("refresh", true);
        } else if (lee.resultado == "listadoaspirantes_aula") {
          $("#estudiantes").html(lee.mensaje);
          $("#estudiantes").bootstrapDualListbox("refresh", true);
        } else if (lee.resultado == "error") {
          alert(lee.mensaje);
        }
      } catch (e) {
        alert("Error en JSON " + e.name + " !!!");
      }
      //cuanto termina el proceso ocultan el loader
      $(".loader").hide();
    },
    error: function (request, status, err) {
      $(".loader").hide();
      $("#mostrarmodal").modal("hide");
      if (status == "timeout") {
        //pasa cuando superan los 10000 10 segundos de timeout
        //muestraMensaje("Servidor ocupado, intente de nuevo");
      } else {
        //cuando ocurreo otro error con ajax
        //muestraMensaje("ERROR: <br/>" + request + status + err);
      }
    },
    complete: function () {
      //si no se recibio ninguna que se entienda del servidor
      //se oculta igual el loader
      //$('.loader').hide();
    },
  });
}

function recibe_ajax(datos) {
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
      }else if (res.estatus =="check") {
        toastMixin.fire({
          animation: true,
          title: res.title,
          text: res.message,
          icon: res.icon,
        });
      } else {
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

function mostrar(datos) {
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
      $("#id").val(res.id);
      $("#nombre").val(res.aula);
      $("#docente option[value=" + res.id_docente + "]").attr("selected", true);

      //$("#cedula").val(res.cedula);
      $("#enviar").text("Modificar");
      document.getElementById("selectores").style.display = "none";
      $("#accion").val("modificar");
      document.getElementById("accion").innerText = "modificar";
      $("#aulas").removeClass("active");
      $("#aulas").removeClass("show");
      $("#gestion-aula").addClass("active");
      $("#modificar").addClass("active");
      $("#lista").removeClass("active");
    },
    error: (err) => {
      Toast.fire({
        icon: error.icon,
      });
    },
  });
}

function cargaraulas(datos) {
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: (response) => {
      var res = JSON.parse(response);
      for (let propiedad in res) {
        if (res != undefined) {
          if (res[propiedad]["estatus"] != "false") {
            $("#labelad" + res[propiedad]["id"]).html("Activado");
            $("#desh" + res[propiedad]["id"]).prop("checked", true);
          } else {
            $("#labelad" + res[propiedad]["id"]).html("Desactivado");
            $("#desh" + res[propiedad]["id"]).prop("checked", false);
          }
        } else {
          $("#desh" + res[propiedad]["id"]).prop("checked", false);
        }
      }
    },
  });
}
