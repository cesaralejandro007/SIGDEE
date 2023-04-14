<?php 
use PHPUnit\Framework\TestCase;
use modelo\CensoModelo as Censo;

class eliminarCensoTest extends TestCase{
	private $censo;

	public function setUp():void{
		$this->censo = new Censo();
	}

	//2-Cuando se intenta eliminar un censo que no existe
	public function testNombreRepetido(){
		$respuesta = $this->censo->eliminar(88);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	
	//1-Cuando el usuario elimina una censo que existe 

	public function testCreacionCorrecta(){
		$respuesta = $this->censo->eliminar(6);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>