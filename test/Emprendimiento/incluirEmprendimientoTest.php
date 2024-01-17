<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;

class incluirEmprendimientoTest extends TestCase{
	private $Emprendimiento;

	public function setUp():void{
		$this->Emprendimiento = new Emprendimiento();
	}

	//1-Registro correcto
	public function testNombreRepetido(){
		$respuesta = $this->Emprendimiento->incluir('Panaderia',1);
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta incluir una Emprendimiento con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->Emprendimiento->incluir('Panaderia***',1);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//3-Cuando el usaurio intenta incluir un emprendimiento con el mismo nombre en la bd
	public function testExisteEmprendimiento(){
		$respuesta = $this->Emprendimiento->incluir('Batender',1);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//3-Cuando el usaurio intenta incluir un area de emprendimiento que no existe
	public function testExisteAreaEmprendimiento(){
		$respuesta = $this->Emprendimiento->incluir('Telematica',2);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	}

 ?>