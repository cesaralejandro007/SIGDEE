<?php 
use PHPUnit\Framework\TestCase;
use modelo\DocenteModelo as Docente;

class modificarDocentesTest extends TestCase{
	private $Docente;

	public function setUp():void{
		$this->Docente = new Docente();
	}

	//1-Cuando el usuario modifica un Docente que no existe
	public function testModificacionIncorrecta(){
		$respuesta = $this->Docente->modificar(206,"28055655","cesar","vides","04120318406","cesar@gmail.com","yucatan","123345");
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta modificar un Docente con la misma cedula de otro registro
	public function testNombreCedula(){
		$respuesta = $this->Docente->modificar(43,"28055655","cesar","vides","04120318406","cesar@gmail.com","yucatan","123345");
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario intenta modificar una Docente que si existe y sin datos repetidos como la cedula
	public function testModificarCorrecta(){
		$respuesta = $this->Docente->modificar(43,"209776333","calos","vives","04120318406","vides@gmail.com","yucatan","123345");
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>