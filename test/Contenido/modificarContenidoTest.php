<?php 
use PHPUnit\Framework\TestCase;
use modelo\ContenidoModelo as Contenido;

class modificarContenidoTest extends TestCase{
	private $contenido;


	public function setUp():void{
		$this->contenido = new Contenido();
	}

	//Cuando se modifica con datos correctos
	public function testCreacionCorrecta(){
		$respuesta = $this->contenido->modificar(2, 'Electiva','websocket');
		$this->assertEquals(1, $respuesta['resultado']);
	}
	//Cuando el usuario intenta modificar una contenido con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->contenido->modificar(1,'Nuevo Servicio***','Websocket');
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//Cuando el usuario intenta modificar un contenido con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$respuesta = $this->contenido->modificar(1, 'Conceptos','websocket');
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//Cuando se intenta modificar un contenido que no existe
	public function testModificacion(){
		$respuesta = $this->contenido->modificar(45, 'Electiva','websocket');
		$this->assertEquals(4, $respuesta['resultado']);
	}


}

 ?>