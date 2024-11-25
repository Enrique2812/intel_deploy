<?php

namespace Model;

class Alumno extends ActiveRecord
{
    protected static $tabla = 'alumno';
    protected static $columnasDB = ['id', 'id_familia', 'id_usuario', 'estado_matricula', 'id_nivel', 'id_grado', 'id_seccion', 'año_ingreso', 'estado'];

    public $id;
    public $id_familia;
    public $id_usuario;
    public $estado_matricula;
    public $id_nivel;
    public $id_grado;
    public $id_seccion;
    public $año_ingreso;
    public $estado; // Nuevo campo estado

    // Propiedades adicionales 
    public $id_aula;
    public $aula_nombre;
    public $nombre_completo;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_familia = $args['id_familia'] ?? '3';
        $this->id_usuario = $args['id_usuario'] ?? '';
        $this->estado_matricula = $args['estado_matricula'] ?? '0';
        $this->id_nivel = $args['id_nivel'] ?? '1';
        $this->id_grado = $args['id_grado'] ?? '1';
        $this->id_seccion = $args['id_seccion'] ?? '1';
        $this->año_ingreso = $args['año_ingreso'] ?? date('Y');
        $this->estado = $args['estado'] ?? '1'; // culpa de david 

        $this->id_aula = $args['id_aula'] ?? '';
        $this->aula_nombre = $args['aula_nombre'] ?? '';
        $this->nombre_completo = $args['nombre_completo'] ?? '';
    }

    // buscar un registro por su id 
    public static function find($id)
    {
        $query = "SELECT * FROM " . static::$tabla . " where id_usuario={$id}";

        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }
    public function eliminar()
    {
        $query = "DELETE TOP (1) FROM " . static::$tabla . " Where id = " . $this->id;

        $resultado = self::$db->query($query);
        if ($resultado) {

            $query = "DELETE TOP (1) FROM usuario Where id = " . $this->id_usuario;
            $resultado = self::$db->query($query);
            if ($resultado) {
                return $resultado;
            }
        }
        return false;
    }
    // Modelo Pagina
    public static function obtenerAlumnoAula($idAula)
    {
        $query = "SELECT al.* from alumno al
                join matricula ma on ma.id_alumno=al.id
                Where ma.id_aula= " . $idAula;
        // debuguear($query);
        $resultado = self::consultarSQL($query);

        return $resultado;
    }
    public static function obtenerAlumnosPorTutor($idProfesor)
    {
        $query = "SELECT DISTINCT
                    alu.*, 
                    a.nombre as aula_nombre, 
                    CONCAT(u.nombre, ' ', u.apellidos) AS nombre_completo 
                  FROM " . static::$tabla . " alu 
                  JOIN matricula m ON m.id_alumno = alu.id 
                  JOIN aula a ON m.id_aula = a.id 
                  JOIN usuario u ON alu.id_usuario = u.id 
                  WHERE a.tutor = " . self::$db->quote($idProfesor);

        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}
