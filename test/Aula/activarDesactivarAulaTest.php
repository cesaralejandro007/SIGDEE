<?php 
use PHPUnit\Framework\TestCase;
use modelo\AulaModelo as Aula;

class activarDesactivarAulaTest extends TestCase{
	private $Aula;

	public function setUp():void{
		$this->Aula = new Aula();
	}
    //No existe el aula que se desea activa o desactivar
	public function testValidaExiste(){
		$id = 100;
		$status = "true";
		$respuesta = $this->Aula->actualizarstatus($id, $status);
		$this->assertEquals(0, $respuesta['resultado']);
	}
	
	public function testActivarAula(){
		$id = 10;
		$status = "true";
		$respuesta = $this->Aula->actualizarstatus($id, $status);
		$this->assertEquals(1, $respuesta['resultado']);
	}

    public function testDesactivarAula(){
		$id = 10;
		$status = "false";
		$respuesta = $this->Aula->actualizarstatus($id, $status);
		$this->assertEquals(2, $respuesta['resultado']);
	}
}
 ?>