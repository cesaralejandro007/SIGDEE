<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Usuario;
class asignarRolTest extends TestCase{
	private $usuario;
	public function setUp():void{
		$this->usuario = new Usuario();
	}
	public function testInclir(){
		$id_usuario = 1;
		$id_usuario = 5;
		$status = "true";
		$respuesta = $this->usuario->gestionarrol($id_usuario,$id_rol,$status);
		$this->assertEquals(1, $respuesta['resultado']);
	}
	public function testEliminar(){
		$id_usuario = 1;
		$id_usuario = 5;
		$status = "false";
		$respuesta = $this->usuario->gestionarrol($id_usuario,$id_rol,$status);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	public function testValidarUsuario(){
		$id_usuario = 54351;
		$id_usuario = 5;
		$status = "false";
		$respuesta = $this->usuario->gestionarrol($id_usuario,$id_rol,$status);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	public function testValidarRol(){
		$id_usuario = 1;
		$id_usuario = 345345;
		$status = "false";
		$respuesta = $this->usuario->gestionarrol($id_usuario,$id_rol,$status);
		$this->assertEquals(3, $respuesta['resultado']);
	}
}
 ?>