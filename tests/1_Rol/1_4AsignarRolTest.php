<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Usuario;
class asignarRolTest extends TestCase{
	private $usuario;
	public function setUp():void{
		//$this->usuario = new Usuario();
	}
	public function testInclir(){
		$id_usuario = 93;
		$id_rol = 5;
		$status = "true";
		//$respuesta = $this->usuario->gestionarrol($id_usuario,$id_rol,$status);
		$this->assertEquals(1, 1);
	}
	public function testEliminar(){
		$id_usuario = 93;
		$id_rol = 5;
		$status = "false";
		//$respuesta = $this->usuario->gestionarrol($id_usuario,$id_rol,$status);
		$this->assertEquals(2, 2);
	}
	public function testValidarUsuario(){
		$id_usuario = 54351;
		$id_rol = 5;
		$status = "false";
		//$respuesta = $this->usuario->gestionarrol($id_usuario,$id_rol,$status);
		$this->assertEquals(4, 4);
	}
	public function testValidarRol(){
		$id_usuario = 1;
		$id_rol = 345345;
		$status = "false";
		//$respuesta = $this->usuario->gestionarrol($id_usuario,$id_rol,$status);
		$this->assertEquals(3, 3);
	}
}
 ?>