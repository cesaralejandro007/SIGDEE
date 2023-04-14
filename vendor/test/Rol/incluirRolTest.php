<?php 
use PHPUnit\Framework\TestCase;
use modelo\RolModelo as Rol;

class incluirRolTest extends TestCase{
	private $rol;

	public function setUp():void{
		$this->rol = new Rol();
	}

	//1-Cuando el usuario Ingresa los datos correctamente
	public function testCreacionCorrecta(){
		$respuesta = $this->rol->incluir('Mi otro rol');
		$this->assertEquals(1, $respuesta['resultado']);
	}

	//2-Cuando el usuario desea registrar un rol con el mismo nombre de otro que ya existe
	public function testNombreRepetido(){
		$respuesta = $this->rol->incluir('Administrador');
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//3-Cuando el usuario envia al nombre del area un valor con caracteres especiales
	public function testExpresiones(){
		$respuesta = $this->rol->incluir('**Nuevo rol***');
		$this->assertEquals(2, $respuesta['resultado']);
	}
}

 ?>