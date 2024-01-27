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
			$id = 32423466;
			$fecha_apertura = "02/09/2023 20:30";
			$fecha_cierre = "03/09/2023 20:05";
			$descripcion = "Censo modificado";
			$respuesta = $this->censo->modificar($id, $fecha_apertura, $fecha_cierre, $descripcion);
			$this->assertEquals(3, $respuesta['resultado']);
		}
	
		//Cuando el usuario modifica los datos del censo con valores que contiene caracteres especiales e incorrectos
		public function testExpresiones(){
			$id = "32423466";
			$fecha_apertura = "asdasd";
			$fecha_cierre = "asdsadsa";
			$descripcion = "**Censo modificado";
			$respuesta = $this->censo->modificar("32423466","asdasd","asdsadsa","++Censo modificado");
			$this->assertEquals(2, $respuesta['resultado']);
		}
		//Cuando el usuario modifica los datos correctamente
		public function testModificacionCorrecta(){
			$id = 1;
			$fecha_apertura = "03/09/2023 20:30";
			$fecha_cierre = "06/09/2023 20:06";
			$descripcion = "Censo modificado";
			$respuesta = $this->censo->modificar(1,"03/09/2023 20:30","06/09/2023 20:06","Censo modificado");
			$this->assertEquals(1, $respuesta['resultado']);
		}
}

 ?>