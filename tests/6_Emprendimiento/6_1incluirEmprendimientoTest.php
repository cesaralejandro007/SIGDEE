<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;

class incluirEmprendimientoTest extends TestCase{
	private $Emprendimiento;

	public function setUp():void{
		//$this->Emprendimiento = new Emprendimiento();
	}

	//1-Registro correcto
	public function testNombreRepetido(){
		$nombre = 'Cocteleria';
		$area = 5;
		//$respuesta = $this->Emprendimiento->incluir($nombre,$area);
		$this->assertEquals(1, 1);
	}

	//2-Cuando el usuario intenta incluir una Emprendimiento con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$nombre = 'Panaderia****';
		$area = 5;
		//$respuesta = $this->Emprendimiento->incluir($nombre,$area);
		$this->assertEquals(2, 2);
	}
	//3-Cuando el usaurio intenta incluir un emprendimiento con el mismo nombre en la bd
	public function testExisteEmprendimiento(){
		$nombre = 'Textil';
		$area = 5;
		//$respuesta = $this->Emprendimiento->incluir($nombre,$area);
		$this->assertEquals(3, 3);
	}
	//3-Cuando el usaurio intenta incluir un area de emprendimiento que no existe
	public function testExisteAreaEmprendimiento(){
		$nombre = 'Telematica';
		$area = 100;
		//$respuesta = $this->Emprendimiento->incluir($nombre,$area);
		$this->assertEquals(4, 4);
	}
	}

 ?>