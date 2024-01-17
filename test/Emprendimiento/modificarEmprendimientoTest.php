<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;

class modificarEmprendimientoTest extends TestCase{
	private $Emprendimiento;

	public function setUp():void{
		$this->Emprendimiento = new Emprendimiento();
	}

	//1-Cuando el usuario trata de modificar un Emprendimiento que no existe
	public function testExiste(){
		$respuesta = $this->Emprendimiento->modificar(188,'Panaderia',1);
		$this->assertEquals(5, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta modificar un Emprendimiento con un area de emprendimietno que no existe
	public function testExisteAreaEmprendimiento(){
		$respuesta = $this->Emprendimiento->modificar(1,'Marketing',3);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	//3-Cuando el usuario intenta modificar un Emprendimiento con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$respuesta = $this->Emprendimiento->modificar(9,'Marketing',1);
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//4-Cuando el usuario intenta modificar una Emprendimiento con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->Emprendimiento->modificar(1,'Panaderia***',1);
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//5-Cuando el usuario intenta modificar un Emprendimiento que existe y con nombre diferente a los otros registros
	public function testModificarcionCorrecta(){
		$respuesta = $this->Emprendimiento->modificar(1,'Panaderia',1);
		$this->assertEquals(1, $respuesta['resultado']);
	}
	}

 ?>