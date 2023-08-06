document.getElementById("respaldar").onclick = function(){

    
$(function() {
    var toastMixin = Swal.mixin({
        showConfirmButton: false,
        width: 450,
        padding: '3.5em',
        timer: 2000,
        timerProgressBar: true,
      });
    var formData = new FormData();
    formData.append("accion", "respaldarbd");
  $.ajax({
    url: "",
    type: "POST",
    contentType: false,
    data: formData,
    processData: false,
    cache: false
  }).done(function(datos) {
    var res = JSON.parse(datos);
    if (res.estatus == 1) {
      toastMixin.fire({
        title: res.title,
        text: res.message,
        icon: res.icon,
      });
    } else {
      toastMixin.fire({
        text: res.message,
        title: res.title,
        icon: res.icon,
      });
    }
});

});
}