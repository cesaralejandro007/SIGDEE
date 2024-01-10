<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Usuario;

class eliminarUsuarioTest extends TestCase{
	private $Usuario;

	public function setUp():void{
		$this->Usuario = new Usuario();
	}

	//2-Cuando se intenta eliminar un Usuario que no existe
	public function testExiste(){
		$respuesta = $this->Usuario->eliminar('13445023133',200);
		$this->assertEquals(6, $respuesta['resultado']);
	}
		//2-El Usuario no puede ser borrado, existe un vinculo con Rol.
		public function testRelacion1(){
			$respuesta = $this->Usuario->eliminar('26197135',49);
			$this->assertEquals(5, $respuesta['resultado']);
		}
		//2-El Usuario no puede ser borrado, existe un vinculo con Aspirante.
		public function testRelacion2(){
			$respuesta = $this->Usuario->eliminar('209776333',90);
			$this->assertEquals(4, $respuesta['resultado']);
		}		
		//2-El Usuario no puede ser borrado, existe un vinculo con Censo.
		public function testRelacion3(){
			$respuesta = $this->Usuario->eliminar('32423432',46);
			$this->assertEquals(3, $respuesta['resultado']);
		}	
		//2-Cuando se intenta eliminar un Usuario con un id que no es numerico
		public function testExpresion(){
			$respuesta = $this->Usuario->eliminar('2129388','**50');
			$this->assertEquals(2, $respuesta['resultado']);
		}		
	//1-Cuando el usuario elimina una Usuario de emprendimiento que existe y no se encuentra vinculado con registros de emprendimiento
	public function testCreacionCorrecta(){
		$respuesta = $this->Usuario->eliminar('28055655',97);
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>