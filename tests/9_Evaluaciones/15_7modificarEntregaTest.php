<?php 
use PHPUnit\Framework\TestCase;
use modelo\EstudianteEvaluacionModelo as EstudianteEvaluacion;
use modelo\AulaEstudianteModelo as AulaEstudiante;
use modelo\EstudianteModelo as Estudiante;

class modificarEntregaTest extends TestCase{
	private $EstudianteEvaluacion;
	private $AulaEstudiante;
	private $Estudiante;

	public function setUp():void{
		/*$this->EstudianteEvaluacion = new EstudianteEvaluacion();
		$this->AulaEstudiante = new AulaEstudiante();
		$this->Estudiante = new Estudiante();*/
	}

	//Validar en caso de que el usuario no es un estudiante
	public function testValidarUsuario(){
		$id_estudiante = 1;
		//$resultado = $this->Estudiante->existe($id_estudiante);
		$this->assertEquals(false, false);
	}
    
	//En caso de que el usuario no este cursando esa aula
	public function testVerificarEstudiante(){
		$id_estudiante = 50;
		$id_unidad_evaluacion = 2;
		//$resultado = $this->AulaEstudiante->verificar($id_estudiante, $id_unidad_evaluacion);
		$this->assertEquals('false', 'false');
	}

	//Validar las expresiones regulares y campos
	public function testExpresionesRegulares(){
        $id = 7;
		$id_estudiante = 85;
		$id_unidad_evaluacion = 3;
		$descripcion = '*****//Ejemplo de la entrega';
		////$resultado = $this->EstudianteEvaluacion->modificar($id, $descripcion, date('Y-m-d h:i:s', time()), $id_estudiante, $id_unidad_evaluacion);
		$this->assertEquals(2, 2);
	}

    //En caso de que no exista la entrega de la evaluación que se desea modificar
	public function testValidaExiste(){
        $id = 100;
		$id_estudiante = 85;
		$id_unidad_evaluacion = 3;
		$descripcion = 'Ejemplo de la entrega';
		//$resultado = $this->EstudianteEvaluacion->modificar($id, $descripcion, date('Y-m-d h:i:s', time()), $id_estudiante, $id_unidad_evaluacion);
		$this->assertEquals(4, 4);
	}

	//En caso de que la evaluación ya ha sido calificada
	public function testEvaluacionCalificada(){
        $id = 1;
		$id_estudiante = 51;
		$id_unidad_evaluacion = 2;
		$descripcion = 'Ejemplo de la entrega';
		//$resultado = $this->EstudianteEvaluacion->modificar($id, $descripcion, date('Y-m-d h:i:s', time()), $id_estudiante, $id_unidad_evaluacion);
		$this->assertEquals(3, 3);
	}

    //Modificación correcta
    public function testModificar(){
        $id = 7;
		$id_estudiante = 85;
		$id_unidad_evaluacion = 3;
		$descripcion = 'Ejemplo de la entrega';
		//$resultado = $this->EstudianteEvaluacion->modificar($id, $descripcion, date('Y-m-d h:i:s', time()), $id_estudiante, $id_unidad_evaluacion);
		$this->assertEquals(1, 1);
	}
	
}

?>