<?php 
use PHPUnit\Framework\TestCase;
use modelo\ContenidoModelo as Contenido;

class eliminarContenidoTest extends TestCase{
	private $contenido;

	public function setUp():void{
		$this->contenido = new Contenido();
	}

	
	//2-Cuando se intenta eliminar un contenido que no existe
	public function testNombreRepetido(){
		$respuesta = $this->contenido->eliminar(100);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	
	//3-Cuando se intenta eliminar un contenido que posee relacion con unidad contenido
	public function testExpresiones(){
		$respuesta = $this->contenido->eliminar(1);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//1-Cuando el usuario elimina una contenido que existe y no se encuentra vinculado con unidad contenido
	public function testCreacionCorrecta(){
		$respuesta = $this->contenido->eliminar(14);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>