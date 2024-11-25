<?php

namespace Model;

class TipoPeriodo extends ActiveRecord {
    protected static $tabla = 'tipo_periodo';
    protected static $columnasDB = ['id', 'idaño', 'tipo_periodo' ];

    public $id;
    
    public $idaño;
    public $tipo_periodo;

    

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
       
        $this->idaño = $args['idaño'] ?? null;
        $this->tipo_periodo = $args['tipo_periodo'] ?? '';
    }

    public static function todos() {
        $query = "SELECT * FROM " . static::$tabla;
        return self::consultarSQL($query);
    }
}
