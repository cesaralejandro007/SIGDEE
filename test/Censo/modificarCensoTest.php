<?php 
use PHPUnit\Framework\TestCase;
use modelo\CensoModelo as Censo;

class modificarCensoTest extends TestCase{
	private $censo;

	public function setUp():void{
		$this->censo = new Censo();
	}
		//Cuando el usuario desea modificar un censo con un usuario que no existe
		public function testExisteUsuario(){
			$respuesta = $this->censo->modificar(32423466,"02/09/2023 20:30","03/09/2023 20:05","Censo modificado");
			$this->assertEquals(3, $respuesta['resultado']);
		}
	
		//Cuando el usuario modifica los datos del censo con valores que contiene caracteres especiales e incorrectos
		public function testExpresiones(){
			$respuesta = $this->censo->modificar("32423466","asdasd","asdsadsa","++Censo modificado");
			$this->assertEquals(2, $respuesta['resultado']);
		}
		//Cuando el usuario modifica los datos correctamente
		public function testModificacionCorrecta(){
			$respuesta = $this->censo->modificar(1,"03/09/2023 20:30","06/09/2023 20:06","Censo modificado");
			$this->assertEquals(1, $respuesta['resultado']);
		}
}

 ?>