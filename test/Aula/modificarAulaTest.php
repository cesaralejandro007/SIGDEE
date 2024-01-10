<?php 
use PHPUnit\Framework\TestCase;
use modelo\AulaModelo as Aula;
use modelo\AulaEstudianteModelo as AulaEstudiante;
use modelo\AulaDocenteModelo as AulaDocente;
use modelo\EmprendimientoModelo as Emprendimiento;
use modelo\ModuloModelo as Modulo;
use modelo\EmprendimientoModuloModelo as EmprendimientoModulo;
use modelo\DocenteModelo as Docente;
use modelo\EstudianteModelo as Estudiante;
use modelo\UsuariosRolesModelo as UsuariosRoles;
use modelo\UsuarioModelo as Usuario;

class modificarAulaTest extends TestCase{
	private $aula;
	private $aula_estudiante;
	private $modulo_e;
	private $emprendimiento;
	private $emprendimiento_modulo;
	private $docente;
	private $aula_docente;
	private $estudiante;
	private $usuario;
	private $modulo = 'Aula';

	public function setUp():void{
		$this->aula = new Aula();
		$this->aula_estudiante = new AulaEstudiante();
		$this->modulo_e = new Modulo();
		$this->emprendimiento = new Emprendimiento();
		$this->emprendimiento_modulo = new EmprendimientoModulo();
		$this->docente = new Docente();
		$this->aula_docente = new AulaDocente();
		$this->estudiante = new Estudiante();
		$this->usuario = new Usuario();
		$this->usuario_rol = new UsuariosRoles();
		$this->modulo = 'Aula';
	}

	//1-Cuando no hay estudiantes en la lista
	public function testEstudiantesVacio(){
		$respuesta = [];
		$id_estudiantes = [];
		if($id_estudiantes== null){
			$respuesta = [
				'estatus' => '3',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'Debe asignar estudiantes al aula'
			];
		}
		$this->assertEquals(3, $respuesta['estatus']);
	}

	//2-Cuando se supera los 30 estudiantes en el aula
	public function testSuperaMaximoEstudiantes(){
		$respuesta = [];
		$estudiantes = [124, 145, 2, 10];
		$cantidad_estudiantes = count($estudiantes);
		if($cantidad_estudiantes > 3){
			$respuesta = [
				'estatus' => '0',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'El limite de estudiante es de 30'
			];
		}
		$this->assertEquals(0, $respuesta['estatus']);
	}
	//3-No se encuentra los usuarios con el id de los estudiantes indicados
	public function testIdsEstudiantes(){
		$respuesta = [];
		$id_estudiantes = [11, 15];
		$encontrado = true;
		foreach ($id_estudiantes as $id_estudiante) {
			$id_estudiante = $this->usuario->buscar_id($id_estudiante);
			if($id_estudiante == 0){
				$encontrado = false;
			}
		}
		if($encontrado== false){
			$respuesta = [
				'estatus' => '4',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'El usuario no existe'
			];
		}
		$this->assertEquals(4, $respuesta['estatus']);
	}

	//4-No se encuentra el id del docente indicado
	public function testIdDocente(){
		$respuesta = [];
		$id_docente = 100;
		$validar_docente = $this->docente->buscar_docente($id_docente);   
		if($validar_docente== 0 || empty($id_docente)){
			$respuesta = [
				'estatus' => '5',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'Se debe elegir un docente que exista'
			];
		}
		$this->assertEquals(5, $respuesta['estatus']);
	}

	//5-Recibe vacio el nombre del aula
	public function testNombreAula(){
		$respuesta = [];
		$nombre = '';
		if(empty($nombre)){
			$respuesta = [
				'estatus' => '5',
				'icon' => 'info',
				'title' => $this->modulo,
				'message' => 'Debe identificar el nombre del aula'
			];
		}
		$this->assertEquals(5, $respuesta['estatus']);
	}

