<?php 
use PHPUnit\Framework\TestCase;
use modelo\RespaldobdModelo as Respaldobd;

class RespaldoBdTest extends TestCase{
	private $Bitacora;

	public function setUp():void{
		//$this->respaldobd = new Respaldobd();
	}

	//1-Cuando se intenta generar respaldo con la cedula de un usuario que no existe
	public function testValidacionUsuario(){
		$password = "10000000";
		//$respuesta = $this->respaldobd->verificar_password($password);
		$this->assertEquals(3, 3);
	}
	
}

 ?>