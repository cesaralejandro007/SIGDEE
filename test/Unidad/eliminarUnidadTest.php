<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadModelo as Unidad;

class eliminarUnidadTest extends TestCase{
	private $Unidad;

	public function setUp():void{
		$this->Unidad = new Unidad();
	}

    //El ID de la unidad no es un numero
	public function testValidarExpresionIdUnidad(){
		$respuesta = $this->Unidad->eliminar('x');
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//Cuando se intenta eliminar un Unidad que no existe
	public function testExisteUnidad(){
		$respuesta = $this->Unidad->eliminar(100);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//Cuando se intenta eliminar un Unidad que posee relacion con un contenido
	public function testRelacionContenido(){
		$respuesta = $this->Unidad->eliminar(3);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	//Cuando se intenta eliminar un Unidad que posee relacion con un evaluacion
	public function testRelacionEvaluacion(){
		$respuesta = $this->Unidad->eliminar(4);
		$this->assertEquals(5, $respuesta['resultado']);
	}
    //Correcta eliminacion
	public function testEliminacion(){
		$respuesta = $this->Unidad->eliminar(7);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>