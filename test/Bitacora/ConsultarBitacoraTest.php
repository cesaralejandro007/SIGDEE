<?php 
use PHPUnit\Framework\TestCase;
use modelo\BitacoraModelo as Bitacora;

class ConsultarBitacoraTest extends TestCase{
	private $Bitacora;

	public function setUp():void{
		$this->Bitacora = new Bitacora();
	}

	//1-Cuando se intenta ingresar una fecha incorrecta en los campos fechas
	public function testValidacionFecha(){
		$respuesta = $this->Bitacora->listar_bitacora_rango("32423dfsgr45","43534gfdgfd");
		$this->assertEquals(2, $respuesta['resultado']);
	}
	
}

 ?>