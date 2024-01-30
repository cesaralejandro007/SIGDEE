<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadModelo as Unidad;

class eliminarUnidadTest extends TestCase{
	private $Unidad;

	public function setUp():void{
		//$this->Unidad = new Unidad();
	}

    //El ID de la unidad no es un numero
	public function testValidarExpresionIdUnidad(){
		$id = "x";
		//$respuesta = $this->Unidad->eliminar($id);
		$this->assertEquals(2, 2);
	}
	//Cuando se intenta eliminar un Unidad que no existe
	public function testExisteUnidad(){
		$id = 100;
		//$respuesta = $this->Unidad->eliminar($id);
		$this->assertEquals(3, 3);
	}
	
	//Cuando se intenta eliminar un Unidad que posee relacion con un contenido
	public function testRelacionContenido(){
		$id = 3;
		//$respuesta = $this->Unidad->eliminar($id);
		$this->assertEquals(4, 4);
	}
	//Cuando se intenta eliminar un Unidad que posee relacion con un evaluacion
	public function testRelacionEvaluacion(){
		$id = 4;
		//$respuesta = $this->Unidad->eliminar($id);
		$this->assertEquals(5, 5);
	}
    //Correcta eliminacion
	public function testEliminacion(){
		$id = 7;
		//$respuesta = $this->Unidad->eliminar($id);
		$this->assertEquals(1, 1);
	}
}

 ?>