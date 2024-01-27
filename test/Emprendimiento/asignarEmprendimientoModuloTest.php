<?php 
use PHPUnit\Framework\TestCase;
use modelo\EmprendimientoModuloModelo as EmprendimientoModulo;
class asignarEmprendimientoModuloTest extends TestCase{
	private $emprendimiento_Modulo;

	public function setUp():void{
		$this->emprendimiento_Modulo = new EmprendimientoModulo();
        $this->emprendimiento= new Emprendimiento();
	}
	
	//1-Cuando se intenta asignar un  emprendimiento modulo y no existe el modulo
		public function testValidarModulo(){
		$id_modulo = 20;
		$id_emprendimiento = 1;
		$status = "true";
		$respuesta = $this->emprendimiento_Modulo->incluir($id_modulo, $id_emprendimiento, $status);
		$this->assertEquals(4, $respuesta['resultado']);
	}
	
	//2-Cuando se intenta asignar un emprendimiento modulo y no existe el emprendimiento
	 public function testValidarEmprendimiento(){
		$id_modulo = 16;
		$id_emprendimiento = 9;
		$status = "true";
		$respuesta = $this->emprendimiento_Modulo->incluir($id_modulo, $id_emprendimiento, $status);
		$this->assertEquals(5, $respuesta['resultado']);
    }
}

 ?>