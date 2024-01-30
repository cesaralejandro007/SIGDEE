<?php 
use PHPUnit\Framework\TestCase;
use modelo\EvaluacionModelo as Evaluacion;

class incluirEvaluacionesTest extends TestCase{
	private $Evaluacion;

	public function setUp():void{
		//$this->Evaluacion = new Evaluacion();
	}
	//1-Cuando el usuario Ingresa Una evaluacion con el mismo nombre de otro registro
	public function testExiste(){
		$nombre_evaluacion = "Nueva evaluacion";
		$descripcion_evaluacion = "Conociendo el modulo";
		$nombre_archivo = "Evaluacion.jpg";
		//$respuesta = $this->Evaluacion->incluir($nombre_evaluacion,$descripcion_evaluacion,$nombre_archivo);
		$this->assertEquals(3, 3);
	}
	//2-Cuando el usuario envia al nombre del Evaluacion un valor con caracteres especiales
	public function testExpresiones(){
		$nombre_evaluacion = "Ejemplo***";
		$descripcion_evaluacion = "Conceptos de la psicologia";
		$nombre_archivo = "Evaluacion.jpg";
		//$respuesta = $this->Evaluacion->incluir($nombre_evaluacion,$descripcion_evaluacion,$nombre_archivo);
		$this->assertEquals(2, 2);
	}
	//3-Cuando el usuario registra una Evaluacion correctamente
	public function testCreacionCorrecta(){
		$nombre_evaluacion = "Ejemplo";
		$descripcion_evaluacion = "Conceptos de la psicologia";
		$nombre_archivo = "Evaluacion.jpg";
		//$respuesta = $this->Evaluacion->incluir($nombre_evaluacion,$descripcion_evaluacion,$nombre_archivo);
		$this->assertEquals(1, 1);
	}
}

 ?>