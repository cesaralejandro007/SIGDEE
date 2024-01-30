<?php 
use PHPUnit\Framework\TestCase;
use modelo\AreaEmprendimientoModelo as AreaEmprendimiento;

class incluirAreaEmprendimientoTest extends TestCase{
	private $area;

	public function setUp():void{
		$this->area = new AreaEmprendimiento();
	}
	//1-Cuando el usuario Ingresa los datos correctamente
	public function testCreacionCorrecta(){
		$nombre = 'Otraaaa';
		$respuesta = $this->area->incluir($nombre);
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario desea registrar un area con el mismo nombre de otra que ya existe
	public function testExpresiones(){
		$nombre = '//Servicio***';
		$respuesta = $this->area->incluir($nombre);
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario envia al nombre del area un valor con caracteres especiales
	public function testNombreRepetido(){
		$nombre = 'Servicio';
		$respuesta = $this->area->incluir($nombre);
		$this->assertEquals(3, $respuesta['resultado']);
	}
}

 ?>