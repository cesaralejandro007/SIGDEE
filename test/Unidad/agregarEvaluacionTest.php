<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadEvaluacionModelo as UnidadEvaluacion;
class agregarEvaluacionTest extends TestCase{
	private $unidad_evaluacion;
	public function setUp():void{
        $this->unidad_evaluacion = new UnidadEvaluacion();
	}
    //Inserción correcta
    //id_evaluacion, id_unidad, fecha_inicio, fecha_final
	public function testAgregar(){
		$id_unidad_evaluacion = 5;
		$id_unidad = 3;
		$fecha_inicio = "2024-01-09 00:33:00";
		$fecha_fin = "2024-01-15 00:33:00"; 
		$respuesta = $this->unidad_evaluacion->incluir($id_unidad_evaluacion, $id_unidad, $fecha_inicio, $fecha_fin);
		$this->assertEquals(1, $respuesta['resultado']);
	}
    //Enviando un evaluacion que no existe
	public function testValidarEvaluacion(){
		$id_unidad_evaluacion = 100;
		$id_unidad = 3;
		$fecha_inicio = "2024-01-09 00:33:00";
		$fecha_fin = "2024-01-15 00:33:00"; 
        $respuesta = $this->unidad_evaluacion->incluir($id_unidad_evaluacion, $id_unidad, $fecha_inicio, $fecha_fin);
		$this->assertEquals(2, $respuesta['resultado']);
	}
    //Enviando una unidad que no existe
	public function testValidarUnidad(){
		$id_unidad_evaluacion = 5;
		$id_unidad = 100;
		$fecha_inicio = "2024-01-09 00:33:00";
		$fecha_fin = "2024-01-15 00:33:00"; 
		$respuesta = $this->unidad_evaluacion->incluir($id_unidad_evaluacion, $id_unidad, $fecha_inicio, $fecha_fin);
		$this->assertEquals(3, $respuesta['resultado']);
	}
    //Enviando una fecha que de apertura anterior a la actual
	public function testValidarFecha(){
		$id_unidad_evaluacion = 5;
		$id_unidad = 3;
		$fecha_inicio = "2023-01-09 00:33:00";
		$fecha_fin = "2024-01-15 00:33:00"; 
        $respuesta = $this->unidad_evaluacion->incluir($id_unidad_evaluacion, $id_unidad, $fecha_inicio, $fecha_fin);
		$this->assertEquals(4, $respuesta['resultado']);
	}
    //Ya existe la evaluacion en la unidad
	public function testValidarRelacion(){
		$id_unidad_evaluacion = 4;
		$id_unidad = 3;
		$fecha_inicio = "2024-01-09 00:33:00";
		$fecha_fin = "2024-01-15 00:33:00"; 
        $respuesta = $this->unidad_evaluacion->incluir($id_unidad_evaluacion, $id_unidad, $fecha_inicio, $fecha_fin);
		$this->assertEquals(5, $respuesta['resultado']);
	}
}
 ?>