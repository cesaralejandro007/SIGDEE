<?php 
use PHPUnit\Framework\TestCase;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;

class eliminarAreaEmprendimientoTest extends TestCase{
	private $area;

	public function setUp():void{
		$this->area = new AreaEmprendimiento();
	}

	
	//2-Cuando se intenta eliminar un area de emprendimiento que no existe
	public function testNombreNoexiste(){
		$id = 20;
		$respuesta = $this->area->eliminar($id);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//3-Cuando se intenta eliminar un area de emprendimiento que posee relacion con registros de emprendimiento
	public function testRelacionEmprendimiento(){
		$id = 1;
		$respuesta = $this->area->eliminar($id);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una area de emprendimiento que existe y no se encuentra vinculado con registros de emprendimiento
	public function testCreacionCorrecta(){
		$id = 19;
		$respuesta = $this->area->eliminar($id);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>