<?php 
namespace Model;

use Exception;
use PDO;

class Aula_personal_curso extends ActiveRecord {
    protected static $tabla = 'aula_personal_curso';   
    protected static $columnasDB = ['id', 'id_personal', 'id_curso','estado','id_aula','id_año','fecha_ingreso'];    
    
    public $id;
    public $id_personal;
    public $id_curso;
    public $estado;
    public $id_aula;
    public $id_año;
    public $fecha_ingreso;
    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? '';
        $this->id_personal = $args['id_personal'] ?? '';
        $this->id_curso = $args['id_curso'] ?? '';
        $this->estado = $args['estado'] ?? '';
        $this->id_aula = $args['id_aula'] ?? '';
        $this->id_año = $args['id_año'] ?? '';
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? '';
    }

    
    // buscar un registro por su id 
    public static function findPersonal($id)
    {
        $query = "SELECT * FROM ".static::$tabla." where id_personal={$id}";

        $resultado = self::consultarSQL($query);

        return $resultado;
    }
    // buscar un registro por su id 
    public static function findCursoAula($id)
    {
        $query = "SELECT * FROM ".static::$tabla." where id_aula={$id}";

        $resultado = self::consultarSQL($query);

        return $resultado;
    }
}
