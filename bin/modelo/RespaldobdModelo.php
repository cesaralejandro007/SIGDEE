<?php
namespace modelo;
use config\connect\connectDB as connectDB;
class RespaldobdModelo extends connectDB
{

    public function respaldarBD() {

        $rutaRespaldos = __DIR__ . "/../respaldos";
      
        if(!is_dir($rutaRespaldos)){
           mkdir($rutaRespaldos);
        }
      
        $dirSQL = __DIR__ . "/../respaldos/sql";
      
        if(!is_dir($dirSQL)){
          mkdir($dirSQL, 0777);
        }
      
        if(!is_writable($dirSQL)){
          echo "No se puede escribir en $dirSQL";
          exit;
        }
      
        $tablas = $this->conex->query("SHOW TABLES");
      
        foreach ($tablas as list($tabla)) {
      
        try {
            $archivo = "$dirSQL/$tabla\_respaldo_" . date('Ymd') . ".sql";

                // Generar CREATE TABLE  
            $campos = $this->conex->query("DESCRIBE $tabla");  
            $createTable = "CREATE TABLE $tabla (";
        
            while($campo = $campos->fetch()) {
                $createTable .= "`{$campo['Field']}` {$campo['Type']}";
            }
        
            $createTable .= ");"; 
        
            // Escribir archivo
            file_put_contents($archivo, $createTable);

            return true;
      
        } catch (Exception $e) {
            echo "Error en nombre de tabla: " . $e->getMessage();
            continue;
        }
      
        }
        
      }
}