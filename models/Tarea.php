<?php 
namespace Model;

class Tarea extends ActiveRecord {
    protected static $tabla = 'tarea';   
    protected static $columnasDB = ['id', 'titulo', 'descripcion', 'fecha_inicio', 'fecha_fin', 'archivo', 'id_aula', 'id_curso','id_año','id_profesor','id_tipo_evaluacion'];    
    
    public $id;
    public $titulo;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_fin;
    public $archivo;
    public $id_aula;
    public $id_curso;
    public $id_año;
    public $id_profesor;
    public $id_tipo_evaluacion;
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->fecha_inicio = $args['fecha_inicio'] ?? '';
        $this->fecha_fin = $args['fecha_fin'] ?? '';
        $this->archivo = $args['archivo'] ?? '';
        $this->id_aula = $args['id_aula'] ?? '';
        $this->id_curso = $args['id_curso'] ?? '';
        $this->id_año = $args['id_año'] ?? '4';
        $this->id_profesor = $args['id_profesor'] ?? '';
        $this->id_tipo_evaluacion = $args['id_tipo_evaluacion'] ?? '';
    }

    public function validar()
    {

        if (!$this->titulo) {
            self::$errores[] = "Debes añadir un Titulo";
        }

        if (!$this->fecha_inicio) {
            self::$errores[] = "Debes añadir un fecha de inicio";
        }

        if (!$this->fecha_fin) {
            self::$errores[] = "Debes añadir un fecha de fin";
        }

        if (!$this->archivo) {
            self::$errores[] = "Ingresa la archivo de la tarea";
        }

        if (!$this->id_aula) {
            self::$errores[] = "Seleccione un aula";
        }

        if (!$this->id_curso) {
            self::$errores[] = "Seleccione un curso";
        }

        return self::$errores;
    }

    // buscar un registro por su id 
    public static function findProfesor($id)
    {
        $query = "SELECT * FROM ".static::$tabla." where id_profesor={$id}";

        $resultado = self::consultarSQL($query);

        return $resultado;
    }
}
