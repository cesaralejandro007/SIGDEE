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
		$nombre = 'Panaderia';
		$area = 1;
		$respuesta = $this->Emprendimiento->incluir($nombre,$area);
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta incluir una Emprendimiento con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$nombre = 'Panaderia****';
		$area = 1;
		$respuesta = $this->Emprendimiento->incluir($nombre,$area);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//3-Cuando el usaurio intenta incluir un emprendimiento con el mismo nombre en la bd
	public function testExisteEmprendimiento(){
		$nombre = 'Batender';
		$area = 1;
		$respuesta = $this->Emprendimiento->incluir($nombre,$area);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//3-Cuando el usaurio intenta incluir un area de emprendimiento que no existe
	public function testExisteAreaEmprendimiento(){
		$nombre = 'Telematica';
		$area = 2;
		$respuesta = $this->Emprendimiento->incluir($nombre,$area);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	}

 ?>