var mensaje1 = document.getElementById('con1');
var mensaje2 = document.getElementById('con2');

var campo1 = function(e){
if (formulario.usuario.value==""){
	mensaje1.innerHTML="<div class='alert alert-danger m-0'><button class='close' data-dismiss='alert'><span>&times;</span></button>Complete el campo usuario.</div>";
	e.preventDefault(e);
}
else{
   mensaje1.innerText="";
}

return true;
}

var campo2 = function(e){
if(formulario.clave.value==""){
		mensaje2.innerHTML="<div class='alert alert-danger m-0'><button class='close' data-dismiss='alert'><span>&times;</span></button>Complete el campo clave.</div>";
		e.preventDefault(e);
	
	}
	
	else{
	   mensaje2.innerText="";
	}
	
	return true;
	}

var validar= function(e){
		campo1(e);
		campo2(e);
	}


formulario.addEventListener("submit", validar);


