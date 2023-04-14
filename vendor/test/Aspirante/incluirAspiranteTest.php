<?php 
use PHPUnit\Framework\TestCase;
use modelo\AspiranteModelo as Aspirante;

class incluirAspiranteTest extends TestCase{
	private $aspirante;

	public function setUp():void{
		$this->aspirante = new Aspirante();
	}

	//1-Cuando el usuario Ingresa los datos correctamente
	public function testCreacionCorrecta(){
		$respuesta = $this->aspirante->incluir('Nueva aspirante');
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario desea registrar un aspirante con el mismo nombre de otra que ya existe
	public function testNombreRepetido(){
		$respuesta = $this->aspirante->incluir('Otra aspirante');
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//3-Cuando el usuario envia al nombre del aspirante un valor con caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->aspirante->incluir('Nuevo Servicio***');
		$this->assertEquals(2, $respuesta['resultado']);
	}
}

 ?>