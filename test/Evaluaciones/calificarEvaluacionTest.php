<?php 
use PHPUnit\Framework\TestCase;
use modelo\EstudianteEvaluacionModelo as EstudianteEvaluacion;

class calificarEvaluacionTest extends TestCase{
	private $EstudianteEvaluacion;

	public function setUp():void{
		$this->EstudianteEvaluacion = new EstudianteEvaluacion();
	}

	//1-Validar en caso de que el id_estudiante_evaluacion no exista
	public function testValidarIdEstudianteEvaluacion(){
		$id_estudiante_evaluacion = 30;
		$calificacion = 15;
		$resultado = $this->EstudianteEvaluacion->calificar($id_estudiante_evaluacion, $calificacion);
		$this->assertEquals(3, $resultado['resultado']);
	}

	//2-Calificar exitosamente
	public function testCalificarCorrectamente(){
		$id_estudiante_evaluacion = 41;
		$calificacion = 15;
		$resultado = $this->EstudianteEvaluacion->calificar($id_estudiante_evaluacion, $calificacion);
		$this->assertEquals(1, $resultado['resultado']);
	}
	
}

?>