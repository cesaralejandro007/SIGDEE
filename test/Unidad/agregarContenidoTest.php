<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadContenidoModelo as UnidadContenido;
class agregarContenidoTest extends TestCase{
	private $unidad_contenido;

	public function setUp():void{
        $this->unidad_contenido = new UnidadContenido();
	}
	public function testAgregar(){
		$id_unidad = 3;
		$id_contenido = 8;
        $this->unidad_contenido->set_id_unidad($id_unidad);
        $this->unidad_contenido->set_id_contenido($id_contenido);

		$respuesta = $this->unidad_contenido->incluir();
		$this->assertEquals(1, $respuesta['resultado']);
	}

    //Enviando un contenido que no existe
	public function testValidarContenido(){
		$id_unidad = 3;
		$id_contenido = 100;
        $this->unidad_contenido->set_id_unidad($id_unidad);
        $this->unidad_contenido->set_id_contenido($id_contenido);

		$respuesta = $this->unidad_contenido->incluir();
		$this->assertEquals(2, $respuesta['resultado']);
	}

    //Enviando una unidad que no existe
	public function testValidarUnidad(){
		$id_unidad = 100;
		$id_contenido = 8;
        $this->unidad_contenido->set_id_unidad($id_unidad);
        $this->unidad_contenido->set_id_contenido($id_contenido);

		$respuesta = $this->unidad_contenido->incluir();
		$this->assertEquals(3, $respuesta['resultado']);
	}
}
 ?>