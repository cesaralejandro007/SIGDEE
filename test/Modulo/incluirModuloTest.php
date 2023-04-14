<?php 
use PHPUnit\Framework\TestCase;
use modelo\ModuloModelo as Modulo;

class incluirModuloTest extends TestCase{
	private $Modulo;

	public function setUp():void{
		$this->Modulo = new Modulo();
	}
	//1-Cuando el usuario Ingresa un modulo con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$respuesta = $this->Modulo->incluir('Imagen Corporativa');
		$this->assertEquals(3, $respuesta['resultado']);
	}
	//2-Cuando el usuario envia al nombre del Modulo con un valor con caracteres especiales
	public function testexpresiones(){
		$respuesta = $this->Modulo->incluir('Filosofia gestion****');
		$this->assertEquals(2, $respuesta['resultado']);
	}

	//3-Cuando el usuario registra un modulo correctamente
	public function testIncluir(){	
		$respuesta = $this->Modulo->incluir('Filosofia De Gestion');
		$this->assertEquals(1, $respuesta['resultado']);
	}
}

 ?>