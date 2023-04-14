<?php 
use PHPUnit\Framework\TestCase;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;

class modificarAreaEmprendimientoTest extends TestCase{
	private $area;

	public function setUp():void{
		$this->area = new AreaEmprendimiento();
	}

	//1-Cuando el usuario modifica un area que existe y con nombre diferente a los otros registros
	public function testCreacionCorrecta(){
		$respuesta = $this->area->modificar(16, 'otra Area mas');
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta modificar un area con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$respuesta = $this->area->modificar(16, 'Servicio');
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario intenta modificar una area con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->area->modificar(16,'Nuevo Servicio***');
		$this->assertEquals(3, $respuesta['resultado']);
	}
}

 ?>