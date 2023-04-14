
$(document).ready(function() {

         $("#loguser").focusout(function(){
            chequeo_nombre();
         });
         $("#logpass").focusout(function() {
            check_password();
         });
      

   function chequeo_nombre() {

            var chequeo = /^[a-zA-Z]*$/;
            var nombre = $("#loguser").val();

            if (chequeo.test(nombre) && nombre !== '') {
               $("#loguser").css("border-bottom","3px solid #008f39");
               } else {
               $("#loguser").css("border-bottom","3px solid #F90A0A");

               error_usuario = true;
            }
         }

   function check_password() {
            var password_length = $("#logpass").val().length;
            if (password_length < 8) {
               
               $("#logpass").css("border-bottom","2px solid #F90A0A");
               error_pass = true;
            } else {
               $("#logpass").css("border-bottom","2px solid #34F458");
            }
         }

 $("#entrar1").on("click", function() {
         error_usuario = false;
         error_pass = false;
         
        
            chequeo_nombre();
            check_password();
          
           

            if (error_usuario === false && error_pass=== false) {
              Swal.fire({
                  title: '<strong><i>Has ingresado existosamente</i></strong>',
                 icon: 'success',
                 html: '<a href="?url=dashboard" class="btn"> Ir al Sismeta</a>',
                 showConfirmButton: false,
               })
         
               return false;
            } else {
                  Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Ingresa los datos correctamente',
                    
                  })               
                  return false;
            }

         });

         $("#logname").focusout(function(){
            check_name();
         });
         $("#logemail").focusout(function() {
            check_email();
         });
         $("#logpass1").focusout(function() {
            check_password();
         });
         $("#logpass2").focusout(function() {
            check_retype_password();
         });

         function check_name() {
            var pattern = /^[a-zA-Z ]*$/;
            var fname = $("#logname").val();
            if (pattern.test(fname) && fname !== '') {
               $("#logname").css("border-bottom","2px solid #34F458");
            } else {
             
               $("#logname").css("border-bottom","2px solid #F90A0A");
               error_fname = true;
            }
         }

         function check_email() {
            var pattern = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var email = $("#logemail").val();
            if (pattern.test(email) && email !== '') {
               $("#logemail").css("border-bottom","2px solid #34F458");
            } else {
               $("#logemail").css("border-bottom","2px solid #F90A0A");
               error_email = true;
            }
         }

         function check_password() {
            var password_length = $("#logpass1").val().length;
            if (password_length < 8) {
               $("#logpass1").css("border-bottom","2px solid #F90A0A");
               error_password = true;
            } else {
               $("#logpass1").css("border-bottom","2px solid #34F458");
            }
         }

         function check_retype_password() {
            var password = $("#logpass1").val();
            var retype_password = $("#logpass2").val();
            if (password !== retype_password) {
               $("#logpass2").css("border-bottom","2px solid #F90A0A");
               error_retype_password = true;
            } else {
               $("#logpass2").css("border-bottom","2px solid #34F458");
            }
         }


          $("#registrar").on("click", function() {
         error_fname = false;
         error_email = false;
         error_password = false;
         error_retype_password = false;
        
            check_name();
            check_email();
            check_password();
            check_retype_password();
           

            if (error_fname === false && error_email === false && error_password === false && error_retype_password === false) {
              Swal.fire({
              position: 'top-end',
              icon: 'success',
              title: 'Registro Exitoso',
              showConfirmButton: false,
              timer: 1500
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
