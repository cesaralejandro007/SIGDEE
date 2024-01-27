<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModelo as Emprendimiento;
class activarDesactivarEmprendimientoTest extends TestCase{
    private $emprendimiento;

	public function setUp():void{
        $this->emprendimiento= new Emprendimiento();
	}
	
	//1-cuando el usuairo activa o desactiva un emprendimiento que no existe
		public function testValidarEmprendimientoStatus(){
		$id = 20;
		$status = "true" ;
		$respuesta = $this->emprendimiento->actualizarstatus($id,$status);
		$this->assertEquals(3, $respuesta['resultado']);
	}
}

 ?>