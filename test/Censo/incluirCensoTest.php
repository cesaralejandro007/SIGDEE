<?php 
use PHPUnit\Framework\TestCase;
use modelo\CensoModelo as Censo;

class incluirCensoTest extends TestCase{
	private $censo;

	public function setUp():void{
		$this->censo = new Censo();
	}
	//Cuando el usuario desea registrar un censo con un usuario que no existe
	public function testExisteUsuario(){
		$respuesta = $this->censo->incluir(22523425,"02/09/2023 20:30","03/09/2023 20:05","Nuevo Censo");
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//Cuando el usuario envia los datos del censo con valores que contiene caracteres especiales e incorrectos
	public function testExpresiones(){
		$respuesta = $this->censo->incluir(1,"asdasd","asdsadsa","**Nuevo Censo");
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//Cuando el usuario Ingresa los datos correctamente
	public function testCreacionCorrecta(){
		$respuesta = $this->censo->incluir(1,"02/09/2023 20:05","03/09/2023 20:06","Nuevo Censo");
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>