<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;

class eliminarEmprendimientoTest extends TestCase{
	private $Emprendimiento;

	public function setUp():void{
		$this->Emprendimiento = new Emprendimiento();
	}

	
	//4-Cuando se intenta eliminar un emprendimiento que no existe
	public function testExiste(){
		$respuesta = $this->Emprendimiento->eliminar(159);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	
	//3-Cuando se intenta eliminar un  emprendimiento que posee relacion Emprendimiento-modulo
	public function testRelacion(){
		$respuesta = $this->Emprendimiento->eliminar(1);
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//2-Cuando se intenta eliminar un  emprendimiento que posee relacion Aspirante-Emprendimiento
		public function testRelacion1(){
		$respuesta = $this->Emprendimiento->eliminar(19);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	
		
	//1-Cuando el usuario elimina una Emprendimiento  que existe y no se encuentra vinculado
	public function testEliminacionCorrecta(){
		$respuesta = $this->Emprendimiento->eliminar(18);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>