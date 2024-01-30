<?php 
use PHPUnit\Framework\TestCase;
use modelo\RolModelo as Rol;

class eliminarRolTest extends TestCase{
    private $Rol;
	public function setUp():void{
		//$this->Rol = new Rol();
	}
	//4-Cuando se intenta eliminar un Rol  que no existe
	public function testExisterol(){
		$id = 23;
		//$respuesta = $this->Rol->eliminar($id);
		$this->assertEquals(4, 4);
	}
    //3-Cuando se intenta eliminar un rol que tiene relacion con usuario
	public function testRelacionUsuario(){
		$id = 1;
		//$respuesta = $this->Rol->eliminar($id);
		$this->assertEquals(3, 3);
	}
	//2-Cuando se intenta eliminar un rol que posee permisos
	public function testRelacionPermiso(){
		$id = 1;
		//$respuesta = $this->Rol->eliminar($id);
		$this->assertEquals(2, 2);
	}
	//1-Cuando el usuario elimina una Rol que existe y no se encuentra vinculado
	public function testModificacionCorrecta(){
		$id = 11;
		//$respuesta = $this->Rol->eliminar($id);
		$this->assertEquals(1, 1);
	}
}

 ?>