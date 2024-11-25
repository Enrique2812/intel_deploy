<?php

namespace Model;

class Aristoteles extends ActiveRecord
{
    protected static $tabla = 'aristoteles';
    protected static $columnasDB = ['id', 'titulo', 'pd_descripcion', 'pd_teoria', 'pd_practica', 'pd_problemas_resueltos', 'pd_esquemas', 'pd_tiempo', 'pd_lectura', 'pd_retroalimentacion', 'pd_material_apoyo', 'pd_apendice', 'pd_otros', 'id_aula', 'id_curso', 'id_año', 'id_tarea', 'fecha_asignacion', 'imagen', 'urlVideo', 'estado'];

    public $id;
    public $titulo;
    public $pd_descripcion;
    public $pd_teoria;
    public $pd_practica;
    public $pd_problemas_resueltos;
    public $pd_esquemas;
    public $pd_tiempo;
    public $pd_lectura;
    public $pd_retroalimentacion;
    public $pd_material_apoyo;
    public $pd_apendice;
    public $pd_otros;
    public $id_aula;
    public $id_curso;
    public $id_año;
    public $id_tarea;
    public $fecha_asignacion;
    public $imagen;
    public $urlVideo;
    public $estado;


    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->titulo = $args['titulo'] ?? '';
        $this->pd_descripcion = $args['pd_descripcion'] ?? '';
        $this->pd_teoria = $args['pd_teoria'] ?? '';
        $this->pd_practica = $args['pd_practica'] ?? '';
        $this->pd_problemas_resueltos = $args['pd_problemas_resueltos'] ?? '';
        $this->pd_esquemas = $args['pd_esquemas'] ?? '';
        $this->pd_tiempo = $args['pd_tiempo'] ?? '';
        $this->pd_lectura = $args['pd_lectura'] ?? '';
        $this->pd_retroalimentacion = $args['pd_retroalimentacion'] ?? '';
        $this->pd_material_apoyo = $args['pd_material_apoyo'] ?? '';
        $this->pd_apendice = $args['pd_apendice'] ?? '';
        $this->pd_otros = $args['pd_otros'] ?? '';
        $this->id_aula = $args['id_aula'] ?? '';
        $this->id_curso = $args['id_curso'] ?? '';
        $this->id_año = $args['id_año'] ?? '4';
        $this->id_tarea = $args['id_tarea'] ?? '';
        $this->fecha_asignacion = $args['fecha_asignacion'] ?? date('Y-m-d');
        $this->imagen = $args['imagen'] ?? '';
        $this->urlVideo = $args['urlVideo'] ?? '';
        $this->estado = $args['estado'] ?? '0';
    }

    public function validar()
    {

        self::$errores = []; // Reiniciar los errores en cada validación

        if (!$this->titulo) {
            self::$errores[] = "Debes ingresar un titulo";
        }

        if (!$this->imagen) {
            self::$errores[] = "Debes ingresar una Imagen";
        }

        if (!$this->id_aula) {
            self::$errores[] = "Selecciona un aula";
        }

        if (!$this->id_curso) {
            self::$errores[] = "Selecciona un curso";
        }

        return self::$errores;
    }

    public function estado()
    {
        if ($this->estado === '0') {
            return $this->ocultar();
        } else {
            return $this->visualizar();
        }
    }
    public function ocultar()
    {
        $query = "UPDATE TOP (1) " . static::$tabla . " SET ";
        $query .= " WHERE id= '" . $this->id . "' ";

        $resultado = self::$db->query($query);
        return $resultado;
    }
    public function visualizar()
    {
        $query = "UPDATE TOP (1) " . static::$tabla . " SET ";
        $query .= " estado = 0";
        $query .= " WHERE id= '" . $this->id . "' ";

        $resultado = self::$db->query($query);
        return $resultado;
    }
    public static function allByIdAño($idAño)
    {
        $query = "SELECT * FROM aristoteles WHERE id_año = " . intval($idAño);

        $resultado = self::consultarSQL($query);

        return $resultado;
    }
}
