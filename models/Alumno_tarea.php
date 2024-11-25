<?php

namespace Model;

class Alumno_tarea extends ActiveRecord
{
    protected static $tabla = 'alumno_tarea';
    protected static $columnasDB = ['id', 'id_alumno', 'id_tarea', 'archivo', 'estado', 'fecha_entrega'];

    public $id;
    public $id_alumno;
    public $id_tarea;
    public $archivo;
    public $estado;
    public $fecha_entrega;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_alumno = $args['id_alumno'] ?? '';
        $this->id_tarea = $args['id_tarea'] ?? '';
        $this->archivo = $args['archivo'] ?? '';
        $this->estado = $args['estado'] ?? '0';
        $this->fecha_entrega = $args['fecha_entrega'] ?? '';
    }
    public function validar()
    {

        if (!$this->archivo) {
            self::$errores[] = "Debes añadir un archivo";
        }

        return self::$errores;
    }

    public static function findAlumno($id)
    {

        $query = "SELECT * from " . static::$tabla;
        $query .= " where id_alumno=" . $id;

        $resultado = self::consultarSQL($query);
        // debuguear($resultado);

        return $resultado;
    }

    public static function findTarea($id)
    {

        $query = "SELECT * from " . static::$tabla;
        $query .= " where id_tarea=" . $id;

        $resultado = self::consultarSQL($query);
        // debuguear($resultado);

        return $resultado;
    }

    public static function findAlumnoTarea($idA,$idT)
    {

        $query = "SELECT * from " . static::$tabla;
        $query .= " where id_alumno=" . $idA;
        $query .= " and id_tarea=" . $idT;

        $resultado = self::consultarSQL($query);
        // debuguear($resultado);

        return array_shift($resultado);
    }
}
