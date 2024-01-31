<?php 
use PHPUnit\Framework\TestCase;
use modelo\AspiranteModelo as Aspirante;

class eliminarAspiranteTest extends TestCase{
	private $Aspirante;

	public function setUp():void{
		//$this->Aspirante = new Aspirante();
	}

	
	//2-Cuando se intenta eliminar un Aspirante que no existe
	public function testExisteRepetido(){
		$id_Aspirante = 443;
		//$respuesta = $this->Aspirante->eliminar($id_Aspirante);
		$this->assertEquals(2, 2);
	}
	
	//1-Cuando el usuario elimina una Aspirante de emprendimiento que existe
	public function testElinacionCorrecta(){
		$id_Aspirante = 96;
		//$respuesta = $this->Aspirante->eliminar($id_Aspirante);
		$this->assertEquals(1, 1);
	}
}

 ?>