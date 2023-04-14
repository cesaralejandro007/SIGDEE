   var keyup_nombre = /^[A-ZÁÉÍÓÚ][a-zñáéíóú\s]{6,45}$/;
   var keyup_numero = /^[0-9]{1,2}$/;
   var keyup_descripcion = /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{10,500}$/;


   /*--------------VALIDACION DE CAMPOS--------------------*/
   document.onload = carga();
   function carga() {
      /*--------------VALIDACION PARA NOMBRE--------------------*/
      document.getElementById("nombrePatologia").maxLength = 45;
      document.getElementById("nombrePatologia").onkeypress = function (e) {
        er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("nombrePatologia").onkeyup = function () {
        r = validarkeyup(
         keyup_nombre,
         this,
         document.getElementById("snombrePatologia"),
         "* Solo letras de 10 a 45 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA NOMBRE--------------------*/

      /*--------------VALIDACION PARA BASE PATOLOGICA--------------------*/
      document.getElementById("basePatologica").maxLength = 45;
      document.getElementById("basePatologica").onkeypress = function (e) {
        er = /^[A-Za-z\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("basePatologica").onkeyup = function () {
        r = validarkeyup(
         keyup_nombre,
         this,
         document.getElementById("sbasePatologica"),
         "* Solo letras de 10 a 45 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA BASE PATOLOGICA--------------------*/

      /*--------------VALIDACION PARA SINTOMAS--------------------*/
      document.getElementById("sintomasPatologia").maxLength = 500;
      document.getElementById("sintomasPatologia").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("sintomasPatologia").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("ssintomasPatologia"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA SINTOMAS--------------------*/


/*--------------VALIDACION PARA DESCRIPCION PATOLOGIA--------------------*/
      document.getElementById("descripcionPatologia").maxLength = 500;
      document.getElementById("descripcionPatologia").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("descripcionPatologia").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("sdescripcionPatologia"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA DESCRIPCION PATOLOGIA--------------------*/

      /*--------------VALIDACION PARA DESCRIPCION ANTESCEDENTE FAMILIAR--------------------*/
      document.getElementById("descripcionPatologiaFamiliar").maxLength = 500;
      document.getElementById("descripcionPatologiaFamiliar").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("descripcionPatologiaFamiliar").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("sdescripcionPatologiaFamiliar"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA DESCRIPCION ANTESCEDENTE FAMILIAR--------------------*/


      /*--------------VALIDACION PARA DESCRIPCION DEL PARENTESCO--------------------*/
      document.getElementById("descripcionParentesco").maxLength = 500;
      document.getElementById("descripcionParentesco").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("descripcionParentesco").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("sdescripcionParentesco"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA DESCRIPCION DEL PARENTESCO--------------------*/

      /*--------------VALIDACION PARA DESCRIPCION PATOLOGIA--------------------*/
      document.getElementById("descripcionPatologia").maxLength = 500;
      document.getElementById("descripcionPatologia").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("descripcionPatologia").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("sdescripcionPatologia"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA DESCRIPCION PATOLOGIA--------------------*/

      /*--------------VALIDACION PARA DESCRIPCION CITOLOGIA--------------------*/
      document.getElementById("descripCitologia").maxLength = 500;
      document.getElementById("descripCitologia").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("descripCitologia").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("sdescripCitologia"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA DESCRIPCION CITOLOGIA--------------------*/

      /*--------------VALIDACION PARA GESTAS--------------------*/
      document.getElementById("gestas").maxLength = 500;
      document.getElementById("gestas").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("gestas").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("sgestas"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA GESTAS--------------------*/

      /*--------------VALIDACION PARAS--------------------*/
      document.getElementById("para").maxLength = 500;
      document.getElementById("para").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("para").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("spara"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARAS--------------------*/

       /*--------------VALIDACION ABORTOS--------------------*/
      document.getElementById("abortos").maxLength = 500;
      document.getElementById("abortos").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("abortos").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("sabortos"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA ABORTO--------------------*/


      /*--------------VALIDACION PARA DESCRIPCION MAMOGRAFIA--------------------*/
      document.getElementById("descripMamografia").maxLength = 500;
      document.getElementById("descripMamografia").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("descripMamografia").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("sdescripMamografia"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA DESCRIPCION MAMOGRAFIA--------------------*/


      /*--------------VALIDACION PARA MENARQUIA--------------------*/
      document.getElementById("menarquia").maxLength = 2;
      document.getElementById("menarquia").onkeypress = function (e) {
        er = /^[JGVEP0-9-]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("menarquia").onkeyup = function () {
        r = validarkeyup(
         keyup_numero,
         this,
         document.getElementById("smenarquia"),
         "* Solo numeros de 2 digitos."
         );
      };
      /*--------------FIN VALIDACION PARA MENARQUIA--------------------*/
    
    /*--------------VALIDACION PARA SIXARQUIA--------------------*/
      document.getElementById("sixarquia").maxLength = 2;
      document.getElementById("sixarquia").onkeypress = function (e) {
        er = /^[JGVEP0-9-]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("sixarquia").onkeyup = function () {
        r = validarkeyup(
         keyup_numero,
         this,
         document.getElementById("ssixarquia"),
         "* Solo numeros de 2 digitos."
         );
      };
      /*--------------FIN VALIDACION PARA SIXARQUIA--------------------*/

      /*--------------VALIDACION PARA NPS--------------------*/
      document.getElementById("nps").maxLength = 30;
      document.getElementById("nps").onkeypress = function (e) {
        er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("nps").onkeyup = function () {
        r = validarkeyup(
         keyup_nombre,
         this,
         document.getElementById("snps"),
         "* Solo letras de 10 a 30 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION NPS---------------------*/

      /*--------------VALIDACION PARA NOMBRE HABITO PSICOBIOLOGICOS--------------------*/
      document.getElementById("nombreHabitoPsicobiologico").maxLength = 45;
      document.getElementById("nombreHabitoPsicobiologico").onkeypress = function (e) {
        er = /^[A-Za-z\b\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("nombreHabitoPsicobiologico").onkeyup = function () {
        r = validarkeyup(
         keyup_nombre,
         this,
         document.getElementById("snombreHabitoPsicobiologico"),
         "* Solo letras de 10 a 45 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA NOMBRE HABITO PSICOBIOLOGICOS---------------------*/

      /*--------------VALIDACION PARA DESCRIPCION HABITO PSICOBIOLOGICOS--------------------*/
      document.getElementById("descripcionHabitoPsicobiologico").maxLength = 500;
      document.getElementById("descripcionHabitoPsicobiologico").onkeypress = function (e) {
        er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/;
        validarkeypress(er, e);
      };
      document.getElementById("descripcionHabitoPsicobiologico").onkeyup = function () {
        r = validarkeyup(
         keyup_descripcion,
         this,
         document.getElementById("sdescripcionHabitoPsicobiologico"),
         "* Solo letras de 10 a 500 caracteres, siendo la primera en mayúscula."
         );
      };
      /*--------------FIN VALIDACION PARA DESCRIPCION HABITO PSICOBIOLOGICOS--------------------*/

   document.getElementById("enviar").onclick = function () {

        var datos = new FormData();
      datos.append("accion", 'registrar');
      datos.append("nombrePatologia", $("#nombrePatologia").val());
      datos.append("basePatologica", $("#basePatologica").val());
      datos.append("sintomasPatologia", $("#sintomasPatologia").val());
      datos.append("descripcionPatologia", $("#descripcionPatologia").val());

      datos.append("descripcionPatologiaFamiliar", $("#descripcionPatologiaFamiliar").val());
      datos.append("tipoParentesco", $("#tipoParentesco").val());
      datos.append("descripcionParentesco", $("#descripcionParentesco").val());
      
      datos.append("nombreHabitoPsicobiologico", $("#nombreHabitoPsicobiologico").val());
      datos.append("descripcionHabitoPsicobiologico", $("#descripcionHabitoPsicobiologico").val());

      datos.append("menarquia", $("#menarquia").val());
      datos.append("sixarquia", $("#sixarquia").val());
      datos.append("nps", $("#nps").val());
      datos.append("citologia", $("#citologia").val());
      enviaAjax(datos);
  
  };
 };



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
      $("#nombrePatologia").val("");
      $("#basePatologica").val("");
      $("#sintomasPatologia").val("");
      $("#descripcionPatologia").val("");
      $("#descripcionPatologiaFamiliar").val("");
      $("#tipoParentesco").val("");
      $("#descripcionParentesco").val("");
      $("#nombreHabitoPsicobiologico").val("");
      $("#descripcionHabitoPsicobiologico").val("");
      $("#menarquia").val("");
      $("#sixarquia").val("");
      $("#nps").val("");
      $("#citologia").val("");

       /*Limpiar Span*/
       document.getElementById("snombrePatologia").innerText = "";
       document.getElementById("sbasePatologica").innerText = "";
       document.getElementById("ssintomasPatologia").innerText = "";
       document.getElementById("sdescripcionPatologia").innerText = "";
       document.getElementById("sdescripcionPatologiaFamiliar").innerText = "";
       document.getElementById("stipoParentesco").innerText = "";
      document.getElementById("sdescripcionParentesco").innerText = "";
       document.getElementById("snombreHabitoPsicobiologico").innerText = "";
       document.getElementById("sdescripcionHabitoPsicobiologico").innerText = "";
       document.getElementById("smenarquia").innerText = "";
       document.getElementById("ssixarquia").innerText = "";
       document.getElementById("snps").innerText = "";
       document.getElementById("scitologia").innerText = "";

       /*Limpiar class de inputs */
       document.getElementById("nombrePatologia").classList.remove("is-invalid", "is-valid");
       document.getElementById("basePatologica").classList.remove("is-invalid", "is-valid");
       document.getElementById("sintomasPatologia").classList.remove("is-invalid", "is-valid");
       document.getElementById("descripcionPatologia").classList.remove("is-invalid", "is-valid");
       document.getElementById("descripcionPatologiaFamiliar").classList.remove("is-invalid", "is-valid");
       document.getElementById("tipoParentesco").classList.remove("is-invalid", "is-valid");
       document.getElementById("descripcionParentesco").classList.remove("is-invalid", "is-valid");
       document.getElementById("nombreHabitoPsicobiologico").classList.remove("is-invalid", "is-valid");
       document.getElementById("descripcionHabitoPsicobiologico").classList.remove("is-invalid", "is-valid");
       document.getElementById("menarquia").classList.remove("is-invalid", "is-valid");
       document.getElementById("sixarquia").classList.remove("is-invalid", "is-valid");
       document.getElementById("nps").classList.remove("is-invalid", "is-valid");
       document.getElementById("citologia").classList.remove("is-invalid", "is-valid");
   }





function enviaAjax(datos) {
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success: (response) => {
      alert(response);
      limpiar();
      
    },
    error: (err) => {
      alert(err)
    },
  });
}
