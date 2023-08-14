var keyup_cedula = /^[0-9]{7,8}$/;
var keyup_nombre = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{2,30}$/;
var keyup_apellido = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{2,30}$/;
var keyup_genero = /^[A-ZÁÉÍÓÚ][a-zñáéíóú]{7,8}$/;
var keyup_telefono = /^[0-9]{11}$/;
var keyup_correo =/^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]{3,25}[@]{1}[A-Za-z0-9]{3,8}[.]{1}[A-Za-z]{2,4}$/;
var keyup_direccion = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{2,100}$/;
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
    r = validarkeyup(keyup_cedula,this,document.getElementById('scedula'),"* El formato debe ser 99999999.");
  }
  /*--------------FIN VALIDACION PARA CEDULA--------------------*/
  /*--------------VALIDACION PARA NOMBRE--------------------*/
  document.getElementById("primer_nombre").maxLength = 30;
  document.getElementById("primer_nombre").onkeypress = function (e) {
    er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("primer_nombre").onkeyup = function () {
    r = validarkeyup(
      keyup_nombre,
      this,
      document.getElementById("spnombre"),
      "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
  };
  document.getElementById("segundo_nombre").maxLength = 30;
  document.getElementById("segundo_nombre").onkeypress = function (e) {
    er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("segundo_nombre").onkeyup = function () {
    r = validarkeyup(
      keyup_nombre,
      this,
      document.getElementById("ssnombre"),
      "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
  };
  /*--------------FIN VALIDACION PARA NOMBRE--------------------*/

  /*--------------VALIDACION PARA APELLIDO--------------------*/
  document.getElementById("primer_apellido").maxLength = 30;
  document.getElementById("primer_apellido").onkeypress = function (e) {
    er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("primer_apellido").onkeyup = function () {
    r = validarkeyup(
      keyup_apellido,
      this,
      document.getElementById("spapellido"),
      "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
  };
  document.getElementById("segundo_apellido").maxLength = 30;
  document.getElementById("segundo_apellido").onkeypress = function (e) {
    er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("segundo_apellido").onkeyup = function () {
    r = validarkeyup(
      keyup_apellido,
      this,
      document.getElementById("ssapellido"),
      "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
    );
  };
  /*--------------FIN VALIDACION PARA APELLIDO--------------------*/
  document.getElementById("genero").maxLength = 9;
  document.getElementById("genero").onkeypress = function (e) {
    er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("genero").onchange = function () {
    r = validarselect(
      this,
      document.getElementById("sgenero"),
      "* Seleccione un genero"
    );
  };

  /*--------------VALIDACION PARA TELEFONO--------------------*/
  document.getElementById("telefono").maxLength = 11;
  document.getElementById("telefono").onkeypress = function (e) {
    er = /^[JGVEP0-9-]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("telefono").onkeyup = function () {
    r = validarkeyup(
      keyup_telefono,
      this,
      document.getElementById("stelefono"),
      "* Solo numeros de 11  digitos"
    );
  };
  /*--------------FIN VALIDACION PARA TELEFONO--------------------*/

  /*--------------VALIDACION PARA CORREO--------------------*/
  document.getElementById("correo").maxLength = 30;
  document.getElementById("correo").onkeypress = function (e) {
    er = /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC@.-]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("correo").onkeyup = function () {
    r = validarkeyup(
      keyup_correo,
      this,
      document.getElementById("scorreo"),
      "* El formato debe ser ejemplo@gmail.com"
    );
  };
  /*--------------FIN VALIDACION PARA CORREO--------------------*/

  /*--------------VALIDACION PARA DIRECCION--------------------*/
  document.getElementById("direccion").maxLength = 100;
  document.getElementById("direccion").onkeypress = function (e) {
    er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
    validarkeypress(er, e);
  };
  document.getElementById("direccion").onkeyup = function () {
    r = validarkeyup(
      keyup_direccion,
      this,
      document.getElementById("sdireccion"),
      "* El campo debe contener de 2 a 100 letras."
    );
  };
  /*--------------FIN VALIDACION PARA DIRECCION--------------------*/

$("#registrar").click(function (e) { 
  a = valida_registrar1(); 
  if(a!=''){e.preventDefault();}
  else{
  $("#accion").val("registrar");  
  $("#f").submit();
}
});
}


function valida_registrar1() {
  var error = false;
  pnombre = validarkeyup(
    keyup_nombre,
    document.getElementById("primer_nombre"),
    document.getElementById("spnombre"),
    "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
  );
  snombre = validarkeyup(
    keyup_nombre,
    document.getElementById("segundo_nombre"),
    document.getElementById("ssnombre"),
    "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
  );
  papellido = validarkeyup(
    keyup_apellido,
    document.getElementById("primer_apellido"),
    document.getElementById("spapellido"),
    "Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
  );
  sapellido = validarkeyup(
    keyup_apellido,
    document.getElementById("segundo_apellido"),
    document.getElementById("ssapellido"),
    "Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
  );
    if(document.getElementById("genero").value == 0){
      document.getElementById("sgenero").innerHTML ="* Seleccione un genero";
      document.getElementById("sgenero").style.color = "red";
      document.getElementById("genero").classList.add("is-invalid");
    }else{
      document.getElementById("sgenero").innerHTML ="";
      document.getElementById("genero").classList.remove("is-invalid");
      document.getElementById("genero").classList.add("is-valid");
    }
  correo = validarkeyup(
    keyup_correo,
    document.getElementById("correo"),
    document.getElementById("scorreo"),
    "* El formato debe ser ejemplo@gmail.com"
  );
  telefono = validarkeyup(
    keyup_telefono,
    document.getElementById("telefono"),
    document.getElementById("stelefono"),
    "* Solo numeros de 11  digitos"
  );
  direccion = validarkeyup(
    keyup_direccion,
    document.getElementById("direccion"),
    document.getElementById("sdireccion"),
    "* El campo debe contener de 2 a 100 letras."
  );
  if (
    pnombre == 0 ||
    snombre == 0 ||
    papellido == 0 ||
    sapellido == 0 ||
    document.getElementById("genero").value == 0 ||
    correo == 0 ||
    telefono == 0 ||
    direccion == 0 
  ) {
    //variable==0, indica que hubo error en la validacion de la etiqueta
    error = true;
  }
  return error;
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
  function validarselect(etiqueta, etiquetamensaje, mensaje) {
    if(etiqueta.value == 0){
      etiquetamensaje.innerText = mensaje;
      etiquetamensaje.style.color = "red";
      etiqueta.classList.add("is-invalid");
    }else{
      etiquetamensaje.innerText = "";
      etiqueta.classList.remove("is-invalid");
      etiqueta.classList.add("is-valid");
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
        $("#nombre").val(res.primer_nombre);
        $("#primer_nombre").val(res.primer_nombre);
        $("#segundo_nombre").val(res.segundo_nombre);
        $("#primer_apellido").val(res.primer_apellido);
        $("#segundo_apellido").val(res.segundo_apellido);
        $("#genero").val(res.genero);
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
