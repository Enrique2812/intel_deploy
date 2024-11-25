<?php 
namespace Model;

use Exception;
use PDO;

class Curso extends ActiveRecord {
    protected static $tabla = 'curso';   
    protected static $columnasDB = ['id', 'descripcion','abreviatura'];    
    
    public $id;
    public $descripcion;
    public $abreviatura;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->abreviatura = $args['abreviatura'] ?? '';
    }

    public function validar() {
        if (!$this->descripcion) {
            self::$errores[] = "Debes añadir una descripcion";
        }
        
        // if (!$this->abreviatura) {
        //     self::$errores[] = "Debes añadir una abreviatura";
        // }
        
        return self::$errores;
    }

    // Método para encontrar cursos asociados a un aula específica
    public static function findCursoAula($id_aula) {
        $query = "SELECT curso.* FROM curso
                  INNER JOIN aula_personal_curso ON curso.id = aula_personal_curso.id_curso
                  WHERE aula_personal_curso.id_aula = " . self::$db->quote($id_aula);
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
    



    // public function crearPermisos($pagina_id) {

    //     // Prepara la consulta
    //     $query = "INSERT INTO permiso (id_rol, id_pagina) VALUES (".$this->id.", ". $pagina_id.")";
        
    //     $resultado = self::$db->query($query);
    
    //     // Ejecuta la consulta y retorna el resultado
    //     return $resultado;  
    // }

    // // buscar un registro por su id 
    // public static function find($id)
    // {
    //     $query = "SELECT * FROM ".static::$tabla." where id={$id}";

    //     $resultado = self::consultarSQL($query);

    //     return array_shift($resultado);
    // }
    // // Eliminar todos los permisos de un rol
    // public function eliminarPermiso() {
    //     $query = "DELETE FROM permiso WHERE id_rol = ".$this->id;
    //     $resultado = self::$db->query($query);
        
    //     return $resultado;
    // }

}
