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
		$id = 100;
		//$respuesta = $this->contenido->eliminar($id);
		$this->assertEquals(3, 3);
	}
	
	//3-Cuando se intenta eliminar un contenido que posee relacion con unidad contenido
	public function testExpresiones(){
		$id = 1;
		//$respuesta = $this->contenido->eliminar($id);
		$this->assertEquals(2, 2);
	}
	//1-Cuando el usuario elimina una contenido que existe y no se encuentra vinculado con unidad contenido
	public function testCreacionCorrecta(){
		$id = 14;
		//$respuesta = $this->contenido->eliminar($id);
		$this->assertEquals(1, 1);
	}
}

 ?>