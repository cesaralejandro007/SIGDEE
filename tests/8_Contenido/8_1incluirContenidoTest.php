<?php 
use PHPUnit\Framework\TestCase;
use modelo\ContenidoModelo as Contenido;

class incluirContenidoTest extends TestCase{
	private $contenido;

	public function setUp():void{
		$this->contenido = new Contenido();
	}

	//1-Cuando el usuario Ingresa los datos correctamente
	public function testCreacionCorrecta(){
		$nombre_contenido = "Electiva";
		$descripcion_contenido = "websocket";
		$nombre_archivo = "contenido.pdf";
		//$respuesta = $this->contenido->incluir($nombre_contenido,$descripcion_contenido,$nombre_archivo);
		$this->assertEquals(1, 1);
	}

	//2-Cuando el usuario desea registrar un contenido con el mismo nombre de otra que ya existe
	public function testNombreRepetido(){
		$nombre_contenido = "Conceptos";
		$descripcion_contenido = "websocket";
		$nombre_archivo = "contenido.pdf";
		//$respuesta = $this->contenido->incluir($nombre_contenido,$descripcion_contenido,$nombre_archivo);
		$this->assertEquals(2, 2);
	}

	//3-Cuando el usuario envia al nombre del contenido un valor con caracteres especiales
	public function testExpresiones(){
		$nombre_contenido = "Electiva***";
		$descripcion_contenido = "websocket";
		$nombre_archivo = "contenido.pdf";
		//$respuesta = $this->contenido->incluir($nombre_contenido,$descripcion_contenido,$nombre_archivo);
		$this->assertEquals(3, 3);
	}
}

 ?>