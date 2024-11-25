<?php

namespace Model;

class Profesor extends ActiveRecord
{
    protected static $tabla = 'profesor';
    protected static $columnasDB = ['id', 'id_usuario', 'tutor', 'estadoAula'];

    public $id;
    public $id_usuario;
    public $tutor;
    public $estadoAula;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->tutor = $args['tutor'] ?? '';
        $this->estadoAula = $args['estadoAula'] ?? '';
    }

    // buscar un registro por su id 
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " where id_usuario={$id}";

        // debuguear($query);
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    // buscar un registro por su id 
    public static function findProfesor($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " where id={$id}";

        // debuguear($query);
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }
    public function eliminar()
    {
        // $this->borrarImagen();
        // elimina la registro 
        $query = "DELETE TOP (1) FROM " . static::$tabla . " Where id = " . $this->id;
        // debuguear($query);
        $resultado = self::$db->query($query);
        if ($resultado) {

            $query = "DELETE TOP (1) FROM usuario Where id = " . $this->id_usuario;
            $resultado = self::$db->query($query);
            if ($resultado) {
                return $resultado;
            }
        }
        // debuguear($query);
        return false;
    }

    public static function findProfesorAula($id_aula)
    {
        $query = "SELECT profesor.* FROM profesor
                  INNER JOIN aula_personal_curso ON profesor.id = aula_personal_curso.id_personal
                  WHERE aula_personal_curso.id_aula = " . self::$db->quote($id_aula);
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
}
