<?php 
use PHPUnit\Framework\TestCase;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;

class areaEmprendimientoTest extends TestCase{
	private $opt;

	public function setUp():void{
		$this->area = new AreaEmprendimiento();
	}

	/*public function testCreacionCorrecta(){
		$respuesta = $this->area->incluir('Nuevo Servicio');
		$this->assertEquals(1, $respuesta['resultado']);
	}*/

	public function testNombreRepetido(){
		$respuesta = $this->area->incluir('Nuevo Servicio');
		$this->assertEquals(3, $respuesta['resultado']);
	}

	public function testExpresiones(){
		$respuesta = $this->area->incluir('Nuevo Servicio***');
		$this->assertEquals(2, $respuesta['resultado']);
	}
}

 ?>