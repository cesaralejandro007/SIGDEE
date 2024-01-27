<?php 
use PHPUnit\Framework\TestCase;
use modelo\UnidadModelo as Unidad;
class modificarUnidadTest extends TestCase{
	private $Unidad;
	/*DATOS A MODIFICAR
	id_unidad, nombre, descripcion, id_aula*/
	public function setUp():void{
		$this->Unidad = new Unidad();
	}
	//1-El ID de la unidad no es un numero
	public function testValidarExpresionIdUnidad(){
		$id = "x";
		$nombre_unidad = "Conociendo el curso";
		$descripcion_unidad = "Es solo de prueba";
		$id_aula = 3;
		$respuesta = $this->Unidad->modificar($id,$nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//2-El ID de la aula no es un numero
	public function testValidarExpresionIdAula(){
		$id = 3;
		$nombre_unidad = "Conociendo el curso";
		$descripcion_unidad = "Es solo de prueba";
		$id_aula = "x";
		$respuesta = $this->Unidad->modificar($id,$nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//3-La unidad a modificar no existe
	public function testExisteUnidad(){
		$id = 100;
		$nombre_unidad = "Conociendo el curso";
		$descripcion_unidad = "Es solo de prueba";
		$id_aula = 3;
		$respuesta = $this->Unidad->modificar($id,$nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	//4-El nombre de la unidad ya existe
	public function testNombreUnidad(){
		$id = 3;
		$nombre_unidad = "Otro mas";
		$descripcion_unidad = "Es solo de prueba";
		$id_aula = 3;
		$respuesta = $this->Unidad->modificar($id,$nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(5, $respuesta['resultado']);
	}
    //5-No existe el aula
	public function testExisteAula(){
		$id = 3;
		$nombre_unidad = "Conociendo el curso";
		$descripcion_unidad = "Es solo de prueba";
		$id_aula = 100;
		$respuesta = $this->Unidad->modificar($id,$nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(6, $respuesta['resultado']);
	}
    //6-Nombre o descripcion no cumplen expresiones regulares
	public function testExpresiones(){
		$id = 3;
		$nombre_unidad = "***Otro mas";
		$descripcion_unidad = "///Es solo de prueba";
		$id_aula = 3;
		$respuesta = $this->Unidad->modificar($id,$nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(7, $respuesta['resultado']);
	}
    //7-Datos correctos
	public function testModificar(){
		$id = 3;
		$nombre_unidad = "Conociendo del curso";
		$descripcion_unidad = "Es solo de prueba";
		$id_aula = 3;
		$respuesta = $this->Unidad->modificar($id,$nombre_unidad, $descripcion_unidad, $id_aula);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>