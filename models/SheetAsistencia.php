<?php
namespace Model;

class SheetAsistencia extends ActiveRecord
{
    protected static $tabla = 'SheetAsistencia';
    protected static $columnasDB = ['id_aula', 'googleSheetID'];

    public $id_aula;
    public $googleSheetID;
    public $aula_nombre;

    public function __construct($args = [])
    {
        $this->id_aula = $args['id_aula'] ?? null;
        $this->googleSheetID = $args['googleSheetID'] ?? '';
    }

    public static function buscarPorAula($idAula) {
        $idAula = intval($idAula);
        $query = "SELECT * FROM " . static::$tabla . " WHERE id_aula = $idAula";
        
        $result = self::consultarSQL($query);
        
        return !empty($result) ? $result[0] : null;
    }

    public function guardar()
    {
        if (self::buscarPorAula($this->id_aula)) {
            $query = "UPDATE " . static::$tabla . " SET googleSheetID = ? WHERE id_aula = ?";
            $stmt = self::$db->prepare($query);
            $resultado = $stmt->execute([$this->googleSheetID, $this->id_aula]);
        } else {
            $query = "INSERT INTO " . static::$tabla . " (id_aula, googleSheetID) VALUES (?, ?)";
            $stmt = self::$db->prepare($query);
            $resultado = $stmt->execute([$this->id_aula, $this->googleSheetID]);
        }
        
        return $resultado;
    }
    public static function obtenerAulasConSheet()
{
    $query = "SELECT 
                  a.nombre AS aula_nombre,
                  sa.googleSheetID
              FROM 
                  sheetAsistencia sa
              JOIN 
                  aula a ON sa.id_aula = a.id";

    error_log("Consulta SQL: " . $query); // Esto te permite ver la consulta que se está ejecutando

    $resultados = self::consultarSQL($query);

    error_log("Resultados obtenidos: " . print_r($resultados, true)); // Esto va a mostrar los datos obtenidos de la base de datos

    return $resultados;
}



}
