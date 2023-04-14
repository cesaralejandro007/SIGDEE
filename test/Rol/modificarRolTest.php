<?php 
use PHPUnit\Framework\TestCase;
use modelo\RolModelo as Rol;

class modificarRolTest extends TestCase{
	private $Rol;

	public function setUp():void{
		$this->Rol = new Rol();
	}

	//3-Cuando se intenta modificar un Rol  que no existe

	public function testExisterol(){
		$respuesta = $this->Rol->modificar(21,"Admin");
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//2-Cuando se intenta modificar un Rol  que posee relacion con Usuario

	public function testNombre(){
		$respuesta = $this->Rol->modificar(5,"Super Usuario");
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//1-Cuando el usuario elimina una Rol que existe y no se encuentra vinculado
	public function testModificacionCorrecta(){
		$respuesta = $this->Rol->modificar(19,"Admin");
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>