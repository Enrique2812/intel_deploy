<?php

namespace Model;

class Horario extends ActiveRecord
{
    protected static $tabla = 'horarios';
    protected static $columnasDB = ['id', 'id_nivel', 'Descripcion', 'HoraIni', 'HoraFin'];

    public $id;
    public $id_nivel;
    public $Descripcion;
    public $HoraIni;
    public $HoraFin;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_nivel = $args['id_nivel'] ?? null;
        $this->Descripcion = $args['descripcion'] ?? '';
        $this->HoraIni = $args['hora_inicio'] ?? null;
        $this->HoraFin = $args['hora_fin'] ?? null;
    }

    public static function findByNivel($id_nivel)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id_nivel = :id_nivel";
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':id_nivel', $id_nivel, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_CLASS, self::class);
    }

    public static function todos()
    {
        $query = "SELECT * FROM " . static::$tabla;
        $resultados = self::consultarSQL($query);
        if (!$resultados) {
            error_log("No se encontraron horarios.");
            return [];
        }
        return $resultados;
    }
    public function actualizarH()
{
    $valores = [];
    foreach ($this->atributos() as $key => $value) {
        if ($key !== 'id') {  // Evitar que el campo 'id' sea actualizado
            $valores[] = "{$key} = '{$value}'"; // Construir las columnas y sus valores
        }
    }

    $query = "UPDATE " . static::$tabla . " SET ";
    $query .= implode(", ", $valores);  // Unir las columnas con sus valores

    $query .= " WHERE id = '{$this->id}'";

    $resultado = self::$db->query($query);

    if ($resultado) {
        return true;  // Si la ejecución fue exitosa
    } else {
        return false;  // Si ocurrió algún error
    }
}


}
