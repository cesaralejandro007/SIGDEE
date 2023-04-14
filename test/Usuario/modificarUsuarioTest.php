<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Usuario;

class modificarUsuarioTest extends TestCase{
	private $Usuario;

	public function setUp():void{
		$this->Usuario = new Usuario();
	}

	//1-Cuando el usuario modifica un Usuario que no existe 
	public function testExiste(){
		$respuesta = $this->Usuario->modificar(209,"75673246","cesar","vides","cesar@gmail.com","yucatan","04120318406","123345");
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta modificar un Usuario con la misma cedula de otro registro
	public function testcedulaRepetida(){
		$respuesta = $this->Usuario->modificar(50,"28055655","cesar","vides","cesar@gmail.com","yucatan","04120318406","123345");
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario intenta modificar una Usuario con un nombre que involucre caracteres especiales
	public function testIncluir(){
		$respuesta = $this->Usuario->modificar(46,"32423432","cesar","vides","cesar@gmail.com","yucatan","04120318406","123345");
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>