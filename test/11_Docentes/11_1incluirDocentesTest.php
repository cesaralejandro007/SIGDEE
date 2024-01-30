<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuariosRolesModelo as Docente;

class incluirDocentesTest extends TestCase{
	private $Docente;

	public function setUp():void{
		$this->Docente = new Docente();
	}


	//2-Cuando se intenta incluir un Docente que no existe
	public function testCreacionIncorrecta(){
		$id_docente = 200;
		$id_rol = 5;
		$respuesta = $this->Docente->incluirDocentes($id_docente,$id_rol);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//2-Cuando se intenta incluir un Docente repetido
	public function CreacionRepetida(){
		$id_docente = 49;
		$id_rol = 5;
		$respuesta = $this->Docente->incluirDocentes($id_docente,$id_rol);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	
	//2-Cuando se intenta incluir un Docente existe y no repetido
	public function CreacionCorrecta(){
		$id_docente = 89;
		$id_rol = 5;
		$respuesta = $this->Docente->incluirDocentes($id_docente,$id_rol);
		$this->assertEquals(1, $respuesta['resultado']);
	}
	
}

 ?>