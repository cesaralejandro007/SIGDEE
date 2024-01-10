<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadModelo as Unidad;
class registrarUnidadTest extends TestCase{
	private $Unidad;
	/*DATOS A REGISTRAR
	nombre, descripcion, id_aula*/
	public function setUp():void{
		$this->Unidad = new Unidad();
	}
	//1-El nombre de la unidad es repetido
	public function testNombreRepetido(){
		$respuesta = $this->Unidad->incluir('Conociendo del curso', 'Es solo de prueba', 3);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//2-El caso en que no existe el aula que se desea asignarle la unidad
	public function testValidaAula(){
		$respuesta = $this->Unidad->incluir('Unidad nueva', 'Es solo de prueba', 100);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//3-El caso en que no se cumpla con las expresiones regulares
	public function testValidaExpresion(){
		$respuesta = $this->Unidad->incluir('**sjaja', '12/sa', 3);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	//4-Los datos son correctos
	public function testIncluir(){
		$respuesta = $this->Unidad->incluir('Unidad nueva', 'Es solo de prueba', 3);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>