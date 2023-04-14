$(document).ready(function(){
       document.getElementById('ver-censo').onclick = function(){
      var datos = new FormData();
      datos.append('accion','visualizar-censo');
      mostrar(datos); 
    } 
})


function mostrar(datos){
  $.ajax({
    async: true,
    url: '',
    type: 'POST',
    contentType: false,
    data: datos,
    processData: false,
    cache: false,
    success:function(response){      
      var res = JSON.parse(response);
      $("#id").val(res.id);
      $("#fecha_apertura").html(res.fecha_apertura);
      $("#fecha_cierre").html(res.fecha_cierre);
      $("#descripcion").html(res.descripcion);
      $("#censo").modal("show");
      
    },
    error:(err)=>{
      Toast.fire({
        icon: error.icon
      });

    }
  }); 
}