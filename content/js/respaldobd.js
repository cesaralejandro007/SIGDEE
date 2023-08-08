document.getElementById("respaldar").onclick = function(){
$(function() {
    var toastMixin = Swal.mixin({
      showConfirmButton: false,
      width: 450,
      padding: '3.5em',
      timer: 3000,
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
      var blob = new Blob([datos]);
      var link = document.createElement('a');
      link.href = window.URL.createObjectURL(blob);
      link.download = "respaldo.sql";
      link.click();
      toastMixin.fire({
        title: "Respaldo BD",
        text: "La Base de datos fue respaldado con exito",
        icon: "success",
      });
});
});
}