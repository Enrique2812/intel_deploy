<?php

namespace Model;

class Evaluacion extends ActiveRecord {
    protected static $tabla = 'evaluacion';
    protected static $columnasDB = ['id', 'nombre', 'descripcion', 'tipo_evaluacion', 'id_año'];

    public $id;
    public $nombre;
    public $descripcion;
    public $tipo_evaluacion;
    public $id_año;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->tipo_evaluacion = $args['tipo_evaluacion'] ?? '';
        $this->id_año = $args['id_año'] ?? '';
    }

    public static function todos() {
        $query = "SELECT evaluacion.*, año.numero as numero_año 
                  FROM evaluacion 
                  JOIN año ON evaluacion.id_año = año.id";
    
        $resultado = self::consultarSQL($query);
    
        return $resultado;
    }
    
    public function guardar() {
        $query = "INSERT INTO evaluacion (nombre, descripcion, tipo_evaluacion, id_año) 
                  VALUES (:nombre, :descripcion, :tipo_evaluacion, :id_año)";
    
        $atributos = [
            ':nombre' => $this->nombre,
            ':descripcion' => $this->descripcion,
            ':tipo_evaluacion' => $this->tipo_evaluacion,
            ':id_año' => $this->id_año
        ];
    
        $resultado = self::consultarSQL($query, $atributos);
    
        return $resultado;
    }

    // Método para obtener los exámenes relacionados a esta evaluación
    public function obtenerExamenes() {
        $query = "SELECT * FROM examen WHERE id_evaluacion = :id_evaluacion";
        $atributos = [':id_evaluacion' => $this->id];
        return self::consultarSQL($query, $atributos);
    }
}
