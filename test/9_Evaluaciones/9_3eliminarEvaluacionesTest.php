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
		$id = 200;
		$respuesta = $this->Evaluacion->eliminar($id);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//3-Cuando se intenta eliminar una evaluacion que posee relacion con registros de unidad Evaluacion
	public function testRelacion(){
		$id = 2;
		$respuesta = $this->Evaluacion->eliminar($id);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una Evaluacion que existe y no se encuentra vinculado
	public function testCreacionCorrecta(){
		$id = 6;
		$respuesta = $this->Evaluacion->eliminar($id);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>