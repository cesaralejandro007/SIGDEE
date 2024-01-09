<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class UnidadContenidoModelo extends connectDB{
	private $id; 
	private $id_unidad;
	private $id_contenido;

	public function set_id($valor){
		$this->id = $valor;
	}
	public function set_id_unidad($valor){
		$this->id_unidad = $valor;
	}
	public function set_id_contenido($valor){
		$this->id_contenido = $valor;
	}

	public function get_id(){
		return $this->id;
	}
	public function get_id_unidad(){
		return $this->id_unidad;
	}
	public function get_id_contenido(){
		return $this->id_contenido;
	}
	
	
    public function incluir()
    {
        $existecontenido = $this->validarcontenido($this->id_contenido);
        $existeunidad = $this->validarunidad($this->id_unidad);
        if ($existecontenido == false) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "No existe el contenido";
        }else if($existeunidad == false){
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "No existe la unidad";
        }else{
                try {

                    $sql = "INSERT INTO unidad_contenido(id_unidad, id_contenido)
                    VALUES(?, ?)";        

                    $values = [$this->id_unidad, $this->id_contenido];

                    $stmt = $this->conex->prepare($sql); 

                    $stmt->execute($values);

                    $respuesta["resultado"]=1;
                    $respuesta["mensaje"]="";
                } catch (Exception $e) {
                    $respuesta['resultado'] = 0;
                    $respuesta['mensaje'] = $e->getMessage();
                }
            
        }
        return $respuesta;
    }


	public function validarcontenido($id)
    {
        try {

            $sql = "SELECT * FROM contenido WHERE id = ?";  

            $values = [$id];

            $stmt = $this->conex->prepare($sql); 

            $stmt->execute($values);

            $fila = $stmt->rowCount();
            if ($fila > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
    public function validarunidad($id)
    {
        try {

            $sql = "SELECT * FROM unidad WHERE id = ?";  

            $values = [$id];

            $stmt = $this->conex->prepare($sql); 

            $stmt->execute($values);

            $fila = $stmt->rowCount();

            if ($fila > 0) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }


	public function limpiar(){

		try {
			$this->conex->query("DELETE from unidad_contenido 
				WHERE
				id_unidad = '$this->id_unidad'
				");
			return true;
		} catch(Exception $e) {
			return $e->getMessage();
		}
	}
	public function listar($id_unidad)
    {
        $resultado = $this->conex->prepare("SELECT c.id as id, c.nombre as nombre, c.descripcion as descripcion, c.archivo_adjunto as archivo FROM unidad as u INNER JOIN unidad_contenido as uc ON u.id=uc.id_unidad INNER JOIN contenido as c ON c.id=uc.id_contenido WHERE u.id='$id_unidad'");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }
}
?>