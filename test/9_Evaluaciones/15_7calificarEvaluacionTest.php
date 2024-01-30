<?php 
use PHPUnit\Framework\TestCase;
use modelo\EstudianteEvaluacionModelo as EstudianteEvaluacion;
use modelo\AulaDocenteModelo as AulaDocente;
use modelo\DocenteModelo as Docente;

class calificarEvaluacionTest extends TestCase{
	private $EstudianteEvaluacion;
	private $AulaDocente;
	private $Docente;

	public function setUp():void{
		$this->EstudianteEvaluacion = new EstudianteEvaluacion();
		$this->AulaDocente = new AulaDocente();
		$this->Docente = new Docente();
	}

	//1-Validar en caso de que el usuario no es un docente
	public function testValidarUsuario(){
		$id_docente = 1;
		$resultado = $this->Docente->existe($id_docente);
		$this->assertEquals(false, $resultado);
	}

	//2-En caso de que el usuario no este cursando esa aula
	public function testVerificardocente(){
		$id_docente = 50;
		$id_unidad_evaluacion = 2;
		$resultado = $this->AulaDocente->verificar($id_docente, $id_unidad_evaluacion);
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