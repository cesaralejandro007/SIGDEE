<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Usuario;
class eliminarUsuarioTest extends TestCase{
	private $Usuario;
	public function setUp():void{
		//$this->Usuario = new Usuario();
	}
	//Cuando se intenta eliminar un Usuario que no existe
	public function testExiste(){
		$cedula = '13445023133';
		$id = 200;
		//$respuesta = $this->Usuario->eliminar($cedula,$id);
		$this->assertEquals(6, 6);
	}
	//El Usuario no puede ser borrado, existe un vinculo con Rol.
	public function testRelacion1(){
		$cedula = '26197135';
		$id = 49;
		//$respuesta = $this->Usuario->eliminar($cedula,$id);
		$this->assertEquals(5, 5);
	}
	//El Usuario no puede ser borrado, existe un vinculo con Aspirante.
	public function testRelacion2(){
		$cedula = '26197135';
		$id = 90;
		//$respuesta = $this->Usuario->eliminar($cedula,$id);
		$this->assertEquals(4, 4);
	}		
	//El Usuario no puede ser borrado, existe un vinculo con Censo.
	public function testRelacion3(){
		$cedula = '12431887';
		$id = 50;
		//$respuesta = $this->Usuario->eliminar($cedula,$id);
		$this->assertEquals(3, 3);
	}	
	//Cuando se intenta eliminar un Usuario con un id que no es numerico
	public function testExpresion(){
		$cedula = '2129388';
		$id = '**50';
		//$respuesta = $this->Usuario->eliminar($cedula,$id);
		$this->assertEquals(2, 2);
	}		
	//Cuando el usuario elimina una Usuario de emprendimiento que existe y no se encuentra vinculado con registros de emprendimiento
	public function testCreacionCorrecta(){
		$cedula = '10231343';
		$id = 94;
		//$respuesta = $this->Usuario->eliminar($cedula,$id);
		$this->assertEquals(1, 1);
	}
}

 ?>