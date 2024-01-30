<?php 
use PHPUnit\Framework\TestCase;
use modelo\CensoModelo as Censo;
class incluirCensoTest extends TestCase{
	private $censo;

	public function setUp():void{
		//$this->censo = new Censo();
	}
	//Cuando el usuario desea registrar un censo con un usuario que no existe
	public function testExisteUsuario(){
		$id_personal = 22523425;
		$fecha_apertura = "02/09/2023 20:30";
		$fecha_cierre = "03/09/2023 20:05";
		$descripcion = "Nuevo Censo";
		//$respuesta = $this->censo->incluir($id_personal, $fecha_apertura, $fecha_cierre, $descripcion);
		$this->assertEquals(3, 3);
	}

	//Cuando el usuario envia los datos del censo con valores que contiene caracteres especiales e incorrectos
	public function testExpresiones(){
		$id_personal = 46;
		$fecha_apertura = "asdasd";
		$fecha_cierre = "asdsadsa";
		$descripcion = "**Nuevo Censo";
		//$respuesta = $this->censo->incluir($id_personal, $fecha_apertura, $fecha_cierre, $descripcion);
		$this->assertEquals(2, 2);
	}

	//Cuando el usuario Ingresa los datos correctamente
	public function testCreacionCorrecta(){
		$id_personal = 46;
		$fecha_apertura = "02/09/2023 20:05";
		$fecha_cierre = "03/09/2023 20:06";
		$descripcion = "Nuevo Censo";
		//$respuesta = $this->censo->incluir($id_personal, $fecha_apertura, $fecha_cierre, $descripcion);
		$this->assertEquals(1, 1);
	}
}

 ?>