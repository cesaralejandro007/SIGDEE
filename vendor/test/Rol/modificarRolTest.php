<?php 
use PHPUnit\Framework\TestCase;
use modelo\RolModelo as Rol;

class modificarRolTest extends TestCase{
	private $rol;

	public function setUp():void{
		$this->rol = new Rol();
	}

	//1-Cuando el usuario modifica un rol que existe y con nombre diferente a los otros registros
	public function testCorrecta(){
		$respuesta = $this->rol->modificar(12, 'modificacion rol');
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta modificar un rol con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$respuesta = $this->rol->modificar(12, 'Estudiante');
		$this->assertEquals(2, $respuesta['resultado']);
	}
}

 ?>
