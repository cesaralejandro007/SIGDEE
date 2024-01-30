<?php 
use PHPUnit\Framework\TestCase;
use modelo\ModuloModelo as Modulo;
class eliminarModuloTest extends TestCase{
	private $Modulo;
	public function setUp():void{
		$this->Modulo = new Modulo();
	}

	//3-Cuando se intenta eliminar un Modulo  que no existe
	public function testExiste(){
		$id = 20;
		$respuesta = $this->Modulo->eliminar($id);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//2-Cuando se intenta eliminar un Modulo  que posee relacion con Emprendimiento-modulo
	public function testRelacion(){
		$id = 36;
		$respuesta = $this->Modulo->eliminar($id);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una Modulo que existe y no se encuentra vinculado
	public function testCreacionCorrecta(){
		$id = 42;
		$respuesta = $this->Modulo->eliminar($id);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>