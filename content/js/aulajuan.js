var keyup_modulo= /^[A-Za-z0-9_\u00d1\u00f1\u00E0-\u00FC]$/;
var keyup_aula= /^(([A-ZÁÉÍÓÚ]+[a-zñáéíóú.,-]*[\s]?)*)$/;
var keyup_docente=/^[0-9]$/;
var keyup_area=/^[0-9]$/;
$(document).ready(function(){
	$("#aulas").addClass("active");
	$("#aulas").addClass("show");
	$("#gestion-aula").removeClass("active");
	$("#modificar").removeClass("active");
	$("#lista").addClass("active");
	$('#funcionpaginacion').DataTable();
	$('#estudiantes').bootstrapDualListbox({
		nonSelectedListLabel: 'Aspirantes existentes',   
		selectedListLabel: 'Aspirantes Seleccionados',     
		infoText: 'Mostrando {0}',
		infoTextFiltered: '<span class="badge badge-warning">Buscar</span> {0} de {1}', 
		infoTextEmpty: 'Lista Vacia', 
	});


	/*--------------VALIDACION PARA NOMBRE--------------------*/
	document.getElementById('area').onkeyup = function(){
		r = validarkeyup(keyup_area,this,document.getElementById('sarea'),"* Seleccione un area de emprendimiento.");
	}
	/*--------------FIN VALIDACION PARA NOMBRE--------------------*/

/**
1- mostrar aulas con funcion muestra aulas
2- mostrar areas con funcion muestra areas
3- mostrar docentes con funcion muestra docentes
4- asociar evento a area de manera que si cambia
	cambie el emprendimiento asociado a esa area	
5- asociar evento a empredimiento de manera que cuando cambie
	muestre los modulos asociandos a ese emprendimiento, tambien
	debe mostrar los aspirantes a ese empredimiento
	**/

	
	//1
	muestraAulas();
	//2
	muestraAreas();
	//3
	muestraDocentes();

	
	
	//4
	$("#area").on('change', function () {
		$('#tipo').html('<option value="" disabled selected>Seleccione</option>');
		$('#modulo').html('<option value="" disabled selected>Seleccione</option>');
		$('#estudiantes').html('');
		muestraEmpredimientos();
	});
	
	//5
	$("#tipo").on('change', function () {

		$('#estudiantes').html('');
		$('#modulo').html('<option value="" disabled selected>Seleccione</option>');
		muestraModulos();
		muestraAspirantes();
	});

	document.getElementById('enviar').onclick = function(){

		var arrayEstudiantes=JSON.stringify($("#estudiantes").val());
		var datos = new FormData();
		datos.append('accion', 'registrar');
		datos.append('id', $("#id").val());
		datos.append('nombre', $("#nombre").val());
		datos.append('id_tipo', $("#tipo").val());
		datos.append('id_modulo', $("#modulo").val());
		datos.append('docente', $("#docente").val());
		datos.append('estudiantes',arrayEstudiantes);
		recibe_ajax(datos);
		
	}

	document.getElementById('nuevo').onclick = function(){
		muestraAspirantes();
		muestraAreas();
		muestraDocentes();
		muestraModulos();
		muestraEmpredimientos();	
		document.getElementById('selectores').style.display = '';	
	}
});

function edita_aula(valor){
	muestraDocentes_aula(valor);
	muestraAspirantes_aula(valor);
}




function muestraAspirantes(){
	//cuando cambie el empredimiento se hace lo mismo
		//pero en este caso se le anexa el formdata 
		//el id del area para filtrar los emprendimientos
		var datos = new FormData();
		//a ese datos le añadimos la informacion a enviar
		datos.append('accion','listadoaspirantes'); 
		datos.append('emprendimiento',$("#tipo").val()); 
		//ahora se envia el formdata por ajax
		enviaAjax(datos);
	}
	function muestraModulos(){
	//cuando cambie el empredimiento se hace lo mismo
		//pero en este caso se le anexa el formdata 
		//el id del area para filtrar los emprendimientos
		var datos = new FormData();
		//a ese datos le añadimos la informacion a enviar
		datos.append('accion','listadomodulos'); 
		datos.append('emprendimiento',$("#tipo").val()); 
		//ahora se envia el formdata por ajax
		enviaAjax(datos);
	}
	function muestraEmpredimientos(){
	//cuando cambie el area se hace lo mismo
		//pero en este caso se le anexa el formdata 
		//el id del area para filtrar los emprendimientos
		var datos = new FormData();
		//a ese datos le añadimos la informacion a enviar
		datos.append('accion','listadoemprendimientos'); 
		datos.append('area',$("#area").val()); 
		//ahora se envia el formdata por ajax
		enviaAjax(datos);
	}
	function muestraAulas(){
		var datos = new FormData();
	//a ese datos le añadimos la informacion a enviar
	datos.append('accion','listadoaulas'); //le digo que me muestre un listado de aulas
	//ahora se envia el formdata por ajax
	enviaAjax(datos);
}
function muestraAreas(){
	var datos = new FormData();
	//a ese datos le añadimos la informacion a enviar
	datos.append('accion','listadoareas'); //le digo que me muestre un listado de aulas
	//ahora se envia el formdata por ajax
	enviaAjax(datos);
}
function muestraDocentes(){
	var datos = new FormData();
	//a ese datos le añadimos la informacion a enviar
	datos.append('accion','listadodocentes'); //le digo que me muestre un listado de aulas
	//ahora se envia el formdata por ajax
	enviaAjax(datos);
}


