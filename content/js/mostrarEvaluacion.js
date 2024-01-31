var keyup_descripcion= /^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{2,100}$/;

document.onload = carga();
function carga(){
	var nota = !!document.getElementById("calificacion");
	if(nota)
	{
		/*
		document.getElementById("calificacion").maxLength = 5;
		document.getElementById("calificacion").onkeypress = function (e) {
			er = /^[0-9]*$/;
			validarkeypress(er, e);
		};
		document.getElementById("calificacion").onkeyup = function () {
			r = validarkeyup(keyup_calificacion,this,document.getElementById("scalificacion"), "* Solo numeros de 11  digitos");
		}; */
	}


	/*--------------VALIDACION PARA CEDULA--------------------*/
	document.getElementById('descripcion').maxLength = 100;
	document.getElementById('descripcion').onkeypress = function(e){
		er = /^[A-Za-z0-9\b\s\u00f1\u00d1\u00E0-\u00FC]*$/; 
		validarkeypress(er,e);	
	};
	document.getElementById('descripcion').onkeyup = function(){
		r = validarkeyup(keyup_descripcion,this,document.getElementById('sdescripcion'),"* El campo debe contener de 2 a 100 letras.");
	}
	/*--------------FIN VALIDACION PARA CEDULA--------------------*/



	/*-------------------FUNCIONES DE HERRAMIENTAS-------------------*/
	document.getElementById("modificar_calificacion").onclick = function () {
		var datos = new FormData();
		datos.append('accion', 'modificar_calificacion');
		datos.append('id_evaluacion', $("#id_evaluacion").val());
		datos.append('calificacion', $("#calificacion").val());
		enviaAjax(datos);
		
	};

	document.getElementById("calificar").onclick = function () {
		var datos = new FormData();
		datos.append('accion', 'calificar');
		datos.append('id_estudiante', $("#id_e").val());
		datos.append('id_unidad_evaluacion', $("#id_unidad_evaluacion").val());
		datos.append('calificacion', $("#calificacion").val());
		enviaAjax(datos);
		
	};
}

function entregar(){
	limpiar();
	$("#archivo-anterior").hide();
	$("#accion").val('entregar');
	$("#titulo").text('Entregar Evaluación');
	$("#enviar").text('Registrar');
	$("#gestion-entrega").modal("show");
}	

function enviar(){
	a = valida_registrar(); 
	if(a!=''){

	}
	else{
		var datos = new FormData();
		datos.append('accion', $("#accion").val());
		datos.append('id', $("#id").val());
		datos.append('descripcion', $("#descripcion").val());
		//Si se cambia el archivo entonces se pasa la informacion al controlador
		if ($("#archivo_adjunto")[0].files[0]!= null) {
			datos.append('archivo', $("#archivo_adjunto")[0].files[0]);}
			//datos.append('id_unidad', $("id_unidad").val());
			datos.append('id_estudiante', $("#id_estudiante").val());
			enviaAjax(datos);
		}
	}

		function revisar_calificacion(valor) {
			var datos = new FormData();
			datos.append('accion', 'mostrar-calificacion');
			datos.append('id_estudiante', valor);
			mostrar_calificacion(datos);
		}

		function validarkeypress(er,e){
			key = e.keyCode || e.which;
			tecla = String.fromCharCode(key);
			a = er.test(tecla);
			if(!a){
				e.preventDefault();
			}
		}
		function validaronclick(etiqueta,etiquetamensaje,mensaje){
			if(etiqueta.value==0){
				etiquetamensaje.innerText = mensaje;
				etiquetamensaje.style.color = 'red';
				etiqueta.classList.add('is-invalid');
				return 0;
			}
			else{
				etiquetamensaje.innerText = "";
				etiqueta.classList.remove('is-invalid');
				etiqueta.classList.add('is-valid');
				return 1;		
			}
		}
		function validarkeyup(er,etiqueta,etiquetamensaje,mensaje){
			a = er.test(etiqueta.value);
			if(!a){
				etiquetamensaje.innerText = mensaje;
				etiquetamensaje.style.color = 'red';
				etiqueta.classList.add('is-invalid');
				return 0;
			}
			else{
				etiquetamensaje.innerText = "";
				etiqueta.classList.remove('is-invalid');
				etiqueta.classList.add('is-valid');
				return 1;		
			}
		}

		function cargar_datos(valor) {
			var datos = new FormData();
			datos.append('accion', 'editar');
			datos.append('id', valor);
			mostrar(datos);
		}

		function limpiar(){	 
			document.getElementById('sdescripcion').innerText = '';
		}
		function limpiar_nota(){	 
			document.getElementById('scalificacion').innerText = '';
		}

		function valida_registrar(){ 
			var error = false;
			descripcion = validarkeyup(keyup_descripcion,document.getElementById('descripcion'),document.getElementById('sdescripcion'),"* El campo debe contener de 2 a 100 letras.");
			if(descripcion==0){
		//variable==0, indica que hubo error en la validacion de la etiqueta 
		error = true;
	}
	return error;
}

		function valida_calificacion(){ 
			var error = false;
			calificacion = validarkeyup(keyup_calificacion,document.getElementById('calificacion'),document.getElementById('scalificacion'),"* Solo numeros, con dos decimales.");
			if(calificacion==0){
				//variable==0, indica que hubo error en la validacion de la etiqueta 
				error = true;
			}
			return error;
		}

