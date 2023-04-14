const seccionesPaginas = new fullpage('#fullpage',{
 		
 		 autoScrolling:false, // Se activa el scroll.
		 fitToSection: true, // Acomoda el scroll automaticamente para que la seccion se muestre en pantalla.
		 fitToSectionDelay: 4000, // Delay antes de acomodar la seccion automaticamente.
		 easing: 'easeInOutCubic', // Funcion de tiempo de la animacion.
		 scrollingSpeed: 800, // Velocidad del scroll. Valores: en milisegundos.
		 css3: true, // Si usara CSS3 o javascript.
		 easingcss3: 'ease-out', // Curva de velocidad del efecto.
		 loopBottom: true, // Regresa a la primera seccion siempre y cuando se ya haya llegado a la ultima sección y el ususario siga scrolleando.
		 showActiveTooltip: false, // Mostrar tooltip activa.
		 verticalCentered: true, // Si alineara de forma vertical los contenidos de cada seccion.
});
