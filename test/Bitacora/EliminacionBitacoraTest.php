<?php 
use PHPUnit\Framework\TestCase;
use modelo\BitacoraModelo as Bitacora;

class EliminacionBitacoraTest extends TestCase{
	private $Bitacora;

	public function setUp():void{
		$this->Bitacora = new Bitacora();
	}
	//1-Cuando se intenta ingresar una fecha incorrecta en los campos fechas
	public function testValidacionFecha(){
		$fecha_inicio = "32423dfsgr45";
		$fecha_fin = "43534gfdgfd";
		$respuesta = $this->Bitacora->limpieza_bitacora("32423dfsgr45","43534gfdgfd");
		$this->assertEquals(2, $respuesta['resultado']);
	}	
}

 ?>
 