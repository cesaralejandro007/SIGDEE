$(document).ready(function () {
  //grafica_aprobados_reprobados();

  //Funciones para mmostrar la informacion en los selects

  muestraAreas();

  $("#area").on("change", function () {
    //muestraEmpredimientos();
    grafica_estudiante_emprendimiento();
  });

  
});


function grafica_estudiante_emprendimiento() {
  var datos = new FormData();
  datos.append("accion", "reporte_estudiante_emprendimiento");
  datos.append("area", $("#area").val());
  enviaAjax(datos);
}



function muestraAreas() {
  var datos = new FormData();
  datos.append("accion", "listadoareas"); //le digo que me muestre un listado de aulas
  Ajax(datos);
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
    success: function (response) {
      var lee = JSON.parse(response);
      if (lee.resultado > 0) 
      {
        if(lee.estudiantes>0){
          grafica_torta(lee.datos);
        }
        else
          Swal.fire({
              icon: 'info',
              title: 'Disculpe',
              text: 'No hay estudiantes en esta area de emprendimiento'
            })   
      }    
      else 
        Swal.fire({
          icon: 'info',
          title: 'Disculpe',
          text: 'No hay emprendimientos en el area'
        })
      
    },
    error: function (err) {
      Toast.fire({
        icon: res.error,
      });
    },
  });
}

function Ajax(datos) {
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

      try {
        //      console.log(respuesta);
        var lee = JSON.parse(respuesta);
        //console.log(lee.resultado);
        if (lee.resultado == "listadoareas") {
          //console.log(lee.mensaje);
          $("#area").html(lee.mensaje);
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

function grafica_torta(datos){
  Highcharts.chart('container', {
    chart: {
      plotBackgroundColor: null,
      plotBorderWidth: null,
      plotShadow: false,
      type: 'pie'
    },
    title: {
      text: 'Reporte Estadistico de Estudiantes por Emprendimientos'
    },
    tooltip: {
      pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
      point: {
        valueSuffix: '%'
      }
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }],
        },
    },
    series: [{
      name: 'Estudiantes',
      colorByPoint: true,
      data: datos
    }]
  });
}
