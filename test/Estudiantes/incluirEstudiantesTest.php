<?php 

use PHPUnit\Framework\TestCase;
use modelo\UsuariosRolesModelo as Estudiantes;

class incluirEstudiantesTest extends TestCase{
	private $Estudiantes;

	public function setUp():void{
		$this->Estudiantes = new Estudiantes();
	}

	//2-Cuando se intenta incluir un Estudiantes existe y no repetido

	public function testCreacionIncorrecta(){
		$respuesta = $this->Estudiantes->incluirEstudiantes(2002,5);
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//2-Cuando se intenta incluir un Estudiantes repetido

	public function testCreacionRepetida(){
		$respuesta = $this->Estudiantes->incluirEstudiantes(2002,5);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//2-Cuando se intenta incluir un Estudiantes que no existe
	public function testCreacionCorrecta(){
		$respuesta = $this->Estudiantes->incluirEstudiantes(2002,5);
		$this->assertEquals(3, $respuesta['resultado']);
	}


	
}

 ?>