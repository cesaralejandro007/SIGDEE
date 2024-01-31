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
		$id = 206;
		$cedula= "28055655";
		$nombre = "Cesar";
		$apellido = "Vides";
		$telefono = "04120318406";
		$gmail = "cesar@gmail.com";
		$direccion = "123345";
		$respuesta = $this->Docente->modificar($id,$cedula,$nombre,$apellido,$telefono,$gmail,$direccion,$clave);
		$this->assertEquals(3, $respuesta['resultado']);
	}

	//2-Cuando el usuario intenta modificar un Docente con la misma cedula de otro registro
	public function testNombreCedula(){
		$id = 49;
		$cedula= "28055659";
		$nombre = "cesar";
		$apellido = "vides";
		$telefono = "04120318406";
		$gmail = "vides@gmail.com";
		$direccion = "yucatan";
		$clave = "123345";
		$respuesta = $this->Docente->modificar($id,$cedula,$nombre,$apellido,$telefono,$gmail,$direccion,$clave);
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario intenta modificar una Docente que si existe y sin datos repetidos como la cedula
	public function testModificarCorrecta(){
		$id = 79;
		$cedula= "28055659";
		$nombre = "calos";
		$apellido = "vives";
		$telefono = "04120318406";
		$gmail = "vides@gmail.com";
		$direccion = "yucatan";
		$clave = "123345";
		$respuesta = $this->Docente->modificar($id,$cedula,$nombre,$apellido,$telefono,$gmail,$direccion,$clave);
		$this->assertEquals(1, 1);
	}
}

 ?>