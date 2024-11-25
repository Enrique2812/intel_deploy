<?php 
namespace Model;

class Rol extends ActiveRecord {
    protected static $tabla = 'rol';   
    protected static $columnasDB = ['id', 'nombre'];    
    
    public $id;
    public $nombre;
    
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

    public function validar() {
        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un Nombre";
        }
        return self::$errores;
    }

    public function crearPermisos($pagina_id) {

        // Prepara la consulta
        $query = "INSERT INTO permiso (id_rol, id_pagina) VALUES (".$this->id.", ". $pagina_id.")";
        
        $resultado = self::$db->query($query);
    
        // Ejecuta la consulta y retorna el resultado
        return $resultado;  
    }

    // buscar un registro por su id 
    public static function find($id)
    {
        $query = "SELECT * FROM ".static::$tabla." where id={$id}";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }
    // Eliminar todos los permisos de un rol
    public function eliminarPermiso() {
        $query = "DELETE FROM permiso WHERE id_rol = ".$this->id;
        $resultado = self::$db->query($query);
        
        return $resultado;
    }

}
