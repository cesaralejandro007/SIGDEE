
$.ajax({
    async: true,
    url: '',
    type: 'POST',
        data:{
            cedula:$('#actualizar'),
            pnom:$('#fnom'),
            contentType: false,
            processData: false,
	        cache: false,
        }
         success: function(data){
        alert(data);
        }
    }  
    )
