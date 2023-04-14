<?php
    namespace modelo;
    use config\connect\connectDB as connectDB;

class CensoModelo extends connectDB
{
    private $id;
    private $id_personal;
    private $fecha_apertura;
    private $fecha_cierre;
    private $descripcion;

    public function incluir($id_personal, $fecha_apertura, $fecha_cierre, $descripcion)
    {

        $validar_expresion = $this->validar_expresiones($descripcion,$fecha_apertura,$fecha_cierre);
        if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
        }else{
        try {
            $fi = explode(" ", $fecha_apertura);
            $fechai = $fi[0];
            $horai = $fi[1];
            $ffi = explode("/", $fechai);
            $fisql = $ffi[2] . "-" . $ffi[1] . "-" . $ffi[0] . " " . $horai;
    
            $fc = explode(" ", $fecha_cierre);
            $fechac = $fc[0];
            $horac = $fc[1];
            $ffc = explode("/", $fechac);
            $fcsql = $ffc[2] . "-" . $ffc[1] . "-" . $ffc[0] . " " . $horac;

            $this->conex->query("INSERT INTO censo(
				id_usuario, fecha_apertura, fecha_cierre, descripcion
				)
			VALUES(
				'$id_personal', '$fisql', '$fcsql', '$descripcion'

			)");
            $respuesta['resultado'] = 1;
            $respuesta['mensaje'] = "Registro exitoso";
        } catch (Exception $e) {
            $respuesta['resultado'] = 0;
            $respuesta['mensaje'] = $e->getMessage();
        }  
        }
        return $respuesta;
    }

    public function modificar($id, $fecha_apertura, $fecha_cierre, $descripcion)
    {
        $validar_expresion = $this->validar_expresiones($descripcion,$fecha_apertura,$fecha_cierre);
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 3;
            $respuesta['mensaje'] = "El Censo no Existe";
            return $respuesta;
        }else if ($validar_expresion['resultado']) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = $validar_expresion['mensaje'];
        } else{
            $fi = explode(" ", $fecha_apertura);
            $fechai = $fi[0];
            $horai = $fi[1];
            $ffi = explode("/", $fechai);
            $fisql = $ffi[2] . "-" . $ffi[1] . "-" . $ffi[0] . " " . $horai;
    
            $fc = explode(" ", $fecha_cierre);
            $fechac = $fc[0];
            $horac = $fc[1];
            $ffc = explode("/", $fechac);
            $fcsql = $ffc[2] . "-" . $ffc[1] . "-" . $ffc[0] . " " . $horac;
            try {
                $this->conex->query("UPDATE censo SET fecha_apertura= '$fisql', fecha_cierre= '$fcsql', descripcion = '$descripcion' WHERE id = '$id'");
                $respuesta['resultado'] = 1;
                $respuesta['mensaje'] = "Modificacion exitoso";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        }
        return $respuesta;
    }

    public function eliminar($id)
    {
        $this->id = $id;
        if ($this->existe($id)==false) {
            $respuesta['resultado'] = 2;
            $respuesta['mensaje'] = "El Censo no Existe";
        }else{
            try {
                $this->conex->query("DELETE from censo
						WHERE
						id = '$id'
						");
            $respuesta['resultado'] = 1;
            $respuesta['mensaje'] = "Eliminación exitosa";
            } catch (Exception $e) {
                $respuesta['resultado'] = 0;
                $respuesta['mensaje'] = $e->getMessage();
            }
        } 
        return $respuesta;
    }

    public function listar(){
        
        $resultado = $this->conex->prepare("SELECT id, fecha_apertura, fecha_cierre, descripcion FROM censo");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    public function buscar($id)
    {
        
        $resultado = $this->conex->prepare("SELECT id, fecha_apertura, fecha_cierre, descripcion FROM censo WHERE
				id = '$id'
				");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }

    private function existe($id)
    {
            
        try {
            $resultado = $this->conex->prepare("SELECT * FROM censo WHERE id='$id'");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            return false;
        }
    }

    public function consultar_fecha($fecha)
    {
        
        try {
            $resultado = $this->conex->prepare("SELECT *FROM censo WHERE '$fecha' BETWEEN fecha_apertura AND fecha_cierre;");
            $resultado->execute();
            $fila = $resultado->fetchAll();
            if ($fila) {
                return true;
            } else {
                return false;
            }

        } catch (Exception $e) {
            return false;
        }
    }
    public function cargar($fecha)
    {
        
        $resultado = $this->conex->prepare("SELECT id, descripcion, date_format(fecha_apertura, '%d-%m-%Y %H:%m:%s') as fecha_apertura, date_format(fecha_cierre, '%d-%m-%Y %H:%m:%s') as fecha_cierre FROM censo WHERE '$fecha' BETWEEN fecha_apertura AND fecha_cierre;");
        $respuestaArreglo = [];
        try {
            $resultado->execute();
            $respuestaArreglo = $resultado->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $respuestaArreglo;
    }


    public function validar_expresiones($descripcion,$fecha_apertura,$fecha_cierre){
        $er_descripcion = '/^[A-ZÁÉÍÓÚa-zñáéíóú0-9,.#%$^&*:\s]{2,200}$/';
        $er_fecha = '/^([0-9]{1,2})[\/.-]([0-9]{1,2})[\/.-]([0-9]{4})(\s)([0-9]{1,2})(((:)([0-9]{1,2}))|((:)([0-9]{1,2})(:)([0-9]{1,2})))$/';
        
        if(!empty($fecha_apertura) && !empty($fecha_cierre)){
            date_default_timezone_set('America/Caracas');
            $fi = explode(" ", $fecha_apertura);
            $fechai = $fi[0];
            $horai = $fi[1];
            $ffi = explode("/", $fechai);
            $fisql = $ffi[2] . "-" . $ffi[1] . "-" . $ffi[0] . " " . $horai;

            $fc = explode(" ", $fecha_cierre);
            $fechac = $fc[0];
            $horac = $fc[1];
            $ffc = explode("/", $fechac);
            $fcsql = $ffc[2] . "-" . $ffc[1] . "-" . $ffc[0] . " " . $horac;

            $fecha_at = strtotime(date("d-m-Y h:i:s"))-100;
            $fecha_ap = strtotime($fisql);
            $fecha_ac = strtotime($fcsql);
        }
        if(!preg_match_all($er_descripcion,$descripcion) || trim($descripcion)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Descripción de contener Solo letras de 2 a 200 caracteres, siendo la primera en mayúscula.";
        }else if(!preg_match_all($er_fecha,$fecha_apertura) || trim($fecha_apertura)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Fecha de Apertura debe ser dd/mm/yyyy hh:mm o dd-mm-yyyy hh:mm.";
        }
        else if(!preg_match_all($er_fecha,$fecha_cierre) || trim($fecha_cierre)==''){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="El campo Fecha de Cierre debe ser dd/mm/yyyy hh:mm o dd-mm-yyyy hh:mm.";
        }else if(!($fecha_ap <= $fecha_ac && $fecha_ap >= $fecha_at)){
            $respuesta["resultado"]=true;
            $respuesta["mensaje"]="Verifique la fecha de apertura";
        }else{
            $respuesta["resultado"]=false;
            $respuesta["mensaje"]="";
        }
        return $respuesta;
    }
    
}