	//6-Recibe el nombre del aula con mas de 40 caracteres
	public function testMaximoNombre(){
		$respuesta = [];
		$nombre = 'Nuevo nombre del aula para la modificacion o inclusion';
		$id = 8;
		$id_estudiantes = [144,148];
		$id_docente = 45;
		$id_aula_docente = 6;

		$response = $this->aula->modificar($nombre, $id);
		if ($response['resultado']==1) {
			$this->aula_docente->modificar($id_docente, $id_aula_docente);
			$this->aula_estudiante->limpiar($id);
			foreach ($id_estudiantes as $id_estudiante) {
				$this->aula_estudiante->incluir($id, $id_estudiante);
			}
			$respuesta = [
				'estatus' => '1',
				'icon' => 'success',
				'title' => $this->modulo,
				'message' => $response['mensaje']
			];
		} else {
			$respuesta = [
				'estatus' => '0',
				'icon' => 'error',
				'title' => $this->modulo,
				'message' => $response['mensaje']
			];
		}
		$this->assertEquals(0, $respuesta['estatus']);
	}

	//7-Recibe id de un aula que no existe
	public function testIdAula(){
		$respuesta = [];
		$nombre = 'Otra aula';
		$id = 100;
		$id_estudiantes = [144,148];
		$id_docente = 45;
		$id_aula_docente = 6;

		$response = $this->aula->modificar($nombre, $id);
		if ($response['resultado']==1) {
			$this->aula_docente->modificar($id_docente, $id_aula_docente);
			$this->aula_estudiante->limpiar($id);
			foreach ($id_estudiantes as $id_estudiante) {
				$this->aula_estudiante->incluir($id, $id_estudiante);
			}
			$respuesta = [
				'estatus' => '1',
				'icon' => 'success',
				'title' => $this->modulo,
				'message' => $response['mensaje']
			];
		} else {
			$respuesta = [
				'estatus' => '0',
				'icon' => 'error',
				'title' => $this->modulo,
				'message' => $response['mensaje']
			];
		}
		$this->assertEquals(0, $respuesta['estatus']);
	}

	//8-Recibe el mismo nombre de un aula que ya se encuentra registrada
	public function testNombreRepetido(){
		$respuesta = [];
		$nombre = 'fun-ima01';
		$id = 7;
		$id_estudiantes = [144,148];
		$id_docente = 45;
		$id_aula_docente = 6;

		$response = $this->aula->modificar($nombre, $id);
		if ($response['resultado']==1) {
			$this->aula_docente->modificar($id_docente, $id_aula_docente);
			$this->aula_estudiante->limpiar($id);
			foreach ($id_estudiantes as $id_estudiante) {
				$this->aula_estudiante->incluir($id, $id_estudiante);
			}
			$respuesta = [
				'estatus' => '1',
				'icon' => 'success',
				'title' => $this->modulo,
				'message' => $response['mensaje']
			];
		} else {
			$respuesta = [
				'estatus' => '0',
				'icon' => 'error',
				'title' => $this->modulo,
				'message' => $response['mensaje']
			];
		}
		$this->assertEquals(0, $respuesta['estatus']);
	}

	//9-Modificacion exitosa
	public function testModificacionCorrecto(){
		$respuesta = [];
		$nombre = 'Nuevo nombre';
		$id = 10;
		$id_estudiantes = [51];
		$id_docente = 79;
		$id_aula_docente = 9;

		$response = $this->aula->modificar($nombre, $id);
		if ($response['resultado']==1) {
			$this->aula_docente->modificar($id_docente, $id_aula_docente);
			$this->aula_estudiante->limpiar($id);
			foreach ($id_estudiantes as $id_estudiante) {
				$this->aula_estudiante->incluir($id, $id_estudiante);
			}
			$respuesta = [
				'estatus' => '1',
				'icon' => 'success',
				'title' => $this->modulo,
				'message' => $response['mensaje']
			];
		} else {
			$respuesta = [
				'estatus' => '0',
				'icon' => 'error',
				'title' => $this->modulo,
				'message' => $response['mensaje']
			];
		}
		$this->assertEquals(1, $respuesta['estatus']);
	}

}

?>