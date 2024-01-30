<?php 
use PHPUnit\Framework\TestCase;
use modelo\LoginModelo as Login;

class LoginTest extends TestCase{
	private $Bitacora;

	public function setUp():void{
		$this->Login = new Login();
	}

	//1-Cuando el usuario inicia sesion con datos incorrectos
	public function testInicioIncorrecto(){
		$tipo = "Super Usuario";
		$usuario = "12345678";
		$clave = "123456";
		$this->Login->set_tipo($tipo);
		$this->Login->set_user($usuario);
		$this->Login->set_password($clave);
		$respuesta = $this->Login->verificarU();
		$this->assertEquals(0, $respuesta);
	}
	//2-Cuando el usuario inicia sesion correctamente
	public function testIniciarSesion(){
		$tipo = "Super Usuario";
		$usuario = "28055655";
		$clave = "123123";
		$this->Login->set_tipo($tipo);
		$this->Login->set_user($usuario);
		$this->Login->set_password($clave);
		$respuesta = $this->Login->verificarU();
		$this->assertEquals(1, $respuesta);
	}

	//3-Cuando el usuario no posee aulas asignadas
	public function testSinAulas(){
		$tipo = "Estudiante";
		$usuario = "28055651";
		$clave = "Diplomado";
		$this->Login->set_tipo($tipo);
		$this->Login->set_user($usuario);
		$this->Login->set_password($clave);
		$respuesta = $this->Login->verificarU();
		$this->assertEquals(2, $respuesta);
	}
	
}

 ?>