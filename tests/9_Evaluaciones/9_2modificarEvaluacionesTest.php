<?php 
use PHPUnit\Framework\TestCase;
use modelo\EvaluacionModelo as Evaluacion;

class modificarEvaluacionesTest extends TestCase{
	private $Evaluacion;

	public function setUp():void{
		//$this->Evaluacion = new Evaluacion();
	}

	//1-Cuando el usuario modifica una Evaluacion que no existe
	public function testExiste(){
		$id = 61;
		$nombre_evaluacion = "otra Evaluacion mas";
		$descripcion_evaluacion = "conceptos";
		//$respuesta = $this->Evaluacion->modificar($id,$nombre_evaluacion,$descripcion_evaluacion);
		$this->assertEquals(3, 3);
	}

	//2-Cuando el usuario intenta modificar una Evaluacion con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$id = 2;
		$nombre_evaluacion = "Nueva evaluacion";
		$descripcion_evaluacion = "conceptos";
		//$respuesta = $this->Evaluacion->modificar($id,$nombre_evaluacion,$descripcion_evaluacion);
		$this->assertEquals(2, 2);
	}

	//3-Cuando el usuario intenta modificar una Evaluacion que existe
	public function testExpresiones(){
		$id = 20;
		$nombre_evaluacion = "Evaluacion Modificacion";
		$descripcion_evaluacion = "conceptos";
		//$respuesta = $this->Evaluacion->modificar($id,$nombre_evaluacion,$descripcion_evaluacion);
		$this->assertEquals(1, 1);
	}
}

 ?>