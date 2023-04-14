   var keyup_cedula = /^[JGVEP]{1}[-]{1}[0-9]{7,9}$/;
   var keyup_nombre = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{2,30}$/;
   var keyup_apellido = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{2,30}$/;
   var keyup_telefono = /^[0-9]{11}$/;
   var keyup_correo =  /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]{3,25}[@]{1}[A-Za-z0-9]{3,8}[.]{1}[A-Za-z]{2,4}$/;
   var keyup_direccion = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{2,100}$/;


   $(document).ready(function() {

      $("#error1").hide();
      $("#error2").hide();
      $("#error3").hide();
      $("#error4").hide();
      $("#error5").hide();
      $("#error6").hide();
      $("#error7").hide();
      $("#error8").hide();
      $("#error9").hide();


      var error_nombre = false;
      var error_apellido = false;
      var error_edad = false;
      var error_sexo = false;
      var error_fecha = false;
      var error_lugar = false;
      var error_direccion = false;
      var error_estado= false;		
      var error_emergencia = false;

      $("#segundonombre").focusout(function(){
         chequeo_nombre();
      });
      $("#segundoapellido").focusout(function(){
         chequeo_apellido();
      });
      $("#edad").focusout(function() {
         chequeo_edad();
      });
      $("#sexo").focusout(function() {
         chequeo_sexo();
      });
      $("#fecha").focusout(function() {
         chequeo_fecha();
      });
      $("#lugar").focusout(function() {
         chequeo_lugar();
      });
      $("#direccion").focusout(function() {
         chequeo_direccion();
      });
      $("#estado").focusout(function() {
         chequeo_estado();
      });
      $("#emergencia").focusout(function() {
         chequeo_emergencia();   

      });

      function chequeo_nombre() {
         var chequeo = /^[a-zA-Z ]*$/;
         var nombre = $("#segundonombre").val();
         if (chequeo.test(nombre) && nombre !== '') {
            $("#error1").hide();
            $("#segundonombre").css("border-bottom","2px solid #008f39");
         } else {
            $("#error1").html("Solo Caracteres");
            $("#error1").show();
            $("#segundonombre").css("border-bottom","2px solid #F90A0A");
            error_nombre = true;
         }
      }

      function chequeo_apellido() {
         var chequeo = /^[a-zA-Z ]*$/;
         var apellido = $("#segundoapellido").val();
         if (chequeo.test(apellido) && apellido !== '') {
            $("#error2").hide();
            $("#segundoapellido").css("border-bottom","2px solid #008f39");
         } else {
            $("#error2").html("Solo Caracteres");
            $("#error2").show();
            $("#segundoapellido").css("border-bottom","2px solid #F90A0A");
            error_apellido = true;
         }
      }

      function chequeo_edad() {
         var edad_length = $("#edad").val().length;
         if (edad_length < 1) {
            $("#error3").html(" Solo Números");
            $("#error3").show();
            $("#edad").css("border-bottom","2px solid #F90A0A");
            error_edad = true;
         } else {
            $("#error3").hide();
            $("#edad").css("border-bottom","2px solid #008f39");
         }
      }

      function chequeo_sexo() { 
         var chequeo = /^.{4,10}$/ ;
         var sexo = $("#sexo").val();
         if (chequeo.test(sexo) && sexo !== '') {
            $("#error4").hide();
            $("#sexo").css("border-bottom","2px solid #008f39");
         } else {
            $("#error4").html("Fecha incorrecta");
            $("#error4").show();
            $("#sexo").css("border-bottom","2px solid #F90A0A");
            error_sexo = true;
         }
      }

      function chequeo_fecha() { 
         var chequeo = /^.{4,10}$/ ;
         var fecha = $("#fecha").val();
         if (chequeo.test(fecha) && fecha !== '') {
            $("#error5").hide();
            $("#fecha").css("border-bottom","2px solid #008f39");
         } else {
            $("#error5").html("Fecha incorrecta");
            $("#error5").show();
            $("#fecha").css("border-bottom","2px solid #F90A0A");
            error_fecha = true;
         }
      }

      function chequeo_lugar() {
         var chequeo = /^[a-zA-Z ]*$/ ;
         var lugar = $("#lugar").val();
         if (chequeo.test(lugar) && lugar !== '') {
            $("#error6").hide();
            $("#lugar").css("border-bottom","2px solid #008f39");
         } else {
            $("#error6").html("Solo Caracteres");
            $("#error6").show();
            $("#lugar").css("border-bottom","2px solid #F90A0A");
            error_lugar = true;
         }
      }


      function chequeo_direccion() {
         var chequeo = /^[a-zA-Z ]*$/ ;
         var direccion = $("#direccion").val();
         if (chequeo.test(direccion) && direccion !== '') {
            $("#error7").hide();
            $("#direccion").css("border-bottom","2px solid #008f39");
         } else {
            $("#error7").html("Solo Caracteres");
            $("#error7").show();
            $("#direccion").css("border-bottom","2px solid #F90A0A");
            error_direccion = true;
         }
      }

      function chequeo_estado() {
         var chequeo = /^[a-zA-Z ]*$/;
         var estado = $("#estado").val();
         if (chequeo.test(estado) && estado !== '') {
            $("#error8").hide();
            $("#estado").css("border-bottom","2px solid #008f39");
         } else {
            $("#error8").html("Solo Caracteres");
            $("#error8").show();
            $("#estado").css("border-bottom","2px solid #F90A0A");
            error_estado = true;
         }
      }


      function chequeo_emergencia() {
         var emergencia_length = $("#emergencia").val().length;
         if (emergencia_length < 11) {
            $("#error9").html("Solo Números");
            $("#error9").show();
            $("#emergencia").css("border-bottom","2px solid #F90A0A");
            error_emergencia = true;
         } else {
            $("#error9").hide();
            $("#emergencia").css("border-bottom","2px solid #008f39");
         }
      }


      $("#enviar").on("click", function() {
         error_nombre = false;
         error_apellido = false;
         error_edad = false;
         error_sexo = false;
         error_fecha = false;
         error_lugar = false;
         error_direccion = false;
         error_estado = false;
         error_emergencia = false;

         chequeo_nombre();
         chequeo_apellido();
         chequeo_edad();
         chequeo_sexo();
         chequeo_fecha();
         chequeo_lugar();
         chequeo_direccion();
         chequeo_estado();
         chequeo_emergencia();


         if (error_nombre === false && error_apellido === false && error_edad === false 
          && error_sexo === false && error_fecha === false && error_lugar === false && error_direccion === false
          && error_estado === false && error_emergencia === false) {
          Swal.fire({
            title: '<strong><i>Has Registrado existosamente</i></strong>',
            icon: 'success',
            html: '<a href="?url=mostrarpaciente" class="btn"> Ver Registro</a>',
            showConfirmButton: false,
            timer: 15000
         })
       return true;
    } else {
     Swal.fire({
       position: 'top-end',
       icon: 'error',
       title: 'Ingrese los Datos correctamente',
       showConfirmButton: false,
       timer: 1500
    })
     return false;
   }

   });

   })


   /*--------------VALIDACION DE CAMPOS--------------------*/
   document.onload = carga();
   function carga() {
        /*--------------VALIDACION PARA CEDULA--------------------*/
       document.getElementById("cedula").maxLength = 10;
       document.getElementById("cedula").onkeypress = function (e) {
        er = /^[JGVEP0-9-]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("cedula").onkeyup = function () {
        r = validarkeyup(
         keyup_cedula,
         this,
         document.getElementById("scedula"),
         "* El formato debe ser V-99999999 o J-99999999."
         );
      };
        /*--------------FIN VALIDACION PARA CEDULA--------------------*/

        /*--------------VALIDACION PARA NOMBRE--------------------*/
      document.getElementById("nombre").maxLength = 30;
      document.getElementById("nombre").onkeypress = function (e) {
        er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
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

        /*--------------VALIDACION PARA APELLIDO--------------------*/
      document.getElementById("apellido").maxLength = 30;
      document.getElementById("apellido").onkeypress = function (e) {
        er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("apellido").onkeyup = function () {
        r = validarkeyup(
         keyup_apellido,
         this,
         document.getElementById("sapellido"),
         "* Solo letras de 3 a 30 caracteres, siendo la primera en mayúscula."
         );
      };
        /*--------------FIN VALIDACION PARA APELLIDO--------------------*/

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
   }


   /*-------------------FUNCIONES DE HERRAMIENTAS-------------------*/
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
      } else {
        etiquetamensaje.innerText = "";
        etiqueta.classList.remove("is-invalid");
        etiqueta.classList.add("is-valid");
        return 1;
      }
   }

   function limpiar() {
       $("#cedula").val("");
       $("#nombre").val("");
       $("#apellido").val("");
       $("#correo").val("");
       $("#telefono").val("");
       $("#direccion").val("");
       document.getElementById("scedula").innerText = "";
       document.getElementById("snombre").innerText = "";
       document.getElementById("sapellido").innerText = "";
       document.getElementById("scorreo").innerText = "";
       document.getElementById("stelefono").innerText = "";
       document.getElementById("sdireccion").innerText = "";
       document.getElementById("cedula").classList.remove("is-invalid", "is-valid");
       document.getElementById("nombre").classList.remove("is-invalid", "is-valid");
       document
       .getElementById("apellido")
       .classList.remove("is-invalid", "is-valid");
       document.getElementById("correo").classList.remove("is-invalid", "is-valid");
       document
       .getElementById("telefono")
       .classList.remove("is-invalid", "is-valid");
       document
       .getElementById("direccion")
       .classList.remove("is-invalid", "is-valid");
   }

