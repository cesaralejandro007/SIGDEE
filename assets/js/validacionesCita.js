$(document).ready(function() {

      $("#errorCe").hide();
      $("#errorNom").hide();
      $("#errorApe").hide();
      $("#errorCo").hide();
      $("#errorTele").hide();
      $("#errorFe").hide();
      $("#errorHo").hide();
      $("#errorMoti").hide();


      var errorCedula = false;
      var errorNombre = false;
      var errorApellido = false;
      var errorCorreo = false;
      var errorTelefono = false;
      var errorFecha = false;
      var errorHora = false;      
      var errorMotivo = false;
        

        $("#cedula").focusout(function(){
            campo_cedula();
         })
          $("#nombre").focusout(function(){
            campo_nombre();
         })
         $("#apellido").focusout(function() {
            campo_apellido();
         })
         $("#correo").focusout(function() {
            campo_correo();
         })
         $("#telefono").focusout(function() {
            campo_telefono();
          })
         $("#fecha").focusout(function() {
            campo_fecha();
          })
         $("#hora").focusout(function() {
            campo_hora();
             })
         $("#motivo").focusout(function() {
            campo_motivo();   
         })

        
          function campo_cedula() {
            var cedula_length = $("#cedula").val().length;
            if (cedula_length < 7) {
               $("#errorCe").html("Al menos 7 carácteres");
               $("#errorCe").show();
               $("#cedula").css("border-bottom","2px solid #F90A0A");
               errorCedula = true;
            } else {
               $("#errorCe").hide();
               $("#cedula").css("border-bottom","2px solid #008f39");
            }
         }

          function campo_nombre() {
            var campo = /^[a-zA-Z ]*$/;
            var nombre = $("#nombre").val();
            if (campo.test(nombre) && nombre !== '') {
               $("#errorNom").hide();
               $("#nombre").css("border-bottom","2px solid #008f39");
            } else {
               $("#errorNom").html("Solo caracteres");
               $("#errorNom").show();
               $("#nombre").css("border-bottom","2px solid #F90A0A");
               errorNombre = true;
            }
         }

          function campo_apellido() {
            var campo = /^[a-zA-Z ]*$/;
            var apellido = $("#apellido").val();
            if (campo.test(apellido) && apellido !== '') {
               $("#errorApe").hide();
               $("#apellido").css("border-bottom","2px solid #008f39");
            } else {
               $("#errorApe").html("Solo caracteres");
               $("#errorApe").show();
               $("#apellido").css("border-bottom","2px solid #F90A0A");
               errorApellido = true;
            }
         }

         function campo_correo() {
            var campo = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            var correo = $("#correo").val();
            if (campo.test(correo) && correo !== '') {
               $("#errorCo").hide();
               $("#correo").css("border-bottom","2px solid #008f39");
            } else {
               $("#errorCo").html("Solo caracteres");
               $("#errorCo").show();
               $("#correo").css("border-bottom","2px solid #F90A0A");
               errorCorreo = true;
            }
         }

         function campo_telefono() {
            var telefono_length = $("#telefono").val().length;
            if (telefono_length < 11) {
               $("#errorTele").html("Al menos 11 digitos");
               $("#errorTele").show();
               $("#telefono").css("border-bottom","2px solid #F90A0A");
               errorTelefono = true;
            } else {
               $("#errorTele").hide();
               $("#telefono").css("border-bottom","2px solid #008f39");
            }
         }

         function campo_fecha() {
            var campo = /^(0[1-9]|1[0-2])\/(0[1-9]|1\d|2\d|3[01])\/(0[1-9]|1[1-9]|2[1-9])$/;
            var fecha = $("#fecha").val();
            if (campo.test(fecha) && fecha !== '') {
               $("#errorFe").hide();
               $("#fecha").css("border-bottom","2px solid #F90A0A");
            } else {
               $("#errorFe").html("Seleccione la Fecha ");
               $("#errorFe").show();
               $("#fecha").css("border-bottom","2px solid #008f39");
               errorFecha = true;
            }
         }


           function campo_hora() {
            var campo = /^([01]?[0-9]|2[0-3]):[0-5][0-9]*$/;
            var hora = $("#hora").val();
            if (campo.test(hora) && hora !== '') {
               $("#errorHo").hide();
               $("#hora").css("border-bottom","2px solid #008f39");
            } else {
               $("#errorHo").html("Ingrese la hora");
               $("#errorHo").show();
               $("#hora").css("border-bottom","2px solid #F90A0A");
               errorHora = true;
            }
         }
   
           function campo_motivo() {
            var campo = /^[a-zA-Z ]*$/;
            var motivo = $("#motivo").val();
            if (campo.test(motivo) && motivo !== '') {
               $("#errorMoti").hide();
               $("#motivo").css("border-bottom","2px solid #008f39");
            } else {
               $("#errorMoti").html("Solo caracteres");
               $("#errorMoti").show();
               $("#motivo").css("border-bottom","2px solid #F90A0A");
               errorMotivo = true;
            }
         }
         
          $("#enviar").on("click", function() {
            var errorCedula = false;
            var errorNombre = false;
            var errorApellido = false;
            var errorCorreo = false;
            var errorTelefono = false;
            var errorFecha = false;
            var errorHora = false;      
            var errorMotivo = false;
        
            campo_cedula();
            campo_nombre();
            campo_apellido();
            campo_correo();
            campo_telefono();
            campo_fecha();
            campo_hora();
            campo_motivo();
           

        if (errorCedula === false && errorNombre === false && errorApellido === false && errorCorreo === false && errorTelefono === false && errorFecha === false && errorHora === false && errorMotivo === false) {
           
           let fechaCita = $('#fecha').val();
           let horaCita = $('#hora').val();
           let motivoCita = $('#motivo').val();
           let cedulaPaciente = $('#cedula').val();
           let nombrePaciente = $('#nombre').val();
           let apellidoPaciente = $('#apellido').val();
           let correoPaciente = $('#correo').val();
           let telefonoPaciente = $('#telefono').val(); 


           $.ajax({

            type: "POST",
            url: '',
            dataType: "json",
            data:{
               fechaCita,
               horaCita,
               motivoCita,
               cedulaPaciente,
               nombrePaciente,
               apellidoPaciente,
               correoPaciente,
               telefonoPaciente
            },

           success: function (response) {
                  all();

                  Swal.fire('Success.', response, 'success')
              }
          });

          
        } else if (result.isDenied) {
          Swal.fire('Changes are not saved', '', 'info')
        }

           })

      })