<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuariosRolesModelo as Estudiante;

class eliminarEstudiantesTest extends TestCase{
	private $Estudiante;

	public function setUp():void{
		$this->Estudiante = new Estudiante();
	}
	
	//2-Cuando se intenta eliminar un Estudiante que no existe
	public function testNombreRepetido(){
		$respuesta = $this->Estudiante->eliminarE(200,7);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//3-Cuando se intenta eliminar un Estudiante que posee relacion con aula Estudiante
	public function testRelacion(){
		$respuesta = $this->Estudiante->eliminarE(45,7);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una Estudiante  que existe y no se repite
	public function testCreacionCorrecta(){
		$respuesta = $this->Estudiante->eliminarE(43,7);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>