var keyup_cedula = /^[0-9]{7,8}$/;
document.onload = carga();
function carga(){ 

  if($.trim($("#mensajes").text()) != ""){
  muestraMensaje($("#mensajes").html());
}   
  /*--------------VALIDACION PARA CEDULA--------------------*/
  document.getElementById('cedula').maxLength = 8;
  document.getElementById('cedula').onkeypress = function(e){
    er = /^[JGVEP0-9-]*$/; 
    validarkeypress(er,e);  
  };
  document.getElementById('cedula').onkeyup = function(){
    r = validarkeyup(keyup_cedula,this,document.getElementById('scedula'),"* El formato debe ser V-99999999 o J-99999999.");
  }
  /*--------------FIN VALIDACION PARA CEDULA--------------------*/


$("#registrar").on("click",function(){

    $("#accion").val("registrar");  
    $("#f").submit();
  
}); 

}

function next(){
  a = valida_registrar(); 
  if(a!=''){}
    else{
      var datos = new FormData();
      datos.append('accion', 'buscar-usuario');
      datos.append('cedula', $("#cedula").val());
      cargar(datos);
    }
  }

  function previous(){
    $('#information-part').removeClass('active');
    $('#logins-part').addClass('active');
    $('#logins-part-trigger').addClass('active');
    $('#information-part-trigger').removeClass('active');
  } 

  function validarkeypress(er,e){
    key = e.keyCode || e.which;
    tecla = String.fromCharCode(key);
    a = er.test(tecla);
    if(!a){
      e.preventDefault();
    }
  }

  function validarkeyup(er,etiqueta,etiquetamensaje,mensaje){
    a = er.test(etiqueta.value);
    if(!a){
      etiquetamensaje.innerText = mensaje;
      etiquetamensaje.style.color = 'red';
      etiqueta.classList.add('is-invalid');
      return 0;
    }
    else{
      etiquetamensaje.innerText = "";
      etiqueta.classList.remove('is-invalid');
      etiqueta.classList.add('is-valid');
      return 1;   
    }
  }


  function valida_registrar(){ 
    var error = false;
    cedula = validarkeyup(keyup_cedula,document.getElementById('cedula'),document.getElementById('scedula'),"* El formato debe ser V-99999999 o J-99999999.");
    if(cedula==0){
    //variable==0, indica que hubo error en la validacion de la etiqueta 
    error = true;
  }
  return error;
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
      if(response){
        var res = JSON.parse(response);
        $("#id").val(res.id);
        $("#cedula").val(res.cedula);
        $("#nombre").val(res.nombre);
        $("#apellido").val(res.apellido);
        $("#correo").val(res.correo);
        $("#telefono").val(res.telefono);
        $("#direccion").val(res.direccion);
      }

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
