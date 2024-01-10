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
		$respuesta = $this->Unidad->modificar('x','Conociendo el curso', 'Es solo de prueba', 3);
		$this->assertEquals(2, $respuesta['resultado']);
	}
	//2-El ID de la aula no es un numero
	public function testValidarExpresionIdAula(){
		$respuesta = $this->Unidad->modificar(3,'Conociendo el curso', 'Es solo de prueba', 'x');
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//3-La unidad a modificar no existe
	public function testExisteUnidad(){
		$respuesta = $this->Unidad->modificar(100,'Conociendo el curso', 'Es solo de prueba', 3);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	//4-El nombre de la unidad ya existe
	public function testNombreUnidad(){
		$respuesta = $this->Unidad->modificar(3,'Otro mas', 'Es solo de prueba', 3);
		$this->assertEquals(5, $respuesta['resultado']);
	}
    //5-No existe el aula
	public function testExisteAula(){
		$respuesta = $this->Unidad->modificar(3,'Conociendo el curso', 'Es solo de prueba', 100);
		$this->assertEquals(6, $respuesta['resultado']);
	}
    //6-Nombre o descripcion no cumplen expresiones regulares
	public function testExpresiones(){
		$respuesta = $this->Unidad->modificar(3,'***Otro mas', '///Es solo de prueba', 3);
		$this->assertEquals(7, $respuesta['resultado']);
	}
    //7-Datos correctos
	public function testModificar(){
		$respuesta = $this->Unidad->modificar(3,'Conociendo del curso', 'Es solo de prueba', 3);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>