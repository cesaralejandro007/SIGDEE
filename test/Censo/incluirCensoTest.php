<?php 
use PHPUnit\Framework\TestCase;
use modelo\CensoModelo as Censo;

class incluirCensoTest extends TestCase{
	private $censo;

	public function setUp():void{
		$this->censo = new Censo();
	}

	//1-Cuando el usuario Ingresa los datos correctamente
	public function testCreacionCorrecta(){
		$respuesta = $this->censo->incluir(1,"02/09/2023 20:05","03/09/2023 20:06","Nuevo Censoss");
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario desea registrar un censo con un usuario que no existe
	public function testExisteUsuario(){
		$respuesta = $this->censo->incluir(22523425,"02/09/2023 20:30","03/09/2023 20:05","Nuevo");
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//3-Cuando el usuario envia los datos del censo con valores que contiene caracteres especiales e incorrectos
	public function testExpresiones(){
		$respuesta = $this->censo->incluir(1,"asdasd","asdsadsa","Nuevo Cenas");
		$this->assertEquals(2, $respuesta['resultado']);
	}
}

 ?>