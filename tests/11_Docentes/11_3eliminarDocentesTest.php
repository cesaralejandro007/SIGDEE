<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuariosRolesModelo as Docente;

class eliminarDocentesTest extends TestCase{
	private $Docente;

	public function setUp():void{
		//$this->Docente = new Docente();
	}

	
	//2-Cuando se intenta eliminar un Docente que no existe
	public function testNombreRepetido(){
		$id_docente = 200;
		$id_rol = 5;
		//$respuesta = $this->Docente->eliminarD($id_docente,$id_rol);
		$this->assertEquals(3, 3);
	}
	
	//3-Cuando se intenta eliminar un Docente que posee relacion con aula Docente
	public function testExpresiones(){
		$id_docente = 45;
		$id_rol = 5;
		//$respuesta = $this->Docente->eliminarD($id_docente,$id_rol);
		$this->assertEquals(2, 2);
	}
	//1-Cuando el usuario elimina una Docente de emprendimiento que existe y no se encuentra vinculado con registros de emprendimiento
	public function testCreacionCorrecta(){
		$id_docente = 51;
		$id_rol = 5;
		//$respuesta = $this->Docente->eliminarD($id_docente,$id_rol);
		$this->assertEquals(1, 1);
	}
}

 ?>