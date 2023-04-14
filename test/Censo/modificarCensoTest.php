<?php 
use PHPUnit\Framework\TestCase;
use modelo\CensoModelo as Censo;

class modificarCensoTest extends TestCase{
	private $censo;

	public function setUp():void{
		$this->censo = new Censo();
	}

	//1-Cuando el usuario modifica los datos del censo correctamente
	public function testCreacionCorrecta(){
		$respuesta = $this->censo->modificar(45,"04-03-2023 21:43","05-03-2023 21:43","Nuevo Censo");
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario desea registrar un censo con la fecha de apertura mayor que la fecha de cierre
	// o menor que la fecha actual
	public function testNombreRepetido(){
		$respuesta = $this->censo->modificar(45,"05-03-2023 21:43","04-03-2023 21:43","Nuevo Censo");
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//3-Cuando el usuario intenta modificar la descripción del censo con un valor que contiene caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->censo->modificar(93,"04-03-2023 21:43","05-03-2023 21:43","Nuevo Censo***");
		$this->assertEquals(2, $respuesta['resultado']);
	}
}

 ?>