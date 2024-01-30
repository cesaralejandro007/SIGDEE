<?php 
use PHPUnit\Framework\TestCase;
use modelo\CensoModelo as Censo;

class eliminarCensoTest extends TestCase{
	private $censo;

	public function setUp():void{
		$this->censo = new Censo();
	}

	//Cuando se intenta eliminar un censo que no existe
	public function testExiste(){
		$id = 88;
		$respuesta = $this->censo->eliminar($id);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	
	//Cuando el usuario elimina una censo que existe 
	public function testEliminacionCorrecta(){
		$id = 2;
		$respuesta = $this->censo->eliminar($id);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>