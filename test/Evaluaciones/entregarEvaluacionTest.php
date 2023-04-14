<?php 
use PHPUnit\Framework\TestCase;
use modelo\EstudianteEvaluacionModelo as EstudianteEvaluacion;
use modelo\AulaEstudianteModelo as AulaEstudiante;
use modelo\EstudianteModelo as Estudiante;

class entregarEvaluacionTest extends TestCase{
	private $EstudianteEvaluacion;
	private $AulaEstudiante;
	private $Estudiante;

	public function setUp():void{
		$this->EstudianteEvaluacion = new EstudianteEvaluacion();
		$this->AulaEstudiante = new AulaEstudiante();
		$this->Estudiante = new Estudiante();
	}

	//1-Validar en caso de que el usuario no es un estudiante
	public function testValidarUsuario(){
		$id_estudiante = 1;
		$resultado = $this->Estudiante->existe($id_estudiante);
		$this->assertEquals('false', $resultado);
	}

	//2-En caso de que el usuario no este cursando esa aula
	public function testVerificarEstudiante(){
		$id_estudiante = 1;
		$id_unidad_evaluacion = 100;
		$resultado = $this->AulaEstudiante->verificar($id_estudiante, $id_unidad_evaluacion);
		$this->assertEquals('false', $resultado);
	}

	//3-Registro exitoso
	public function testEntregaExitosa(){
		$id_estudiante = 153;
		$id_unidad_evaluacion = 4980;
		$descripcion = 'Ejemplo de la entrega';
		$nombre_archivo = 'ejemplo.png';
		$resultado = $this->EstudianteEvaluacion->incluir($id_estudiante, $id_unidad_evaluacion, date('Y-m-d h:i:s', time()), $descripcion, $nombre_archivo);
		$this->assertEquals(true, $resultado);
	}

	
}

?>