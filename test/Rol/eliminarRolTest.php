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
		$id = 23;
		$respuesta = $this->Rol->eliminar($id);
		$this->assertEquals(4, $respuesta['resultado']);
	}
    //3-Cuando se intenta eliminar un rol que tiene relacion con usuario
	public function testRelacionUsuario(){
		$id = 17;
		$respuesta = $this->Rol->eliminar($id);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//2-Cuando se intenta eliminar un rol que posee permisos
	public function testRelacionPermiso(){
		$id = 18;
		$respuesta = $this->Rol->eliminar($id);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una Rol que existe y no se encuentra vinculado
	public function testModificacionCorrecta(){
		$id = 20;
		$respuesta = $this->Rol->eliminar($id);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>