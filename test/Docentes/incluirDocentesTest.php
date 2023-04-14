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
		$respuesta = $this->Docente->incluirDocentes(200,5);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//2-Cuando se intenta incluir un Docente repetido
		public function CreacionRepetida(){
			$respuesta = $this->Docente->incluirDocentes(90,5);
			$this->assertEquals(2, $respuesta['resultado']);
		}
	
	//2-Cuando se intenta incluir un Docente existe y no repetido
	public function CreacionCorrecta(){
		$respuesta = $this->Docente->incluirDocentes(43,5);
		$this->assertEquals(1, $respuesta['resultado']);
	}
	
}

 ?>