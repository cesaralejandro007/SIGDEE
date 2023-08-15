$(document).ready(function () {
    //grafica_aprobados_reprobados();
  
    //Funciones para mmostrar la informacion en los selects
  
    muestraAreas();
  
    $("#area").on("change", function () {
      muestraEmpredimientos();
    });
  
    $("#emprendimiento").on("change", function () {
      $("#aula").html('<option value="0" disabled selected>Seleccione</option>');
      muestraAulas();
    });
  
    $("#aula").on("change", function () {
      $("#unidad").html('<option value="0" disabled selected>Seleccione</option>');
      muestraUnidades();
      grafica_aprobados_reprobados_aula();
    });
    
    $("#unidad").on("change", function () {
      $("#evaluacion").html('<option value="0" disabled selected>Seleccione</option>');
      muestraEvaluaciones();
    });
  
    $("#evaluacion").on("change", function () {
      grafica_aprobados_reprobados();
    });
    
  });
  
  
  function grafica_aprobados_reprobados() {
    var datos = new FormData();
    datos.append("accion", "aprobados_reprobados");
    datos.append("unidad", $("#unidad").val());
    datos.append("evaluacion", $("#evaluacion").val());
    datos.append("aula", $("#aula").val());
    enviaAjax(datos);
  }
  
  function grafica_aprobados_reprobados_aula() {
    var datos = new FormData();
    datos.append("accion", "aprobados_reprobados_aula");
    datos.append("aula", $("#aula").val());
    enviaAjax(datos);
  }
  
  
  function muestraAreas() {
    var datos = new FormData();
    datos.append("accion", "listadoareas"); //le digo que me muestre un listado de aulas
    Ajax(datos);
  }
  
  function muestraEmpredimientos() {
    var datos = new FormData();
    datos.append("accion", "listadoemprendimientos");
    datos.append("area", $("#area").val());
    Ajax(datos);
  }
  
  function muestraAulas() {
    var datos = new FormData();
    datos.append("accion", "listadoaulas");
    datos.append("area", $("#area").val());
    datos.append("emprendimiento", $("#emprendimiento").val());
    Ajax(datos);
  }
  
  function muestraUnidades() {
    var datos = new FormData();
    datos.append("accion", "listadounidades");
    datos.append("aula", $("#aula").val());
    Ajax(datos);
  }
  
  function muestraEvaluaciones() {
    var datos = new FormData();
    datos.append("accion", "listadoevaluaciones");
    datos.append("unidad", $("#unidad").val());
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
        if (lee.grafica == "aprobados_reprobados") 
        {
          if(lee.estudiantes){
            grafica_torta(lee.aprobados, lee.reprobados);
          }
          else 
          alert('No han calificado la evaluación');
        }  
        else
        if (lee.grafica == "aprobados_reprobados_aula") 
        {
          if(lee.estudiantes){
            grafica_torta(lee.aprobados, lee.reprobados);
          }
          else 
          alert('No han calificado evaluaciones del aula seleccionado');
        }   
        else 
          alert('No hay evaluaciones');    
        
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
        vacio = '<option disabled selected>Seleccione</option>';
        try {
          //      console.log(respuesta);
          var lee = JSON.parse(respuesta);
          //console.log(lee.resultado);
          if (lee.resultado == "listadoareas") {
            if(lee.mensaje==vacio){
              Swal.fire({
                icon: 'info',
                title: 'Disculpe',
                text: 'No existen areas de emprendimiento',
                footer: '<a href="?pagina=AreaEmprendimiento">Deberia registrar algún area de emprendimiento</a>'
              })
            }
            else
            $("#area").html(lee.mensaje);
          } else 
          if (lee.resultado == "listadoemprendimientos") {
            if(lee.mensaje==vacio){
              Swal.fire({
                icon: 'info',
                title: 'Disculpe',
                text: 'No existen emprendimientos para esta area',
                footer: '<a href="?pagina=Emprendimiento">Deberia registrar algún emprendimiento</a>'
              })
            }
            else
            $("#emprendimiento").html(lee.mensaje);
          }  else 
          if (lee.resultado == "listadoaulas") {
            if(lee.mensaje==vacio){
              Swal.fire({
                icon: 'info',
                title: 'Disculpe',
                text: 'No existen aulas en el emprendimiento',
                footer: '<a href="?pagina=Aula">Deberia registrar algún aula</a>'
              })
            }
            else
            $("#aula").html(lee.mensaje);
          } else 
          if (lee.resultado == "listadounidades") {
            if(lee.mensaje==vacio){
              aula = $("#aula").val();
              Swal.fire({
                icon: 'info',
                title: 'Disculpe',
                text: 'No existen unidades en el aula',
                footer: '<a href="?pagina=Aula&visualizar=true&aula='+aula+'">Deberia registrar alguna unidad en esta aula</a>'
              })
            }
            else
            $("#unidad").html(lee.mensaje);
          } else 
          if (lee.resultado == "listadoevaluaciones") {
            if(lee.mensaje==vacio){
              unidad = $("#unidad").val();
              Swal.fire({
                icon: 'info',
                title: 'Disculpe',
                text: 'No existen evaluaciones en la unidad',
                footer: '<a href="?pagina=Unidad&id_unidad='+unidad+'">Deberia registrar una evaluación en la unidad</a>'
              })
            }
            else
            $("#evaluacion").html(lee.mensaje);
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
  
  function grafica_torta(aprobados, reprobados){
    Highcharts.chart('container', {
      chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
      },
      title: {
        text: 'Reporte Estadistico de Estudiantes aprobados y reprobados'
      },
      tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
      },
      accessibility: {
        point: {
          valueSuffix: '%'
        }
      },
      plotOptions: {
        pie: {
          allowPointSelect: true,
          cursor: 'pointer',
          dataLabels: {
            enabled: true,
            format: '<b>{point.name}</b>: {point.percentage:.1f} %'
          }
        }
      },
      series: [{
        name: 'Estudiantes',
        colorByPoint: true,
        data: [{
          name: 'Aprobados',
          y: aprobados,
          sliced: true,
          selected: true
        }, {
          name: 'Reprobados',
          y: reprobados
        }]
      }]
    });
  }
  