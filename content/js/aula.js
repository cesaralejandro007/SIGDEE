var keyup_aula = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]{3,100}$/;
var keyup_docente = /^[A-ZÁÉÍÓÚa-zñáéíó1-9,.#%$^&*:\s]{1,100}$/;
var keyup_select = /^[0-9]{1,10}$/;

$(document).ready(function() {    
  var table = $('#funcionpaginacion').DataTable({      
      language: {
              "lengthMenu": "<div class='d-flex m-1'><div><p class='p-1' style='font-size:14px'>Mostrar</p></div> <div>_MENU_</div> <div><p class='p-1' style='font-size:14px'>registros</p></div></div>",
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
      text:      '<i class="fas fa-file-excel text-success"></i> ',
      titleAttr: 'Exportar a Excel',
      className: 'btn border border-success bg-white mr-1',
      exportOptions: {
        columns: [1,2,3,4,5]
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
      text:      '<i class="fas fa-file-pdf text-danger "></i> ',
      titleAttr: 'Exportar a PDF',
      className: 'btn border border-danger bg-white mr-1',
      customize: function ( doc ) {
        doc.pageMargins = [30, 60, 30,20 ];
        var cols = [];
        cols[0] = {        
        margin: [ 10, 0, 0, 2 ],
        alignment: 'start',
        image: 'data:image/png;base64,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',
        width: 575,
        height: 50};
        cols[1] = {text: ""};
        var objFooter = {};
        objFooter['columns'] = cols;
        doc['header']=objFooter;
        // Splice the image in after the header, but before the table
        },
      exportOptions: {
        columns: [1,2,3,4,5]
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
      text:      '<i class="fa fa-print text-info"></i> ',
      titleAttr: 'Imprimir',
      className: 'btn border border-info bg-white mr-1',
      exportOptions: {
        columns: [1,2,3,4,5]
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
    title: "¿Está seguro de eliminar el registro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCloseButton: true,
    showCancelButton: true,
    confirmButtonColor: "#0C72C4",
    cancelButtonColor: "#9D2323",
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
  recibe_ajaxcheck(datos);
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
        }, 2500);
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

function recibe_ajaxcheck(datos) {
	var toastMixin = Swal.mixin({
		toast: true,
		position: 'top-right',
		showConfirmButton: false, 
		timer: 2000,
		timerProgressBar: true
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
        }, 2500);
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
