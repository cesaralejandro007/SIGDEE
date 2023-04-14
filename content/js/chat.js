function notificacionclick(){
    $("#contador").html("");
}



function eliminar(id) {
    Swal.fire({
      title: "¿Desea Eliminar el Registro?",
      text: "¡No podrás revertir esto!",
      icon: "warning",
      showCloseButton: true,
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      confirmButtonText: "Confirmar",
      cancelButtonText: "Cancelar",
    }).then(function (result) {
      if (result.isConfirmed) {
        setTimeout(function () {
          var datos = new FormData();
          datos.append("accion", "eliminar");
          datos.append("id", id);
          enviaAjax(datos);
        }, 10);
      }
    });
  }
  

  function enviaAjax(datos) {

    $.ajax({
      url: "",
      type: "POST",
      contentType: false,
      data: datos,
      processData: false,
      cache: false,
      success: function (response) {
        send(response);
        var res = JSON.parse(response);
        $("#mensaje"+res[0].id).remove();
      },
    });
  }



$(function(){

    $("#formChat").on("submit", function(e){
        
        e.preventDefault();
            var message = $("#message").val();
            var name = $("#name").val();
            if(message.length > 0){
                
                $.ajax({
                    type:"POST",
                    url: "",
                    data: "name="+name+"&message="+message,
                    dataType: 'html',
                    success: function(data){
                        send(data);
                        var JSONdata = JSON.parse(data);
                        var nameData = JSONdata[0].name;
                        var messageData = JSONdata[0].message;
                        var id = JSONdata[0].id;
                        var sesionData = JSONdata[0].sesion;
                        var dateTime = JSONdata[0].dataTime;
                        $("#containerMessages").append('<div class="d-flex justify-content-end"><li class="meMessage small p-2 me-1 mb-1 text-white rounded-3 bg-secondary"><p class="d-flex small">Fecha:'+dateTime+'</p><label>Yo: </label> '+messageData+'</li><div class="d-flex align-items-center"><a href="#" onclick="eliminar('+id+');"><i class="fas fa-trash-alt text-danger" style="font-size: 14px;"></i></a></div></div>');
                        $("#message").val('').focus();
                    }
                
                })

            }else{
                alert("Ingrese un msj!")
                $("#message").focus();
            }
    })
})