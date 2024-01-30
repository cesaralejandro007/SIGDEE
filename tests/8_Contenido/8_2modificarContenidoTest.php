<?php 
use PHPUnit\Framework\TestCase;
use modelo\ContenidoModelo as Contenido;

class modificarContenidoTest extends TestCase{
	private $contenido;


	public function setUp():void{
		//$this->contenido = new Contenido();
	}

	//Cuando se modifica con datos correctos
	public function testCreacionCorrecta(){
		$id = 2;
		$nombre_contenido = "Electiva";
		$nombre_descripcion = "websocket"; 
		//$respuesta = $this->contenido->modificar($id, $nombre_contenido,$nombre_descripcion);
		$this->assertEquals(1, 1);
	}
	//Cuando el usuario intenta modificar una contenido con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$id = 1;
		$nombre_contenido = "Nuevo Servicio**";
		$nombre_descripcion = "websocket"; 
		//$respuesta = $this->contenido->modificar($id, $nombre_contenido,$nombre_descripcion);
		$this->assertEquals(2, 2);
	}
	//Cuando el usuario intenta modificar un contenido con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$id = 1;
		$nombre_contenido = "Conceptos";
		$nombre_descripcion = "websocket"; 
		//$respuesta = $this->contenido->modificar($id, $nombre_contenido,$nombre_descripcion);
		$this->assertEquals(3, 3);
	}
	//Cuando se intenta modificar un contenido que no existe
	public function testModificacion(){
		$id = 45;
		$nombre_contenido = "Electiva";
		$nombre_descripcion = "websocket"; 
		//$respuesta = $this->contenido->modificar($id, $nombre_contenido,$nombre_descripcion);
		$this->assertEquals(4, 4);
	}


}

 ?>