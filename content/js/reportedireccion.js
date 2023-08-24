$(document).ready(function () {
    //grafica_aprobados_reprobados();
  
    //Funciones para mmostrar la informacion en los selects
  
    muestraAreas();
    muestraPaises();
  
    $("#pais").on("change", function () {
      muestraAreas();
      muestraEstados();
    });

    $("#estado").on("change", function () {
      $("#ciudad").html('<option value="0" disabled selected>Seleccione</option>');
      muestraCiudades();
      muestraAreas();
    });

    $("#area").on("change", function () {
      muestraEmpredimientos();
      //grafica_estudiantes_areas();
    });
  
    $("#emprendimiento").on("change", function () {
      $("#aula").html('<option value="0" disabled selected>Seleccione</option>');
      muestraAulas();
    });
  
    $("#aula").on("change", function () {
      $("#unidad").html('<option value="0" disabled selected>Seleccione</option>');
      //muestraUnidades();
      //grafica_aprobados_reprobados_aula();
    });
    
    /*
    $("#unidad").on("change", function () {
      $("#evaluacion").html('<option value="0" disabled selected>Seleccione</option>');
      muestraEvaluaciones();
    });
  
    $("#evaluacion").on("change", function () {
      grafica_aprobados_reprobados();
    });
    */
    
  });
  
  /*
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
  */
 /* function grafica_estudiantes_areas() {
    var datos = new FormData();
    datos.append("accion", "estudiantes_areas");
    datos.append("area", $("#area").val());
    datos.append("pais", $("#pais").val());
    datos.append("estado", $("#estado").val());
    datos.append("ciudad", $("#ciudad").val());
    enviaAjax(datos);
  } */

  function next(){
    var datos = new FormData();
    datos.append('accion', 'buscar_direcciones');
    datos.append("pais", $("#pais").val());
    datos.append("estado", $("#estado").val());
    datos.append("ciudad", $("#ciudad").val());
    cargar(datos);
  }

  function cargar(datos){
    $.ajax({
      async: true,
      url: '',
      type: 'POST',
      contentType: false,
      data: datos,
      processData: false,
      cache: false,
      success:function(response){
        alert(response);
 
        $('#information-part').addClass('active');
        $('#logins-part').removeClass('active');
        $('#logins-part-trigger').removeClass('active');
        $('#information-part-trigger').addClass('active');
  
      },
      error:function(err){
        Toast.fire({
          icon: error.icon
        });
  
      }
    }); 
  }
  
    function previous(){
      $('#information-part').removeClass('active');
      $('#logins-part').addClass('active');
      $('#logins-part-trigger').addClass('active');
      $('#information-part-trigger').removeClass('active');
    } 
  function muestraAreas() {
    var datos = new FormData();
    datos.append("accion", "listadoareas"); //le digo que me muestre un listado de aulas    
    Ajax(datos);
  }

  function muestraPaises() {
    var datos = new FormData();
    datos.append("accion", "listadopaises"); //le digo que me muestre un listado de aulas
    Ajax(datos);
  }
  
  function muestraEmpredimientos() {
    var datos = new FormData();
    datos.append("accion", "listadoemprendimientos");
    datos.append("area", $("#area").val());
    Ajax(datos);
  }

  function muestraEstados() {
    var datos = new FormData();
    datos.append("accion", "listadoestados");
    datos.append("pais", $("#pais").val());
    Ajax(datos);
  }

  function muestraAulas() {
    var datos = new FormData();
    datos.append("accion", "listadoaulas");
    datos.append("area", $("#area").val());
    datos.append("emprendimiento", $("#emprendimiento").val());
    Ajax(datos);
  }

  function muestraCiudades() {
    var datos = new FormData();
    datos.append("accion", "listadociudades");
    datos.append("estado", $("#estado").val());
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
        if (lee.grafica == "estudiantes_areas") 
        {
          if(lee.estudiantes_status){
            grafica_torta(lee.estudiantes);
          }
          else 
          alert('No existe ninguna ubicación registrada');
        }  
        else
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
          if (lee.resultado == "listadopaises") {
            if(lee.mensaje==vacio){
              aula = $("#pais").val();
              Swal.fire({
                icon: 'info',
                title: 'Disculpe',
                text: 'No existen paises registrados'
              })
            }
            else
            $("#pais").html(lee.mensaje);
          } else 
          if (lee.resultado == "listadoestados") {
            if(lee.mensaje==vacio){
              unidad = $("#estado").val();
              Swal.fire({
                icon: 'info',
                title: 'Disculpe',
                text: 'No existen Estados para el pais seleccionado'
              })
            }
            else
            $("#estado").html(lee.mensaje); 
          }else 
          if (lee.resultado == "listadociudades") {
            if(lee.mensaje==vacio){
              unidad = $("#ciudad").val();
              Swal.fire({
                icon: 'info',
                title: 'Disculpe',
                text: 'No existen Ciudades para el Estado seleccionado'
              })
            }
            else
            $("#ciudad").html(lee.mensaje); 
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
  

  