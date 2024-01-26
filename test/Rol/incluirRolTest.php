<?php 
use PHPUnit\Framework\TestCase;
use modelo\ModuloModelo as Modulo;	
class incluirRolTest extends TestCase{
	private $Rol;

	public function setUp():void{
		$this->Rol = new Rol();
	}
	//3-Cuando el usuario ingresa el mismo nombre de otro rol
	public function testNombreRepetido(){
		$nombre = "Administrador";
		$respuesta = $this->Rol->incluir($nombre);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//2-El nombre del rol posee caracteres especiales
	public function testExpresiones(){
		$nombre = "Admin/&%$";
		$respuesta = $this->Rol->incluir($nombre);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una Rol que existe y no se encuentra vinculado
	public function testModificacionCorrecta(){
		$nombre = "Administradores";
		$respuesta = $this->Rol->modificar($nombre);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>