function enviaAjax(datos) {
	var toastMixin = Swal.mixin({
		toast: true,
		position: 'top-right',
		showConfirmButton: false,
		timer: 2000,
		timerProgressBar: true
	});
	$.ajax({
		url: '',
		type: 'POST',
		contentType: false,
		data: datos,
		processData: false,
		cache: false,
		success: function(response) {
			var res = JSON.parse(response);
			if (res.estatus == 1) {
				toastMixin.fire({
					animation: true,
					title: res.title,
					text: res.message,
					icon: res.icon
				});
				
				limpiar();
				setTimeout(function () {
					window.location.reload();
				}, 2000);
			}
			else {
				toastMixin.fire({
					animation: true,
					text: res.message,
					title: res.title,
					icon: res.icon
				});
			}
		},
		error: function(err) {
			
			alert(err);
		}
	});
}
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
			$("#descripcion").val(res.descripcion);
			document.getElementById("archivo_antes").href = res.url_base;
			$("#enviar").text('Modificar');
			$("#gestion-entrega").modal("show");
			$("#accion").val('modificar_entrega');
			document.getElementById('accion').innerText= 'modificar';
			$("#titulo").text('Editar Entrega de Evaluación');
			
		},
		error:function(err){
			Toast.fire({
				icon: error.icon
			});

		}
	});	
}

function mostrar_calificacion(datos){
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
			$("#id_e").val(res.id_estudiante);
			$("#id_evaluacion").val(res.id_evaluacion);
			$("#estudiante").text(res.estudiante);
			$("#calificacion").val(res.calificacion);
			$("#id_unidad_evaluacion").val(res.unidad);
			document.getElementById("archivo").href =res.archivo;
			$("#descripcion_e").val(res.descripcion);
			$("#fecha_e").val(res.fecha);
			if(res.id_evaluacion != false){
				document.getElementById("evaluacion-entregada").style.display="block";
				document.getElementById("modificar_calificacion").style.display="block";
				document.getElementById("calificar").style.display="none";
				if(res.doc != null){
					$('#archivo-evaluado').show();
				}
				else{
					$('#archivo-evaluado').hide();
				}
			}
			else
			{
				document.getElementById("evaluacion-entregada").style.display="none";
				document.getElementById("modificar_calificacion").style.display="none";
				document.getElementById("calificar").style.display="block";
			}
			$("#gestion-calificar").modal("show");
		},
		error:function(err){
			Toast.fire({
				icon: error.icon
			});

		}
	});	
}