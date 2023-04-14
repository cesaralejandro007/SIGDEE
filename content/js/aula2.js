var keyup_modulo= /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]$/;
var keyup_docente=/^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]$/;
$(document).ready( function () {
	$("#aulas").addClass("active");
	$("#aulas").addClass("show");
	$("#gestion-aula").removeClass("active");
	$("#modificar").removeClass("active");
	$("#lista").addClass("active");
	$('#funcionpaginacion').DataTable();
} );

//FUNCION DE BUSQUEDA :V
$("#buscarb").click(function (e) { 
	if($("#buscar").val()==''){
		$("#buscar").addClass("is-invalid");
		preventDefault(e);
	}
	else{
		$("#buscar").removeClass("is-invalid");
		var valor = $("#buscar").val();
		var search = new FormData();
		search.append('buscarE',valor);
		search.append('accion', 'buscar');
		buscadorAjax(search);
	}
	
});
document.onload = carga();
function carga(){
	$("#area").on('change', function () {
		$("#area option:selected").each(function () {
			var id = $(this).val();
			var datos = new FormData();
			datos.append('accion', 'listar_tipos');
			datos.append('id_area', id);
			listar_tipos(datos);

		});
	}); 
	$("#tipo").on('change', function () {
		$("#tipo option:selected").each(function () {
			var id_tipo = $(this).val();
			var datos = new FormData();
			datos.append('accion', 'listar_modulos');
			datos.append('id_tipo', id_tipo);
			listar_modulos(datos);

		});
	}); 
	$("#modulo").on('change', function () {
		$("#modulo option:selected").each(function () {
			var id_modulo = $(this).val();
			var id_tipo = $("#tipo").val();
			var datos = new FormData();
			datos.append('accion', 'generar_nombre');
			datos.append('id_modulo', id_modulo);
			datos.append('id_tipo', id_tipo);
			generar_nombre(datos);

		});
	}); 
	$('.duallistbox').bootstrapDualListbox({
		nonSelectedListLabel: 'Estudiantes existentes',   
		selectedListLabel: 'Estudiantes Seleccionados',     
		infoText: 'Mostrando {0}',
		infoTextFiltered: '<span class="badge badge-warning">Buscar</span> {0} de {1}', 
		infoTextEmpty: 'Lista Vacia', 
	});

	document.getElementById('enviar').onclick = function(){
		a = valida_registrar(); 
		if(a!=''){
		}
		else{
			var arrayEstudiantes=JSON.stringify($("#estudiantes").val());
			var datos = new FormData();
			datos.append('accion', $("#accion").val());
			datos.append('id', $("#id").val());
			datos.append('nombre', $("#nombre").val());
			datos.append('id_tipo', $("#tipo").val());
			datos.append('id_modulo', $("#modulo").val());
			datos.append('docente', $("#docente").val());
			datos.append('estudiantes',arrayEstudiantes);
			enviaAjax(datos);
		}
	}	

	document.getElementById('nuevo').onclick = function(){
		limpiar();
		$("#accion").val('registrar');
		$("#titulo").text('Registrar Aula');
		$("#enviar").text('Registrar');
		document.getElementById('selectores').style.display = '';
	}	
}


/*-------------------FUNCIONES DE HERRAMIENTAS-------------------*/
function validarkeypress(er,e){
	key = e.keyCode || e.which;
	tecla = String.fromCharCode(key);
	a = er.test(tecla);
	if(!a){
		e.preventDefault();
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
	else if(etiqueta.value==''){
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

function limpiar(){
	$("#nombre").val('');
	document.getElementById('snombre').innerText = '';
	document.getElementById('nombre').classList.remove('is-invalid', 'is-valid');
}

function valida_registrar(){ 
	var error = false;
	docente = validarkeyup(keyup_docente,document.getElementById('docente'),document.getElementById('sdocente'),"* Indique el docente que impartirà el modulo.");
	if(nombre==0 || docente==0){
		error = true;
	}
	return error;
}

function cargar_datos(valor){
	var datos = new FormData();
	datos.append('accion','editar');
	datos.append('id',valor);
	mostrar(datos); 
}


function eliminar(idnombre){
	Swal.fire({
		title: '¿Desea Eliminar el Registro?',
		text: "¡No podrás revertir esto!",
		icon: 'warning',
		showCloseButton: true,
		showCancelButton: true,
		confirmButtonColor: '#3085d6',
		cancelButtonColor: '#d33',
		confirmButtonText: 'Confirmar',
		cancelButtonText: 'Cancelar'
	}).then((result) => {
		if (result.isConfirmed) {
			setTimeout(function() {
				var datos = new FormData();
				datos.append('accion','eliminar');
				datos.append('id',idnombre);
				enviaAjax(datos);
			},10);
		}
	})

}	

function enviaAjax(datos){
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
		success:(response)=>{
			var res = JSON.parse(response);
			//alert(res.title);
			if (res.estatus == 1) {
				limpiar();
				toastMixin.fire({
					animation: true,
					title: res.title,
					text: res.message,
					icon: res.icon
				});	
				setTimeout(function() {
					window.location.reload();
				},2000);
			}
			else
			{
				toastMixin.fire({
					animation: true,
					text: res.message,
					title: res.title,
					icon: res.icon
				});	
			}
		},
		error:(err)=>{
			Toast.fire({
				icon: res.error
			});

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
		success:(response)=>{			var res = JSON.parse(response);
			//var profesor = res.cedula+'/'+res.nombre+' '+res.apellido;
			$("#id").val(res.id);
			$("#nombre").val(res.aula);
			$("#docente").val(res.id_docente);

			//$("#cedula").val(res.cedula);
			$("#enviar").text('Modificar');
			document.getElementById('selectores').style.display = 'none';
			$("#accion").val('modificar');
			document.getElementById('accion').innerText= 'modificar';
			$("#aulas").removeClass("active");
			$("#aulas").removeClass("show");
			$("#gestion-aula").addClass("active");
			$("#modificar").addClass("active");
			$("#lista").removeClass("active");
		},
		error:(err)=>{
			Toast.fire({
				icon: error.icon
			});

		}
	});	
}
function listar_tipos(datos){
	$.ajax({
		async: true,
		url: '',
		type: 'POST',
		contentType: false,
		data: datos,
		processData: false,
		cache: false,
		success:(response)=>{
			$("#tipo").html(response);
		},
		error:(err)=>{
		}
	});	
}

function listar_modulos(datos){
	$.ajax({
		async: true,
		url: '',
		type: 'POST',
		contentType: false,
		data: datos,
		processData: false,
		cache: false,
		success:(response)=>{
			$("#modulo").html(response);
		},
		error:(err)=>{
		}
	});	
}

function generar_nombre(datos){
	$.ajax({
		async: true,
		url: '',
		type: 'POST',
		contentType: false,
		data: datos,
		processData: false,
		cache: false,
		success:(response)=>{
			$("#nombre").val(response);
		},
		error:(err)=>{
		}
	});	
}