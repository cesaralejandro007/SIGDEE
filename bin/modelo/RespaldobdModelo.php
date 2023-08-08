<?php
namespace modelo;
use config\connect\connectDB as connectDB;
use \PDO;
class RespaldobdModelo extends connectDB
{
  public function respaldarBD() {
  
    try {

    // Desactivar foreign keys
    $this->conex->exec('SET foreign_key_checks = 0');
    // Obtener las tablas
    $tables = $this->conex->query('SHOW TABLES')->fetchAll(PDO::FETCH_COLUMN);

    // Abrir archivo de respaldo
      $retornar = '';
    // Recorrer tablas
    foreach ($tables as $table) {

      // Obtener estructura de la tabla
      $stmt = $this->conex->query("SHOW CREATE TABLE $table");
      $createTableSQL = $stmt->fetch()[1];
      $retornar .= $createTableSQL .";\n\n";
      // Volcar estructura en archivo
      // Obtener registros
      $rows = $this->conex->query("SELECT * FROM $table");

      // Recorrer e insertar registros
      while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
        
        $columns = implode(", ", array_keys($row));
        $values = implode(", ", array_values($row));
      
        $insertSQL = "INSERT INTO $table ($columns) VALUES ($values);\n";
        $retornar .= $insertSQL;
      }
      // Salto de línea entre tablas
      $retornar .= "\n\n";
    }
    // Activar foreign keys
    $this->conex->exec('SET foreign_key_checks = 1');
    
     } catch (PDOException $e) {
    
      echo "Error generating backup: " . $e->getMessage();
      return false;
    
    }

    return $retornar;
  }

}