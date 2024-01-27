<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Usuario;

class incluirUsuarioTest extends TestCase{
	private $Usuario;

	public function setUp():void{
		$this->Usuario = new Usuario();
	}
	
	public function testCreacionCorrecta(){
		$cedula = "28204989";
		$id_ciudad = 591284;
		$primer_nombre = "Luis";
		$segundo_nombre = "Alberto";
		$primer_apellido = "Quevedo";
		$segundo_apellido = "Gomez";
		$genero = "Masculino";
		$correo = "jbrcesarvides@gmail.com";
		$direccion = "Yucatan";
		$telefono = "04120318406";
		$clave = "123123";
		$respuesta = $this->Usuario->incluir(
			$cedula,$id_ciudad,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono,$clave
		);
		$this->assertEquals(1, $respuesta['resultado']);
	}

	public function testExpresionRegular(){
		$cedula = "**21341dsa";
		$id_ciudad = 591284;
		$primer_nombre = "Luis//";
		$segundo_nombre = "Alberto";
		$primer_apellido = "Quevedo";
		$segundo_apellido = "Gomez";
		$genero = "Masculino";
		$correo = "jbrcesarvides@gmail.com";
		$direccion = "Yucatan";
		$telefono = "04120318406";
		$clave = "123123";
		$respuesta = $this->Usuario->incluir(
			$cedula,$id_ciudad,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono,$clave
		);
		$this->assertEquals(2, $respuesta['resultado']);
	}

	public function testCedulaRepetido(){
		$cedula = "28055655";
		$id_ciudad = 591284;
		$primer_nombre = "Luis//";
		$segundo_nombre = "Alberto";
		$primer_apellido = "Quevedo";
		$segundo_apellido = "Gomez";
		$genero = "Masculino";
		$correo = "jbrcesarvides@gmail.com";
		$direccion = "Yucatan";
		$telefono = "04120318406";
		$clave = "123123";
		$respuesta = $this->Usuario->incluir(
			$cedula,$id_ciudad,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono,$clave
		);
		$this->assertEquals(3, $respuesta['resultado']);
	}

}

 ?>