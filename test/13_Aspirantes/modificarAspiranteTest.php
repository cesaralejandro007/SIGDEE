<?php 
use PHPUnit\Framework\TestCase;
use modelo\AspiranteModelo as Aspirante;

class modificarAspiranteTest extends TestCase{
	private $Aspirante;

	public function setUp():void{
		$this->Aspirante = new Aspirante();
	}

		//1-Cuando el usuario no cumple con las expresiones regulares
		public function testExpresiones(){
			$id = "sadsa";
			$id_ciudad = 591284;
			$cedula = "32423432";
			$primer_nombre = "cesar";
			$segundo_nombre = "Jose";
			$primer_apellido = "Vides";
			$segundo_apellido = "Morles";
			$genero = "Masculino";
			$correo = "cesar@gmail.com";
			$direccion = "Yucatan";
			$telefono = "04120318406";
			$respuesta = $this->Aspirante->modificar(
				$id,$id_ciudad, $cedula,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono
			);
			$this->assertEquals(2, $respuesta['resultado']);
		}
		//2-Cuando el usuario modifica un Usuario que no existe 
		public function testExiste(){
			$id = 209;
			$cedula = "75673248";
			$id_ciudad = 591284;
			$primer_nombre = "Cesar";
			$segundo_nombre = "Jose";
			$primer_apellido = "Vides";
			$segundo_apellido = "Morles";
			$genero = "Masculino";
			$correo = "cesar@gmail.com";
			$direccion = "Yucatan";
			$telefono = "04120318406";
			$respuesta = $this->Aspirante->modificar(
				$id, $cedula,$id_ciudad,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono
			);
			$this->assertEquals(4, $respuesta['resultado']);
		}
	
		//3-Cuando el usuario intenta modificar un Usuario con la misma cedula de otro registro
		public function testcedulaRepetida(){
			$id = 50;
			$cedula = "28055655";
			$id_ciudad = 591284;
			$primer_nombre = "Cesar";
			$segundo_nombre = "Jose";
			$primer_apellido = "Vides";
			$segundo_apellido = "Morles";
			$genero = "Masculino";
			$correo = "cesar@gmail.com";
			$direccion = "Yucatan";
			$telefono = "04120318406";
			$respuesta = $this->Aspirante->modificar(
				$id, $cedula,$id_ciudad,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono
			);
			$this->assertEquals(3, $respuesta['resultado']);
		}
	
		//4-Modificacio exitosa
		public function testIncluir(){
			$id = 46;
			$cedula = "28055655";
			$id_ciudad = 591284;
			$primer_nombre = "Cesar";
			$segundo_nombre = "Jose";
			$primer_apellido = "Vides";
			$segundo_apellido = "Morles";
			$genero = "Masculino";
			$correo = "cesar@gmail.com";
			$direccion = "Yucatan";
			$telefono = "04120318406";
			$respuesta = $this->Aspirante->modificar(
				$id, $cedula,$id_ciudad,$primer_nombre,$segundo_nombre,$primer_apellido,$segundo_apellido,$genero,$correo,$direccion,$telefono
			);
			$this->assertEquals(1, $respuesta['resultado']);
		}
}

 ?>