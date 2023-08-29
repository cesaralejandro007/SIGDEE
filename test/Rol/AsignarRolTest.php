<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Rol;

class asignarRolTest extends TestCase{
	private $Rol;

	public function setUp():void{
		$this->Rol = new Rol();
	}
	public function testInclir(){
		$respuesta = $this->Rol->gestionarrol(1,5,"true");
		$this->assertEquals(1, $respuesta['resultado']);
	}
	
	public function testEliminar(){
		$respuesta = $this->Rol->gestionarrol(1,5,"false");
		$this->assertEquals(2, $respuesta['resultado']);
	}

	public function testValidarUsuario(){
		$respuesta = $this->Rol->gestionarrol(54351,5,"false");
		$this->assertEquals(4, $respuesta['resultado']);
	}

	public function testValidarRol(){
		$respuesta = $this->Rol->gestionarrol(1,345345,"false");
		$this->assertEquals(3, $respuesta['resultado']);
	}
}
 ?>