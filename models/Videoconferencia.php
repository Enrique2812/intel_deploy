<?php

namespace Model;

use PDO;

class Videoconferencia extends ActiveRecord
{

    protected static $tabla = 'videoconferencia';
    protected static $columnasDB = [
        'id',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'idaula',
        'idcurso',
        'idprofesor',
        'url',
        'descripcion',
        'vision'

    ];

    public $id;
    public $fecha;
    public $hora_inicio;
    public $hora_fin;
    public $idaula;
    public $idcurso;
    public $idprofesor;
    public $url;
    public $descripcion;
    public $curso_nombre;
    public $aula_nombre;
    public $profesor_nombre;
    public $vision;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? '';
        $this->hora_inicio = $args['hora_inicio'] ?? '';
        $this->hora_fin = $args['hora_fin'] ?? '';
        $this->idaula = $args['idaula'] ?? '';
        $this->idcurso = $args['idcurso'] ?? '';
        $this->idprofesor = $args['idprofesor'] ?? '';
        $this->url = $args['url'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->curso_nombre = $args['curso_nombre'] ?? ''; // Agregar esta línea 
        $this->aula_nombre = $args['aula_nombre'] ?? ''; // Agregar esta línea 
        $this->profesor_nombre = $args['profesor_nombre'] ?? '';
        $this->vision = $args['vision'] ?? '1';
    }


    public function validar()
    {

        if (!$this->fecha) {
            self::$errores[] = "Debes añadir una fecha";
        }

        if (!$this->hora_inicio) {
            self::$errores[] = "Debes añadir una hora de inicio";
        }

        if (!$this->hora_fin) {
            self::$errores[] = "Debes añadir una hora fin";
        }

        if (!$this->idaula) {
            self::$errores[] = "Debes añadir un idaula";
        }

        if (!$this->idcurso) {
            self::$errores[] = "Debes añadir un idcurso";
        }

        if (!$this->idprofesor) {
            self::$errores[] = "Debes añadir el idprofesor";
        }

        if (!$this->url) {
            self::$errores[] = "Debes añadir el url";
        }

        if (!$this->descripcion) {
            self::$errores[] = "Debes añadir una descripcion";
        }

        return self::$errores;
    }

    // buscar un registro por su id 
    public static function findByProfesor($id_profesor)
    {
        $query = "SELECT v.*, CONCAT(u.nombre, ' ', u.apellidos) AS profesor_nombre 
        FROM videoconferencia v 
        JOIN profesor p ON v.idprofesor = p.id
         JOIN usuario u ON p.id_usuario = u.id 
         WHERE v.idprofesor = " . self::$db->quote($id_profesor);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }


    public static function findByAula($id_aula)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE idaula = " . self::$db->escape_string($id_aula);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }



    public static function findByAulaCursoProfesor($id_aula, $id_curso, $id_profesor)
    {
        $query = "SELECT v.*, CONCAT(u.nombre, ' ', u.apellidos) AS profesor_nombre 
              FROM videoconferencia v 
              JOIN profesor p ON v.idprofesor = p.id 
              JOIN usuario u ON p.id_usuario = u.id 
              WHERE v.idaula = " . self::$db->quote($id_aula) .
            " AND v.idcurso = " . self::$db->quote($id_curso) .
            " AND v.idprofesor = " . self::$db->quote($id_profesor);
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function allConProfesores()
    {
        $query = "SELECT v.*, CONCAT(u.nombre, ' ', u.apellidos) AS profesor_nombre 
              FROM " . static::$tabla . " v 
              JOIN profesor p ON v.idprofesor = p.id 
              JOIN usuario u ON p.id_usuario = u.id";

        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public function sincronizar($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }

    
    // buscar un registro por su id 
    public static function findProfesorId($id_profesor)
    {
        $query = "SELECT v.*, CONCAT(u.nombre, ' ', u.apellidos) AS profesor_nombre 
              FROM " . static::$tabla . " v 
              JOIN profesor p ON v.idprofesor = p.id 
              JOIN usuario u ON p.id_usuario = u.id ";
        $query .= " where idprofesor={$id_profesor}";

        $resultado = self::consultarSQL($query);

        return $resultado;
    }
}
