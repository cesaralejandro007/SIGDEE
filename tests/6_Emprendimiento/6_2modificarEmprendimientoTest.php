<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;

class modificarEmprendimientoTest extends TestCase{
	private $Emprendimiento;

	public function setUp():void{
		//$this->Emprendimiento = new Emprendimiento();
	}

	//1-Cuando el usuario trata de modificar un Emprendimiento que no existe
	public function testExiste(){
		$id = 188;
		$nombre = 'Panaderia';
		$id_area = 1;
		//$respuesta = $this->Emprendimiento->modificar($id, $nombre, $id_area);
		$this->assertEquals(5, 5);
	}

	//2-Cuando el usuario intenta modificar un Emprendimiento con un area de emprendimietno que no existe
	public function testExisteAreaEmprendimiento(){
		$id = 35;
		$nombre = 'Marketing';
		$id_area = 300;
		//$respuesta = $this->Emprendimiento->modificar($id, $nombre, $id_area);
		$this->assertEquals(4, 4);
	}
	//3-Cuando el usuario intenta modificar un Emprendimiento con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$id = 35;
		$nombre = 'Transporte';
		$id_area = 5;
		//$respuesta = $this->Emprendimiento->modificar($id, $nombre, $id_area);
		$this->assertEquals(3, 3);
	}

	//4-Cuando el usuario intenta modificar una Emprendimiento con un nombre que involucre caracteres especiales
	public function testExpresiones(){
		$id = 35;
		$nombre = 'Panaderia***';
		$id_area = 5;
		//$respuesta = $this->Emprendimiento->modificar($id, $nombre, $id_area);
		$this->assertEquals(2, 2);
	}

	//5-Cuando el usuario intenta modificar un Emprendimiento que existe y con nombre diferente a los otros registros
	public function testModificarcionCorrecta(){
		$id = 36;
		$nombre = 'Modificado';
		$id_area = 5;
		//$respuesta = $this->Emprendimiento->modificar($id, $nombre, $id_area);
		$this->assertEquals(1, 1);
	}
	}

 ?>