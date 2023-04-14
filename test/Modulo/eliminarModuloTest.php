<?php 
use PHPUnit\Framework\TestCase;
use modelo\ModuloModelo as Modulo;

class eliminarModuloTest extends TestCase{
	private $Modulo;

	public function setUp():void{
		$this->Modulo = new Modulo();
	}

	//2-Cuando se intenta eliminar un Modulo  que no existe
	public function testExiste(){
		$respuesta = $this->Modulo->eliminar(20);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//3-Cuando se intenta eliminar un Modulo  que posee relacion con Emprendimiento-modulo
	public function testRelacion(){
		$respuesta = $this->Modulo->eliminar(1);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una Modulo que existe y no se encuentra vinculado
	public function testCreacionCorrecta(){
		$respuesta = $this->Modulo->eliminar(13);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>