<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;

class incluirEmprendimientoTest extends TestCase{
	private $Emprendimiento;

	public function setUp():void{
		$this->Emprendimiento = new Emprendimiento();
	}

	//1-Cuando el usuario intenta incluir un Emprendimiento con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$respuesta = $this->Emprendimiento->incluir('Marketing',1);
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta incluir una Emprendimiento con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->Emprendimiento->incluir('Panaderia***',1);
		$this->assertEquals(2, $respuesta['resultado']);
	}
		//3-Cuando el usuario intenta incluir un Emprendimiento que existe y con nombre diferente a los otros registros
		public function testModificarcionCorrecta(){
			$respuesta = $this->Emprendimiento->incluir('Telematica',2);
			$this->assertEquals(1, $respuesta['resultado']);
		}
	}

 ?>