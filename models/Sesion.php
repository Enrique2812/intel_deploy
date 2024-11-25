<?php 
namespace Model;

class Rol extends ActiveRecord {
    protected static $tabla = 'rol';   
    protected static $columnasDB = ['id', 'nombre'];    
    
    public $id;
    public $nombre;
    
    
    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
    }

    public function validar() {
        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un Nombre";
        }
        return self::$errores;
    }

}
