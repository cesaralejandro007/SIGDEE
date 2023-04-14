<?php 
use PHPUnit\Framework\TestCase;
use modelo\EvaluacionModelo as Evaluacion;

class incluirEvaluacionesTest extends TestCase{
	private $Evaluacion;

	public function setUp():void{
		$this->Evaluacion = new Evaluacion();
	}
	//1-Cuando el usuario Ingresa Una evaluacion con el mismo nombre de otro registro
	public function testExiste(){
		$respuesta = $this->Evaluacion->incluir('Nueva evaluacion','Conociendo el modulo','Evaluacion.jpg');
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//2-Cuando el usuario envia al nombre del Evaluacion un valor con caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->Evaluacion->incluir('Ejemplo***','Conceptos de la psicologia','Evaluacion.jpg');
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//3-Cuando el usuario registra una Evaluacion correctamente
	public function testCreacionCorrecta(){
		$respuesta = $this->Evaluacion->incluir('Ejemplo','Conceptos de la psicologia','Evaluacion.jpg');
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>