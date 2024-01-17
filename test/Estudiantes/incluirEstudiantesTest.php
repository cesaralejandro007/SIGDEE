<?php 

use PHPUnit\Framework\TestCase;
use modelo\UsuariosRolesModelo as Estudiantes;

class incluirEstudiantesTest extends TestCase{
	private $Estudiantes;

	public function setUp():void{
		$this->Estudiantes = new Estudiantes();
	}

	//2-Cuando se intenta asignar como estudiante a un usuario que no existe

	public function testCreacionIncorrecta(){
		$respuesta = $this->Estudiantes->incluirEstudiantes(2002,5);
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//2-Cuando se intenta asignar como estudiante a un usuario que ya es estudiante

	public function testCreacionRepetida(){
		$respuesta = $this->Estudiantes->incluirEstudiantes(51,5);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	
	//2-Asignación correcta
	public function testCreacionCorrecta(){
		$respuesta = $this->Estudiantes->incluirEstudiantes(79,5);
		$this->assertEquals(1, $respuesta['resultado']);
	}


	
}

 ?>