<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadModelo as Unidad;

class incluirUnidadTest extends TestCase{
	private $Unidad;

	public function setUp():void{
		$this->Unidad = new Unidad();
	}
	//1-Cuando el usuario Ingresa un Unidad con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$respuesta = $this->Unidad->incluir('Nuevo');
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//2-Cuando el usuario envia al nombre del Unidad con un valor con caracteres especiales
	public function testexpresiones(){
		$respuesta = $this->Unidad->incluir('Filosofia1');
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//3-Cuando el usuario registra un Unidad correctamente
	public function testIncluir(){
		$respuesta = $this->Unidad->incluir('Filosofia');
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>