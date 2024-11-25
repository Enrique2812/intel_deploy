<?php

namespace Model;

use PDO;

class Reportes extends ActiveRecord
{

    protected static $tabla = 'reporte';
    protected static $columnasDB = [
        'id',
        'archivo_1',
        'archivo_2',
        'archivo_3',
        'archivo_4',
        'descripcion',
        'fecha_ingreso',
        'id_alumno',
        'id_aula',
        'id_profesor',
        'id_ano'
    ];

    public $id;
    public $archivo_1;
    public $archivo_2;
    public $archivo_3;
    public $archivo_4;
    public $descripcion;
    public $fecha_ingreso;
    public $id_alumno;
    public $id_aula;
    public $id_profesor;
    public $id_ano;

    public $nombre_aula;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->archivo_1 = $args['archivo1'] ?? '';
        $this->archivo_2 = $args['archivo2'] ?? '';
        $this->archivo_3 = $args['archivo3'] ?? null;
        $this->archivo_4 = $args['archivo4'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? null;
        $this->id_alumno = $args['id_alumno'] ?? '';
        $this->id_aula = $args['id_aula'] ?? '';
        $this->id_profesor = $args['id_profesor'] ?? null;
        $this->id_ano = $args['id_ano'] ?? '4';
    }


    public function validar()
    {



        if (!$this->archivo_1) {
            self::$errores[] = "Debes añadir una archivo1";
        }
        if (!$this->archivo_2) {
            self::$errores[] = "Debes añadir una descripcion";
        }

        if (!$this->archivo_3) {
            self::$errores[] = "Debes añadir una correo";
        }
        if (!$this->archivo_4) {
            self::$errores[] = "Debes añadir una descripcion";
        }


        if (!$this->fecha_ingreso) {
            self::$errores[] = "Debes añadir una descripcion";
        }

        if (!$this->id_alumno) {
            self::$errores[] = "Debes añadir una correo";
        }
        if (!$this->id_aula) {
            self::$errores[] = "Debes añadir una descripcion";
        }

        if (!$this->id_profesor) {
            self::$errores[] = "Debes añadir una correo";
        }
        if (!$this->id_ano) {
            self::$errores[] = "Debes añadir una descripcion";
        }

        return self::$errores;
    }

    public static function obtenerReportesPorTutor($idProfesor)
    {
        $query = "SELECT r.* FROM reporte r INNER JOIN alumno a ON r.id_alumno = a.id INNER JOIN aula au ON a.id_aula = au.id WHERE au.tutor = :idProfesor";
        $stmt = self::$db->prepare($query);
        $stmt->bindValue(':idProfesor', $idProfesor, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return array_map(function ($record) {
            return new self($record);
        }, $result);
    }

    public static function obtenerReportesPorAlumno($idAlumno)
    {
        $query = "SELECT 
                r.*, 
                a.nombre AS nombre_aula 
              FROM " . static::$tabla . " r 
              JOIN aula a ON r.id_aula = a.id 
              WHERE r.id_alumno = " . self::$db->quote($idAlumno);

        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}
