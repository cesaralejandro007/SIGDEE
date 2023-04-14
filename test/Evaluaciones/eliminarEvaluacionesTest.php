<?php 
use PHPUnit\Framework\TestCase;
use modelo\EvaluacionModelo as Evaluacion;

class eliminarEvaluacionesTest extends TestCase{
	private $Evaluacion;

	public function setUp():void{
		$this->Evaluacion = new Evaluacion();
	}

	
	//2-Cuando se intenta eliminar una Evaluacion que no existe
	public function testExiste(){
		$respuesta = $this->Evaluacion->eliminar(200);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//3-Cuando se intenta eliminar una evaluacion que posee relacion con registros de unidad Evaluacion
	public function testRelacion(){
		$respuesta = $this->Evaluacion->eliminar(2);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una Evaluacion que existe y no se encuentra vinculado
	public function testCreacionCorrecta(){
		$respuesta = $this->Evaluacion->eliminar(6);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>