<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadContenidoModelo as UnidadContenido;

class agregarContenidoTest extends TestCase{
	private $UnidadContenido;

	public function setUp():void{
		$this->UnidadContenido = new UnidadContenido();
	}

	//1-Creacion correcta
	public function testCreacionCorrecta(){
		$this->UnidadContenido->set_id_unidad(17);
		$this->UnidadContenido->set_id_contenido(31);

		$respuesta = $this->UnidadContenido->incluir();
		$this->assertEquals(1, true);
	}

}

 ?>