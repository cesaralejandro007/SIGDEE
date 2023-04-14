<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuariosRolesModelo as Docente;

class eliminarDocentesTest extends TestCase{
	private $Docente;

	public function setUp():void{
		$this->Docente = new Docente();
	}

	
	//2-Cuando se intenta eliminar un Docente que no existe
	public function testNombreRepetido(){
		$respuesta = $this->Docente->eliminarD(200,5);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//3-Cuando se intenta eliminar un Docente que posee relacion con aula Docente
	public function testExpresiones(){
		$respuesta = $this->Docente->eliminarD(45,5);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una Docente de emprendimiento que existe y no se encuentra vinculado con registros de emprendimiento
	public function testCreacionCorrecta(){
		$respuesta = $this->Docente->eliminarD(43,5);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>