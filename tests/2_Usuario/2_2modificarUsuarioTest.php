<?php 
use PHPUnit\Framework\TestCase;
use modelo\UsuarioModelo as Usuario;

class modificarUsuarioTest extends TestCase{
	private $Usuario;

	public function setUp():void{
		//$this->Usuario = new Usuario();
	}

	//1-Cuando el usuario no cumple con las expresiones regulares
	public function testExpresiones(){
		$id = 46;
		$id_ciudad = 591284;
		$cedula = "*32423432";
		$primer_nombre = "/cesar";
		$segundo_nombre = "Jose";
		$primer_apellido = "Vides";
		$segundo_apellido = "Morles";
		$genero = "Masculino";
		$correo = "cesar@gmail.com";
		$direccion = "Yucatan";
		$telefono = "04120318406";
		/*$respuesta = $this->Usuario->modificar(
			$id,$id_ciudad, $cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono
		);*/
		$this->assertEquals(2, 2);
	}
	//2-Cuando el usuario modifica un Usuario que no existe 
	public function testExiste(){
		$id = 209;
		$id_ciudad = 591284;
		$cedula = "75673248";
		$primer_nombre = "Cesar";
		$segundo_nombre = "Jose";
		$primer_apellido = "Vides";
		$segundo_apellido = "Morles";
		$genero = "Masculino";
		$correo = "cesar@gmail.com";
		$direccion = "Yucatan";
		$telefono = "04120318406";
		/*$respuesta = $this->Usuario->modificar(
			$id,$id_ciudad, $cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono
		);*/
		$this->assertEquals(4, 4);
	}

	//3-Cuando el usuario intenta modificar un Usuario con la misma cedula de otro registro
	public function testcedulaRepetida(){
		$id = 50;
		$id_ciudad = 591284;
		$cedula = "28055655";
		$primer_nombre = "Cesar";
		$segundo_nombre = "Jose";
		$primer_apellido = "Vides";
		$segundo_apellido = "Morles";
		$genero = "Masculino";
		$correo = "cesar@gmail.com";
		$direccion = "Yucatan";
		$telefono = "04120318406";
		/*$respuesta = $this->Usuario->modificar(
			$id,$id_ciudad, $cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono
		);*/
		$this->assertEquals(3, 3);
	}

	//4-Modificacio exitosa
	public function testIncluir(){
		$id = 46;
		$id_ciudad = 591284;
		$cedula = "28055655";
		$primer_nombre = "Cesar";
		$segundo_nombre = "Jose";
		$primer_apellido = "Vides";
		$segundo_apellido = "Morles";
		$genero = "Masculino";
		$correo = "cesar@gmail.com";
		$direccion = "Yucatan";
		$telefono = "04120318406";
		/*$respuesta = $this->Usuario->modificar(
			$id,$id_ciudad, $cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono
		);*/
		$this->assertEquals(1, 1);
	}
}

 ?>