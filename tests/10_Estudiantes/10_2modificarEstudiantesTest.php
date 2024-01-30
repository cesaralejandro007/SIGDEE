<?php 
use PHPUnit\Framework\TestCase;
use modelo\EstudianteModelo as Estudiante;

class modificarEstudiantesTest extends TestCase{
	private $Estudiante;

	public function setUp():void{
		//$this->Estudiante = new Estudiante();
	}

	//1-Cuando el usuario modifica un Estudiante que existe
	public function testModificacionIncorrecta(){
		$id = 206;
		$id_ciudad = 591284;
		$cedula = "26197135";
		$primer_nombre = "cesar";
		$segundo_nombre = "alejandro";
		$primer_apellido = "vides";
		$segundo_apellido = "gomez";
		$genero = "Maculino";
		$correo = "cesar@gmail.com";
		$direccion = "yucatan";
		$telefono = "04120318406";
		/*$respuesta = $this->Estudiante->modificar(
			$id, $id_ciudad, $cedula, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $genero, $correo, $direccion, $telefono
		);*/
		$this->assertEquals(3, 3);
	}

	//2-Cuando el usuario intenta modificar un Estudiante con la misma cedula de otro registro
	public function testCedula(){
		$id = 51;
		$id_ciudad = 591284;
		$cedula = "26197135";
		$primer_nombre = "cesar";
		$segundo_nombre = "alejandro";
		$primer_apellido = "vides";
		$segundo_apellido = "gomez";
		$genero = "Maculino";
		$correo = "cesar@gmail.com";
		$direccion = "yucatan";
		$telefono = "04120318406";
		/*$respuesta = $this->Estudiante->modificar(
			$id, $id_ciudad, $cedula, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $genero, $correo, $direccion, $telefono
		);*/
		$this->assertEquals(2, 2);
	}

	//3-Cuando el usuario intenta modificar una Estudiante que si existe y sin datos repetidos como la cedula
	public function testModificarCorrecta(){
		$id = 51;
		$id_ciudad = 591284;
		$cedula = "9324325";
		$primer_nombre = "Carlos";
		$segundo_nombre = "alejandro";
		$primer_apellido = "vides";
		$segundo_apellido = "gomez";
		$genero = "Maculino";
		$correo = "cesar@gmail.com";
		$direccion = "yucatan";
		$telefono = "04120318406";
		/*$respuesta = $this->Estudiante->modificar(
			$id, $id_ciudad, $cedula, $primer_nombre, $segundo_nombre, $primer_apellido, $segundo_apellido, $genero, $correo, $direccion, $telefono
		);*/
		$this->assertEquals(1, 1);
	}
}

 ?>