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
      consultar_notas();
    });
    
  });
   
  function consultar_notas() {
    var datos = new FormData();
    datos.append("accion", "consulta_aprobados_reprobados");
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
        if (lee.grafica == "consulta_aprobados_reprobados") 
        {
          if(lee.estudiantes != 0){
            var dato = lee.estudiantes;
            var cabezal = '';
            var cuerpo = '';
    
            for (i = 0; i < lee.head.length; i++) {
               cabezal += '<td>' + lee.head[i] + '</td>' 
             }
    
            for (i = 0; i < dato.length; i++) {
              var e = dato[i];
              cuerpo += '<tr>'
                +'<td>' + e.cedula + '</td>'
                +'<td>' + e.nombres + '</td>'
              for (j = 0; j < e.notas.length; j++) {
                cuerpo += '<td>' + e.notas[j] + '</td>' 
              }
              cuerpo += '</tr>'
            }
            $('#head').html(cabezal);
            $('#body').html(cuerpo);
    
          }
          else 
          alert('No existen evaluaciones asignadas para este curso');
        }     
        
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
            var formData = new FormData();
            formData.append("accion", "codificarURL_AE");
              $.ajax({
                url: "",
                type: "POST",
                contentType: false,
                data: formData,
                processData: false,
                cache: false,
                success: function (response) {
                  if(lee.mensaje==vacio){
                    Swal.fire({
                      icon: 'info',
                      title: 'Disculpe',
                      text: 'No existen areas de emprendimiento',
                      footer: '<a href="?pagina='+response+'">Deberia registrar algún area de emprendimiento</a>'
                    })
                  }
                  else
                  $("#area").html(lee.mensaje);
                }
              });
          } else 
          if (lee.resultado == "listadoemprendimientos") {
            var formData = new FormData();
            formData.append("accion", "codificarURL_E");
              $.ajax({
                url: "",
                type: "POST",
                contentType: false,
                data: formData,
                processData: false,
                cache: false,
                success: function (response) {
                  if(lee.mensaje==vacio){
                    Swal.fire({
                      icon: 'info',
                      title: 'Disculpe',
                      text: 'No existen emprendimientos para esta area',
                      footer: '<a href="?pagina='+response+'">Deberia registrar algún emprendimiento</a>'
                    })
                  }
                  else
                  $("#emprendimiento").html(lee.mensaje);
                }
              });
          }  else 
          if (lee.resultado == "listadoaulas") {
            var formData = new FormData();
            formData.append("accion", "codificarURL_A");
              $.ajax({
                url: "",
                type: "POST",
                contentType: false,
                data: formData,
                processData: false,
                cache: false,
                success: function (response) {
                    if(lee.mensaje==vacio){
                      Swal.fire({
                        icon: 'info',
                        title: 'Disculpe',
                        text: 'No existen aulas en el emprendimiento',
                        footer: '<a href="?pagina='+response+'">Deberia registrar algún aula</a>'
                      })
                    }
                    else
                    $("#aula").html(lee.mensaje);
                  }
                });
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
  