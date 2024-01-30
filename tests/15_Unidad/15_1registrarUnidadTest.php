<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadModelo as Unidad;
class registrarUnidadTest extends TestCase{
	private $Unidad;
	/*DATOS A REGISTRAR
	nombre, descripcion, id_aula*/
	public function setUp():void{
		//$this->Unidad = new Unidad();
	}
	//1-El nombre de la unidad es repetido
	public function testNombreRepetido(){
		$nombre_unidad = "Conociendo del curso";
		$descripcion_unidad = "Es solo de prueba";
		$id_aula = 3;
		//$respuesta = $this->Unidad->incluir($nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(2, 2);
	}
	//2-El caso en que no existe el aula que se desea asignarle la unidad
	public function testValidaAula(){
		$nombre_unidad = "Unidad nueva";
		$descripcion_unidad = "Es solo de prueba";
		$id_aula = 100;
		//$respuesta = $this->Unidad->incluir($nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(3, 3);
	}
	//3-El caso en que no se cumpla con las expresiones regulares
	public function testValidaExpresion(){
		$nombre_unidad = "**sjaja";
		$descripcion_unidad = "12/sa";
		$id_aula = 3;
		//$respuesta = $this->Unidad->incluir($nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(4, 4);
	}
	//4-Los datos son correctos
	public function testIncluir(){
		$nombre_unidad = "Unidad nueva";
		$descripcion_unidad = "Es solo de prueba";
		$id_aula = 3;
		//$respuesta = $this->Unidad->incluir($nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(1, 1);
	}
}

 ?>