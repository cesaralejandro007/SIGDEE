<?php 
use PHPUnit\Framework\TestCase;
use modelo\ModuloModelo as Modulo;

class modificarModuloTest extends TestCase{
	private $Modulo;

	public function setUp():void{
		$this->Modulo = new Modulo();
	}

	//1-Cuando el usuario desea modificar un Modulo con el mismo nombre de otra que ya existe
	public function testNombreRepetido(){
		$id = 14;
		$nombre = 'Filosofía de Gestión';
		$respuesta = $this->Modulo->modificar($id,$nombre);
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//2-Cuando el usuario modificar un Modulo correctamente
	public function testIncluir(){
		$id = 11;
		$nombre = 'Modulo modificado';
		$respuesta = $this->Modulo->modificar($id,$nombre);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>