/*------FUNCIONES PARA EDITAR EL AULA------*/
function muestraDocentes_aula(id_aula){
	var datos = new FormData();
	//a ese datos le añadimos la informacion a enviar
	datos.append('accion','editarlistadodocentes'); //le digo que me muestre un listado de aulas
	datos.append('id_aula',id_aula); //le digo que me muestre un listado de aulas
	//ahora se envia el formdata por ajax
	enviaAjax(datos);
}

function muestraAspirantes_aula(id_aula){
	//cuando cambie el empredimiento se hace lo mismo
		//pero en este caso se le anexa el formdata 
		//el id del area para filtrar los emprendimientos
		var datos = new FormData();
		//a ese datos le añadimos la informacion a enviar
		datos.append('accion','editarlistadoaspirantes'); 
		datos.append('id_aula',id_aula); 
		//ahora se envia el formdata por ajax
		enviaAjax(datos);
	}
	/*------FIN DE FUNCIONES PARA EDITAR EL AULA------*/


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

	function valida_registrar(){ 
		var error = false;
		docente = validarkeyup(keyup_docente,document.getElementById('docente'),document.getElementById('sdocente'),"* Indique el docente que impartirá el modulo.");
		nombre = validarkeyup(keyup_aula,document.getElementById('nombre'),document.getElementById('snombre'),"* Indique el nombre del aula.");
		if(nombre==0 || docente==0){
			error = true;
		}
		return error;
	}

	function enviaAjax(datos){

		$.ajax({
			async: true,
            url: '', //la pagina a donde se envia por estar en mvc, se omite la ruta ya que siempre estaremos en la misma pagina
            type: 'POST',//tipo de envio 
            contentType: false,
            data: datos,
            processData: false,
            cache: false,
            beforeSend: function(){
				//pasa antes de enviar pueden colocar un loader
				//$('.loader').show(); 							
				
			},
			timeout:10000,
            success: function(respuesta) {//si resulto exitosa la transmision

            	try{
				//			console.log(respuesta);
				var lee = JSON.parse(respuesta);	
				//console.log(lee.resultado);				
				if(lee.resultado=='listadoaulas'){
					//console.log(lee.mensaje);
					$('#listaaulas').html(lee.mensaje);
				}
				else if(lee.resultado=='listadoareas'){
					//console.log(lee.mensaje);
					$('#area').html(lee.mensaje);
				}
				else if(lee.resultado=='listadoemprendimientos'){
					//console.log(lee.mensaje);
					$('#tipo').html(lee.mensaje);
				}
				else if(lee.resultado=='listadomodulos'){
					//console.log(lee.mensaje);
					$('#modulo').html(lee.mensaje);
				}
				else if(lee.resultado=='listadodocentes'){
					//console.log(lee.mensaje);
					$('#docente').html(lee.mensaje);
				}
				else if(lee.resultado=='listadodocentes_aula'){
					//console.log(lee.mensaje);
					$('#docente').html(lee.mensaje);
					$("#enviar").text('Modificar');
					$("#id").val(lee.aula);
					document.getElementById('selectores').style.display = 'none';
					$("#accion").val('modificar');
					document.getElementById('accion').innerText= 'modificar';
					$("#aulas").removeClass("active");
					$("#aulas").removeClass("show");
					$("#gestion-aula").addClass("active");
					$("#modificar").addClass("active");
					$("#lista").removeClass("active");
				}
				else if(lee.resultado=='listadoaspirantes'){
					
					$('#estudiantes').html(lee.mensaje);
					$('#estudiantes').bootstrapDualListbox('refresh', true);

					
				}
				else if(lee.resultado=='listadoaspirantes_aula'){
					
					$('#estudiantes').html(lee.mensaje);
					$('#estudiantes').bootstrapDualListbox('refresh', true);
					
					
				}

				else if(lee.resultado=='error'){
					alert(lee.mensaje);
				}
				
			}
			catch(e){
				alert("Error en JSON "+e.name+" !!!");
			}
			  //cuanto termina el proceso ocultan el loader
			  $('.loader').hide();
			},
			error: function(request, status, err){
				$('.loader').hide();
				$("#mostrarmodal").modal("hide");
				if (status == "timeout") {
					//pasa cuando superan los 10000 10 segundos de timeout
					//muestraMensaje("Servidor ocupado, intente de nuevo");
				} else {
					//cuando ocurreo otro error con ajax
				    //muestraMensaje("ERROR: <br/>" + request + status + err);
				}
			},
			complete: function(){
				//si no se recibio ninguna que se entienda del servidor
				//se oculta igual el loader
				//$('.loader').hide(); 
				
			}
			
		});
	}


	function recibe_ajax(datos){
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
			success:function(response){
				var res = JSON.parse(response);
			//alert(res.title);
			if (res.estatus == 1) {
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
		error:function(err){
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
			success:(response)=>{			
				var res = JSON.parse(response);
				alert(res.id_docente);
				$("#id").val(res.id);
				$("#nombre").val(res.aula);
				$("#docente option[value="+ res.id_docente +"]").attr("selected",true);

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

