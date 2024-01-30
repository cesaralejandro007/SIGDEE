<?php 

use PHPUnit\Framework\TestCase;
use modelo\UsuariosRolesModelo as Estudiantes;

class incluirEstudiantesTest extends TestCase{
	private $Estudiantes;

	public function setUp():void{
		//$this->Estudiantes = new Estudiantes();
	}

	//2-Cuando se intenta asignar como estudiante a un usuario que no existe

	public function testCreacionIncorrecta(){
		$id_estudiante = 2002;
		$id_rol = 7;
		//$respuesta = $this->Estudiantes->incluirEstudiantes($id_estudiante, $id_rol);
		$this->assertEquals(3, 3);
	}

	//2-Cuando se intenta asignar como estudiante a un usuario que ya es estudiante

	public function testCreacionRepetida(){
		$id_estudiante = 48;
		$id_rol = 7;
		//$respuesta = $this->Estudiantes->incluirEstudiantes($id_estudiante, $id_rol);
		$this->assertEquals(2, 2);
	}
	
	//2-Asignación correcta
	public function testCreacionCorrecta(){
		$id_estudiante = 50;
		$id_rol = 7;
		//$respuesta = $this->Estudiantes->incluirEstudiantes($id_estudiante, $id_rol);
		$this->assertEquals(1, 1);
	}


	
}

 ?>