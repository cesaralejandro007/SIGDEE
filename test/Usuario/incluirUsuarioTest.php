<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Usuario;

class incluirUsuarioTest extends TestCase{
	private $Usuario;

	public function setUp():void{
		$this->Usuario = new Usuario();
	}
	//1-Cuando el usuario Ingresa los datos correctamente
	public function testCreacionCorrecta(){
		$respuesta = $this->Usuario->incluir("28204989","Luis","Quevedo","jbrcesarvides@gmail.com","yucatan","04120318406","123123");
		$this->assertEquals(1, $respuesta['resultado']);
	}


	public function testExpresionRegular(){
		$respuesta = $this->Usuario->incluir("**21341dsa","Cesar1","Vides1","jbrcesarvides@gmail.com^","yucatan","04120318406d","123123sdas");
		$this->assertEquals(2, $respuesta['resultado']);
	}

	public function testCedulaRepetido(){
		$respuesta = $this->Usuario->incluir("28055655","Cesar","Vides","jbrcesarvides@gmail.com","yucatan","04120318406","123123");
		$this->assertEquals(3, $respuesta['resultado']);
	}

}

 ?>