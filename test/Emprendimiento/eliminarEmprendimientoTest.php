<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;
class eliminarEmprendimientoTest extends TestCase{
	private $Emprendimiento;

	public function setUp():void{
		$this->Emprendimiento = new Emprendimiento();
	}
	//Cuando se intenta eliminar un emprendimiento que no existe
	public function testExiste(){
		$id = 159;
		$respuesta = $this->Emprendimiento->eliminar($id);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	
	//Cuando se intenta eliminar un  emprendimiento que posee relacion Emprendimiento-modulo
	public function testRelacion(){
		$id = 1;
		$respuesta = $this->Emprendimiento->eliminar($id);
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//Cuando se intenta eliminar un  emprendimiento que posee relacion Aspirante-Emprendimiento
		public function testRelacion1(){
		$id = 19;
		$respuesta = $this->Emprendimiento->eliminar($id);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	
	//Cuando el usuario elimina una Emprendimiento  que existe y no se encuentra vinculado
	public function testEliminacionCorrecta(){
		$id = 18;
		$respuesta = $this->Emprendimiento->eliminar($id);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>