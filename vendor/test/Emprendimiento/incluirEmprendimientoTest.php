<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;

class incluirEmprendimientoTest extends TestCase{
	private $emprendimiento;

	public function setUp():void{
		$this->emprendimiento = new Emprendimiento();
	}

	/*public function testCreacionCorrecta(){
		$respuesta = $this->emprendimiento->incluir('Nuevo Servicio');
		$this->assertEquals(1, $respuesta['resultado']);
	}*/

	public function testNombreRepetido(){
		$respuesta = $this->emprendimiento->incluir('Nuevo Servicio');
		$this->assertEquals(3, $respuesta['resultado']);
	}

	public function testExpresiones(){
		$respuesta = $this->emprendimiento->incluir('Nuevo Servicio***');
		$this->assertEquals(2, $respuesta['resultado']);
	}
}

 ?>