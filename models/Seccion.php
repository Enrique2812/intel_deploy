<?php

namespace Model;

use Exception;
use PDO;

class Seccion extends ActiveRecord
{
    protected static $tabla = 'seccion';
    protected static $columnasDB = ['id', 'descripcion', 'abreviatura', 'id_grado'];

    public $id;
    public $descripcion;
    public $abreviatura;
    public $id_grado;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->abreviatura = $args['abreviatura'] ?? '';
        $this->id_grado = $args['id_grado'] ?? '';
    }

    public function validar()
    {
        if (!$this->descripcion) {
            self::$errores[] = "Debes añadir una descripcion";
        }
        return self::$errores;
        if (!$this->abreviatura) {
            self::$errores[] = "Debes añadir una abreviatura";
        }
        return self::$errores;
        if (!$this->id_grado) {
            self::$errores[] = "Debes añadir un id_grado";
        }
        return self::$errores;
    }
    public static function allByGrado($gradoId)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id_grado = " . self::$db->quote($gradoId);
        $resultado = self::consultarSQL($query);
        error_log(print_r($resultado, true));
        error_log("Consulta SQL: " . $query); // Esto te permitirá ver la consulta en el archivo de log
        error_log(print_r($resultado, true));
        return $resultado;
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
