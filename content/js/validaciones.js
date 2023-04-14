

    //-----------------------------------------------FORMULARIO DE PAGOS-------------------------------------------------------
            function Valida(formulario2) {
            alert("Bienvenido a el sistema yucatan");
                /* Validación de campos NO VACÍOS */
                if ((formulario2.recibo.value.length == 0) || (formulario2.concepto.value.length ==0) || (formulario2.numero.value.length ==0) ){
                   alert("rellena todos los campos");
                  return false;
                }
                /* validación de numero de recibo*/
                var ercp=/^[0-9]{1,9}$/;
                if (!(ercp.test(formulario2.recibo.value))) { 
                    alert('Solo numero de identificacion de recibo');
                    return false; }
                    /* validación de concepto de pago*/
                 var ercp=/^[a-zA-Z\s]{3,50}$/;
                if (!(ercp.test(formulario2.concepto.value))) { 
                    alert('Usa solo letras de la A-Z');
                    return false; }
                /* validación de la monto */
                var erdni=/^(?!.* $)[0-9.]+$/;
                if (!(erdni.test(formulario2.numero.value))) { 
                    alert('Solo letras.');
                    return false;  }
                /* si no hemos detectado fallo devolvemos TRUE */
                return true;
            }

