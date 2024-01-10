<?php 
use PHPUnit\Framework\TestCase;
use modelo\EstudianteEvaluacionModelo as EstudianteEvaluacion;
use modelo\AulaEstudianteModelo as AulaEstudiante;
use modelo\EstudianteModelo as Estudiante;

class calificarEvaluacionTest extends TestCase{
	private $EstudianteEvaluacion;

	public function setUp():void{
		$this->EstudianteEvaluacion = new EstudianteEvaluacion();
		$this->AulaEstudiante = new AulaEstudiante();
		$this->Estudiante = new Estudiante();
	}

	//1-Validar en caso de que el usuario no es un estudiante
	public function testValidarUsuario(){
		$id_estudiante = 1;
		$resultado = $this->Estudiante->existe($id_estudiante);
		$this->assertEquals(false, $resultado);
	}

	//2-En caso de que el usuario no este cursando esa aula
	public function testVerificarEstudiante(){
		$id_estudiante = 50;
		$id_unidad_evaluacion = 2;
		$resultado = $this->AulaEstudiante->verificar($id_estudiante, $id_unidad_evaluacion);
		$this->assertEquals('false', $resultado);
	}

	//3-Calificacion correcta
	public function testCalificarCorrectamente(){
		$id_estudiante = 85;
		$id_unidad_evaluacion = 3;
		$calificacion = 15;
		$resultado = $this->EstudianteEvaluacion->calificar($id_estudiante, $id_unidad_evaluacion, $calificacion);
		$this->assertEquals(1, $resultado['resultado']);
	}

	
}

?>