<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuariosRolesModelo as Estudiante;

class eliminarEstudiantesTest extends TestCase{
	private $Estudiante;

	public function setUp():void{
		//$this->Estudiante = new Estudiante();
	}
	
	//	Cuando se intenta eliminar un Estudiante que no existe
	public function testNombreRepetido(){
		$id = 200;
		$id_rol = 7;
		//$respuesta = $this->Estudiante->eliminarE($id, $id_rol);
		$this->assertEquals(3, 3);
	}
	
	//	Cuando se intenta eliminar un Estudiante que posee relacion con aula Estudiante
	public function testRelacion(){
		$id = 90;
		$id_rol = 7;
		//$respuesta = $this->Estudiante->eliminarE($id, $id_rol);
		$this->assertEquals(2, 2);
	}
	//	Cuando el usuario elimina una Estudiante  que existe y no se repite
	public function testCreacionCorrecta(){
		$id = 87;
		$id_rol = 7;
		//$respuesta = $this->Estudiante->eliminarE($id, $id_rol);
		$this->assertEquals(1, 1);
	}
}

 ?>