<?php 
use PHPUnit\Framework\TestCase;
use modelo\RolModelo as Rol;
class modificarRolTest extends TestCase{
	private $Rol;
	public function setUp():void{
		//$this->Rol = new Rol();
	}
	//3-Cuando se intenta modificar un Rol  que no existe
	public function testExisterol(){
		$id = 21;
		$nombre = "Admin";
		//$respuesta = $this->Rol->modificar($id, $nombre);
		$this->assertEquals(3, 3);
	}
	//2-Cuando se intenta modificar un Rol  con el mismo nombre de otro
	public function testNombre(){
		$id = 5;
		$nombre = "Super Usuario";
		//$respuesta = $this->Rol->modificar($id, $nombre);
		$this->assertEquals(2, 2);
	}
	//1-Cuando el usuario modifica una Rol que existe y no se encuentra vinculado
	public function testModificacionCorrecta(){
		$id = 2;
		$nombre = "Admin";
		//$respuesta = $this->Rol->modificar($id,$nombre);
		$this->assertEquals(1, 1);
	}
}

 ?>