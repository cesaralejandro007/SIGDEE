<?php 
use PHPUnit\Framework\TestCase;
use modelo\ContenidoModelo as Contenido;

class incluirContenidoTest extends TestCase{
	private $contenido;

	public function setUp():void{
		$this->contenido = new Contenido();
	}

	//1-Cuando el usuario Ingresa los datos correctamente
	public function testCreacionCorrecta(){
		$respuesta = $this->contenido->incluir('Electiva','websocket','contenido.pdf');
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario desea registrar un contenido con el mismo nombre de otra que ya existe
	public function testNombreRepetido(){
		$respuesta = $this->contenido->incluir('Conceptos','websocket','contenido.pdf');
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario envia al nombre del contenido un valor con caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->contenido->incluir('Electiva***','websocket','contenido.pdf');
		$this->assertEquals(3, $respuesta['resultado']);
	}
}

 ?>