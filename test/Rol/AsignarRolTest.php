<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Rol;

class asignarRolTest extends TestCase{
	private $Rol;

	public function setUp():void{
		$this->Rol = new Rol();
	}
	//1-Cuando el usuario Ingresa un Rol con el mismo nombre de otro registro
	public function testInclir(){
		$respuesta = $this->Rol->gestionarrol(1,5,"true");
		$this->assertEquals(1, $respuesta['resultado']);
	}
	
	//3-Cuando el usuario registra un Rol correctamente
	public function testEliminar(){
		$respuesta = $this->Rol->gestionarrol(110,7,"false");
		$this->assertEquals(2, $respuesta['resultado']);
	}
}
 ?>