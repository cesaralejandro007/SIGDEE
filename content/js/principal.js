$(document).ready(function () {
    grafica_estudiante_emprendimiento(); 
});
  
  
  function grafica_estudiante_emprendimiento() {
    var datos = new FormData();
    datos.append("accion", "reporte_estudiante_emprendimiento");
    enviaAjax(datos);
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
                text: 'No hay estudiantes inscritos'
              })   
        }    
        else 
          Swal.fire({
            icon: 'info',
            title: 'Disculpe',
            text: 'No hay emprendimientos registrados'
          })
        
      },
      error: function (err) {
        Toast.fire({
          icon: res.error,
        });
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
        text: 'Estudiantes por diplomados'
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
  