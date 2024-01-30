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
		$id = 7;
		$nombre = 'otra Area mas';
		$respuesta = $this->area->modificar($id, $nombre);
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta modificar un area con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$id = 7;
		$nombre = 'Servicio';
		$respuesta = $this->area->modificar($id, $nombre);
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario intenta modificar una area con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$id = 7;
		$nombre = 'Nuevo Servicio***';
		$respuesta = $this->area->modificar($id, $nombre);
		$this->assertEquals(3, $respuesta['resultado']);
	}
}

 ?>