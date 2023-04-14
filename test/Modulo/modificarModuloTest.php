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
		$respuesta = $this->Modulo->modificar(14,'Filosofía de Gestión');
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//2-Cuando el usuario modificar un Modulo correctamente
	public function testIncluir(){
		$respuesta = $this->Modulo->modificar(11,'Nueva gestion');
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>