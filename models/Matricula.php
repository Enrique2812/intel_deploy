<?php 
namespace Model;

use Exception;
use PDO;

class Matricula extends ActiveRecord {
    protected static $tabla = 'matricula';   
    protected static $columnasDB = ['id_alumno', 'id_aula','fecha_matricula','id_año','idmatricula','fecha_ingreso'];    
    
    public $id_alumno;
    public $id_aula;
    public $fecha_matricula;
    public $id_año;
    public $idmatricula;    
    public $fecha_ingreso;
    
    
    public function __construct($args = []) {
        $this->id_alumno = $args['id_alumno'] ?? '';
        $this->id_aula = $args['id_aula'] ?? '';
        $this->fecha_matricula = $args['fecha_matricula'] ?? '';
        $this->id_año = $args['id_año'] ?? '';
        $this->idmatricula = $args['idmatricula'] ?? '';
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? '';
    }

    
    public function crearCursos($alumnos) {

        // Prepara la consulta
        $query = "INSERT INTO matricula ( id_alumno,id_aula,id_año,fecha_ingreso) VALUES ('".$alumnos."','".$this->id_aula."','".$this->id_año."', GETDATE()) ";
        // debuguear($query);
        $resultado = self::$db->query($query);
    
        // Ejecuta la consulta y retorna el resultado
        return $resultado;  
    }
    public static function findAlumnosAlula($id){
        
        $query = "SELECT * from matricula";
        $query .= " where id_aula=".$id;

        $resultado = self::consultarSQL($query);
        // debuguear($resultado);

        return $resultado;
    }
    public static function findAula($id){
        
        $query = "SELECT * from matricula";
        $query .= " where id_alumno=".$id;

        $resultado = self::consultarSQL($query);
        // debuguear($resultado);

        return $resultado;
    }
    public static function buscarPorAlumno($idAlumno)
    {
        $idAlumno = intval($idAlumno);
    
        $query = "SELECT TOP 1 * FROM " . static::$tabla . " WHERE id_alumno = $idAlumno";
        
        $result = self::consultarSQL($query);
        
        return !empty($result) ? new static((array) $result[0]) : null;
    }

    public static function IdAulaReporte($id){
        
        $query = "SELECT * from matricula";
        $query .= " where id_alumno=".$id;

        $resultado = self::consultarSQL($query);
        // debuguear($resultado);

        return array_shift($resultado);
    }

}
