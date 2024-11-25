<?php

namespace Model;

class Año extends ActiveRecord
{
    protected static $tabla = 'año';
    protected static $columnasDB = ['id', 'descripcion', 'numero', 'vigente', 'matricula', 'id_tipo_bimestre', 'cantidad_bimestre', 'estado', 'cantidad_periodos', 'semanas_periodo', 'id_tipo_periodo']; 

    public $id;
    public $descripcion;
    public $numero;
    public $vigente = 1;
    public $matricula = 1;
    public $id_tipo_bimestre=1;
    public $cantidad_bimestre = 1;
    public $estado = 1;
    public $cantidad_periodos;
    public $semanas_periodo;
    public $id_tipo_periodo;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->descripcion = $args['descripcion'] ?? '';
        $this->numero = $args['numero'] ?? null;
        $this->vigente = $args['vigente'] ?? 1;
        $this->matricula = $args['matricula'] ?? 1;
        $this->id_tipo_bimestre = $args['id_tipo_bimestre'] ?? 1;
        $this->cantidad_bimestre = $args['cantidad_bimestre'] ?? 1;
        $this->estado = $args['estado'] ?? 1;
        $this->cantidad_periodos = $args['cantidad_periodos'] ?? 5;
        $this->semanas_periodo = $args['semanas_periodo'] ?? null;
        $this->id_tipo_periodo = $args['id_tipo_periodo'] ?? null;
    }

    public static function findByNumero($numero)
    {
        $query = "SELECT TOP 1 * FROM " . static::$tabla . " WHERE numero = {$numero}";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
    public static function todos()
{
    $query = "SELECT numero FROM " . static::$tabla;
    $resultados = self::consultarSQL($query);
    if (!$resultados) {
        error_log("No se encontraron años.");
        return [];
    }
    return $resultados;
}

    
public static function todos_tabla() {
    $query = "SELECT * FROM " . static::$tabla; // Cambiado para obtener todas las columnas
    $resultados = self::consultarSQL($query);
    if (!$resultados) {
        error_log("No se encontraron años.");
        return [];
    }
    return $resultados;
}

public function guardar() {
    $sql = "INSERT INTO " . static::$tabla . " 
            (numero, descripcion, vigente, matricula, estado, id_tipo_bimestre, cantidad_periodos, semanas_periodo, id_tipo_periodo) 
            VALUES (:numero, :descripcion, :vigente, :matricula, :estado, :id_tipo_bimestre, :cantidad_periodos, :semanas_periodo, :id_tipo_periodo)";
    
    $stmt = self::$db->prepare($sql); // Cambia a self::$db

    $stmt->bindParam(':numero', $this->numero);
    $stmt->bindParam(':descripcion', $this->descripcion);
    $stmt->bindParam(':vigente', $this->vigente);
    $stmt->bindParam(':matricula', $this->matricula);
    $stmt->bindParam(':estado', $this->estado);
    $stmt->bindParam(':id_tipo_bimestre', $this->id_tipo_bimestre);
    $stmt->bindParam(':cantidad_periodos', $this->cantidad_periodos);
    $stmt->bindParam(':semanas_periodo', $this->semanas_periodo);
    $stmt->bindParam(':id_tipo_periodo', $this->id_tipo_periodo);

    // Ejecutar la consulta
    return $stmt->execute();
}



}
