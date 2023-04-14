<?php 
use PHPUnit\Framework\TestCase;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;

class eliminarAreaEmprendimientoTest extends TestCase{
	private $opt;

	public function setUp():void{
		$this->area = new AreaEmprendimiento();
	}

	//1-Cuando el usuario elimina una area de emprendimiento que existe y no se encuentra vinculado con registros de emprendimiento
	public function testCreacionCorrecta(){
		$respuesta = $this->area->eliminar(15);
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando se intenta eliminar un area de emprendimiento que no existe
	public function testNombreRepetido(){
		$respuesta = $this->area->eliminar(20);
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//3-Cuando se intenta eliminar un area de emprendimiento que posee relacion con registros de emprendimiento
	public function testExpresiones(){
		$respuesta = $this->area->eliminar(1);
		$this->assertEquals(2, $respuesta['resultado']);
	}
}

 ?>