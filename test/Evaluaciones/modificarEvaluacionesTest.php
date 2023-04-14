<?php 
use PHPUnit\Framework\TestCase;
use modelo\EvaluacionModelo as Evaluacion;

class modificarEvaluacionesTest extends TestCase{
	private $Evaluacion;

	public function setUp():void{
		$this->Evaluacion = new Evaluacion();
	}

	//1-Cuando el usuario modifica una Evaluacion que no existe
	public function testExiste(){
		$respuesta = $this->Evaluacion->modificar(61, 'otra Evaluacion mas','conceptos');
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta modificar una Evaluacion con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$respuesta = $this->Evaluacion->modificar(2, 'Nueva evaluacion','conceptos');
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario intenta modificar una Evaluacion que existe
	public function testExpresiones(){
		$respuesta = $this->Evaluacion->modificar(20,'Evaluacion Modificacion','conceptos');
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>