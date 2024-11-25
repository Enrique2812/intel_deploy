<?php

namespace Model;

use Exception;
use PDO;

class Aula extends ActiveRecord
{
    protected static $tabla = 'aula';
    protected static $columnasDB = ['id', 'nombre', 'id_nivel', 'id_grado', 'id_seccion', 'id_año', 'id_turno', 'fecha_ingreso', 'tutor', 'cotutor', 'auxiliar', 'coordinador', 'clase_en_vivo'];

    public $id;
    public $nombre;
    public $id_nivel;
    public $id_grado;
    public $id_seccion;
    public $id_año;
    public $id_turno;
    public $fecha_ingreso;
    public $tutor;
    public $cotutor;
    public $auxiliar;
    public $coordinador;
    public $clase_en_vivo;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->id_nivel = $args['id_nivel'] ?? '';
        $this->id_grado = $args['id_grado'] ?? '';
        $this->id_seccion = $args['id_seccion'] ?? '1';
        $this->id_año = $args['id_año'] ?? '4';
        $this->id_turno = $args['id_turno'] ?? '';
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? date('Y-m-d');
        $this->tutor = $args['tutor'] ?? '';
        $this->cotutor = $args['cotutor'] ?? $this->tutor;
        $this->auxiliar = $args['auxiliar'] ?? $this->tutor;
        $this->coordinador = $args['coordinador'] ?? $this->tutor;
        $this->clase_en_vivo = $args['clase_en_vivo'] ?? '';
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un Nombre";
        }

        if (!$this->id_nivel) {
            self::$errores[] = "Debes añadir un id nombre";
        }

        if (!$this->id_grado) {
            self::$errores[] = "Debes añadir un id grado";
        }

        if (!$this->id_seccion) {
            self::$errores[] = "Debes añadir un id seccion";
        }

        if (!$this->id_año) {
            self::$errores[] = "Debes añadir un id año";
        }

        if (!$this->id_turno) {
            self::$errores[] = "Debes añadir un id turno";
        }

        // if (!$this->clase_en_vivo) {
        //     self::$errores[] = "Debes añadir un clase en vivo";
        // }


        if (!$this->tutor) {
            self::$errores[] = "Debes añadir un id Tutor";
        }

        // if (!$this->cotutor) {
        //     self::$errores[] = "Debes añadir un id año";
        // }

        // if (!$this->auxiliar) {
        //     self::$errores[] = "Debes añadir un id turno";
        // }

        // if (!$this->coordinador) {
        //     self::$errores[] = "Debes añadir un clase en vivo";
        // }
        return self::$errores;
    }

    public static function allByGrado($idGrado)
{
    $query = "SELECT * FROM " . static::$tabla . " WHERE id_grado = " . intval($idGrado);

    $resultado = self::consultarSQL($query);

    return $resultado;
}


    public function crearCursos($curso)
    {

        // Prepara la consulta
        $query = "INSERT INTO aula_personal_curso (id_curso,estado,id_aula,id_año,fecha_ingreso) VALUES ('" . $curso . "','0','" . $this->id . "','4',GETDATE() )";

        $resultado = self::$db->query($query);

        // Ejecuta la consulta y retorna el resultado
        return $resultado;
    }
    public static function findAulaTutor($id)
    {

        $query = "SELECT * from aula";
        $query .= " WHERE tutor=" . $id;

        $resultado = self::consultarSQL($query);
        // debuguear($resultado);

        return $resultado;
    }
    public static function allByIdAño($idAño)
    {
        $query = "SELECT * FROM aula WHERE id_año = " . intval($idAño);

        $resultado = self::consultarSQL($query);

        return $resultado;
    }
    public static function verificarDependencias($id)
    {
        $query = "SELECT COUNT(*) as total FROM aula_personal_curso WHERE id_aula = " . intval($id);
        $resultado = self::$db->query($query)->fetch();

        return $resultado['total'] > 0;
    }
    public function eliminarReferencias()
    {
        $query = "DELETE FROM aula_personal_curso WHERE id_aula = " . $this->id;
        return self::$db->query($query);
    }
    public function eliminarAula()
    {
        $this->eliminarReferencias();

        $query = "DELETE TOP (1) FROM " . static::$tabla . " WHERE id = " . $this->id;
        return self::$db->query($query);
    }
}
