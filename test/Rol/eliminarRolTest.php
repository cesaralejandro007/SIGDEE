<?php 
use PHPUnit\Framework\TestCase;
use modelo\RolModelo as Rol;

class eliminarRolTest extends TestCase{
	private $Rol;

	public function setUp():void{
		$this->Rol = new Rol();
	}

	//4-Cuando se intenta eliminar un Rol  que no existe

	public function testExisterol(){
		$respuesta = $this->Rol->eliminar(21);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	//3-Cuando se intenta eliminar un Rol  que posee relacion con Usuario

	public function testRelacionUsuario(){
		$respuesta = $this->Rol->eliminar(5);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//2-Cuando se intenta eliminar un Rol  que posee relacion con permisos
	public function testRelacionPermisos(){
		$respuesta = $this->Rol->eliminar(15);
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//1-Cuando el usuario elimina una Rol que existe y no se encuentra vinculado
	public function testEliminacionCorrecta(){
		$respuesta = $this->Rol->eliminar(18);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>