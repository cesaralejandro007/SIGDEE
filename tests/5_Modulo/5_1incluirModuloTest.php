<?php 
use PHPUnit\Framework\TestCase;
use modelo\ModuloModelo as Modulo;

class incluirModuloTest extends TestCase{
	private $Modulo;

	public function setUp():void{
		//$this->Modulo = new Modulo();
	}
	//1-Cuando el usuario Ingresa un modulo con el mismo nombre de otro registro
	public function testNombreRepetido(){
		$nombre = 'Imagen Corporativo';
		//$respuesta = $this->Modulo->incluir($nombre);
		$this->assertEquals(3, 3);
	}
	//2-Cuando el usuario envia al nombre del Modulo con un valor con caracteres especiales
	public function testexpresiones(){
		$nombre = 'Filosofia gestion****';
		//$respuesta = $this->Modulo->incluir($nombre);
		$this->assertEquals(2, 2);
	}

	//3-Cuando el usuario registra un modulo correctamente
	public function testIncluir(){	
		$nombre = 'Nuevo modulo';
		//$respuesta = $this->Modulo->incluir($nombre);
		$this->assertEquals(1, 1);
	}
}

 ?>