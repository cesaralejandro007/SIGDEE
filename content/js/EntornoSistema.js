
	$(document).ready(function() {    
		var table = $('#funcionpaginacion').DataTable({      
			language: {
					"lengthMenu": "Mostrar _MENU_ registros",
					"zeroRecords": "No se encontraron resultados",
					"info": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
					"infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
					"infoFiltered": "(filtrado de un total de _MAX_ registros)",
					"sSearch": "Buscar:",
					"oPaginate": {
						"sFirst": "Primero",
						"sLast":"Último",
						"sNext":"Siguiente",
						"sPrevious": "Anterior"
			   },
			   "sProcessing":"Procesando...",
				},
			//para usar los botones   
			dom: "B<'row'<'col-sm-6'><'col-sm-6'f>>" +
			"<'row'<'col-sm-12'tr>>" +
			"<'row'<'col-sm-5'il><'col-sm-7'p>>",
			colReorder: true,
			lengthMenu: [5, 10, 20, 30, 40, 50, 100],   
			buttons:[ 
		  {
			extend:    'excelHtml5',
			filename: function() {
			  return "EXCEL-EntornosSistema"      
			},          
			title: function() {
			  var searchString = table.search();        
			  return searchString.length? "Search: " + searchString : "Reporte de Entornos de Sistema"
			},
			text:      '<i class="fas fa-file-excel text-success"></i> ',
			titleAttr: 'Exportar a Excel',
			className: 'btn border border-success bg-white mr-1',
			exportOptions: {
			  columns: [0]
		  }
		  },
		  {
			extend:    'pdfHtml5',
			filename: function() {
			  return "PDF-EntornosSistema"      
			},          
			title: function() {
			  var searchString = table.search();        
			  return searchString.length? "Search: " + searchString : "Reporte de Entornos de Sistema"
			},
			text:      '<i class="fas fa-file-pdf text-danger "></i> ',
			titleAttr: 'Exportar a PDF',
			className: 'btn border border-danger bg-white mr-1',
			exportOptions: {
			  columns: [0]
		  }
		},
		  {
			extend:    'print',
			filename: function() {
			  return "Print-EntornosSistema"      
			},          
			title: function() {
			  var searchString = table.search();        
			  return searchString.length? "Search: " + searchString : "Reporte de Entornos de Sistema"
			},
			text:      '<i class="fa fa-print text-info"></i> ',
			titleAttr: 'Imprimir',
			className: 'btn border border-info bg-white mr-1',
			exportOptions: {
			  columns: [0]
		  }
		  },    
		]  
		});     
	  });

