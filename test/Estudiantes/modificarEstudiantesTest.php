<?php 
use PHPUnit\Framework\TestCase;
use modelo\EstudianteModelo as Estudiante;

class modificarEstudiantesTest extends TestCase{
	private $Estudiante;

	public function setUp():void{
		$this->Estudiante = new Estudiante();
	}

	//1-Cuando el usuario modifica un Estudiante que existe
	public function testModificacionIncorrecta(){
		$respuesta = $this->Estudiante->modificar(206,"28055655","cesar","vides","04120318406","cesar@gmail.com","yucatan","123345");
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta modificar un Estudiante con la misma cedula de otro registro
	public function testCedula(){
		$respuesta = $this->Estudiante->modificar(43,"28055655","cesar","vides","04120318406","cesar@gmail.com","yucatan","123345");
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario intenta modificar una Estudiante que si existe y sin datos repetidos como la cedula
	public function testModificarCorrecta(){
		$respuesta = $this->Estudiante->modificar(110,"7743123490","calos","vives","04120318406","vides@gmail.com","yucatan","123345");
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>