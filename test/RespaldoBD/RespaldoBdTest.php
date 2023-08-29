<?php 
use PHPUnit\Framework\TestCase;
use modelo\RespaldobdModelo as Respaldobd;

class RespaldoBdTest extends TestCase{
	private $Bitacora;

	public function setUp():void{
		$this->respaldobd = new Respaldobd();
	}

	//1-Cuando se intenta ingresar una fecha incorrecta en los campos fechas
	public function testValidacionUsuario(){
		$respuesta = $this->respaldobd->verificar_password("28055655asd");
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
}

 ?>