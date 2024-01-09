<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadContenidoModelo as UnidadContenido;
class agregarContenidoTest extends TestCase{
	private $unidad_contenido;

	public function setUp():void{
        $this->unidad_contenido = new UnidadContenido();
	}
	public function testAgregar(){
        $this->unidad_contenido->set_id_unidad(3);
        $this->unidad_contenido->set_id_contenido(8);

		$respuesta = $this->unidad_contenido->incluir();
		$this->assertEquals(1, $respuesta['resultado']);
	}

    //Enviando un contenido que no existe
	public function testValidarContenido(){
        $this->unidad_contenido->set_id_unidad(3);
        $this->unidad_contenido->set_id_contenido(100);

		$respuesta = $this->unidad_contenido->incluir();
		$this->assertEquals(2, $respuesta['resultado']);
	}

    //Enviando una unidad que no existe
	public function testValidarUnidad(){
        $this->unidad_contenido->set_id_unidad(100);
        $this->unidad_contenido->set_id_contenido(8);

		$respuesta = $this->unidad_contenido->incluir();
		$this->assertEquals(3, $respuesta['resultado']);
	}
}
 ?>