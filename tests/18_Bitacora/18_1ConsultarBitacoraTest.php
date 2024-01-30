<?php 
use PHPUnit\Framework\TestCase;
use modelo\BitacoraModelo as Bitacora;

class ConsultarBitacoraTest extends TestCase{
	private $Bitacora;

	public function setUp():void{
		//$this->Bitacora = new Bitacora();
	}

	//1-Cuando se intenta ingresar una fecha incorrecta en los campos fechas
	public function testValidacionFecha(){
		$fecha_inicio = "32423dfsgr45";
		$fecha_fin = "43534gfdgfd";
		//$respuesta = $this->Bitacora->listar_bitacora_rango($fecha_inicio,$fecha_fin);
		$this->assertEquals(2, 2);
	}
	
}

 ?>