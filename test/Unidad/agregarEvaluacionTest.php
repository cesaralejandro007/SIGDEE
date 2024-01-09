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
		$respuesta = $this->unidad_evaluacion->incluir(5, 3, '2024-01-09 00:33:00', '2024-01-15 00:33:00');
		$this->assertEquals(1, $respuesta['resultado']);
	}
    //Enviando un evaluacion que no existe
	public function testValidarEvaluacion(){
        $respuesta = $this->unidad_evaluacion->incluir(100, 3, '2024-01-09 00:33:00', '2024-01-15 00:33:00');
		$this->assertEquals(2, $respuesta['resultado']);
	}
    //Enviando una unidad que no existe
	public function testValidarUnidad(){
		$respuesta = $this->unidad_evaluacion->incluir(5, 100, '2024-01-09 00:33:00', '2024-01-15 00:33:00');
		$this->assertEquals(3, $respuesta['resultado']);
	}
    //Enviando una fecha que de apertura anterior a la actual
	public function testValidarFecha(){
        $respuesta = $this->unidad_evaluacion->incluir(5, 3, '2023-01-09 00:33:00', '2024-01-15 00:33:00');
		$this->assertEquals(4, $respuesta['resultado']);
	}
    //Ya existe la evaluacion en la unidad
	public function testValidarRelacion(){
        $respuesta = $this->unidad_evaluacion->incluir(4, 3, '2024-01-09 00:33:00', '2024-01-15 00:33:00');
		$this->assertEquals(5, $respuesta['resultado']);
	}
}
 ?>