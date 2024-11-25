<?php

namespace Model;

class Pagina extends ActiveRecord
{
    protected static $tabla = 'pagina';
    protected static $columnasDB = ['id', 'nombre', 'ruta', 'id_modulo'];

    public $id;
    public $nombre;
    public $ruta;
    public $id_modulo;

    public function obtenerModulo()
    {
        $query = "SELECT * FROM modulo WHERE id = " . $this->id_modulo;
        return array_shift(self::consultarSQL($query));
    }
    // Modelo Pagina
    public static function obtenerPaginasPorRol($idRol)
    {
        $query = "SELECT p.* 
              FROM pagina p
              JOIN permiso pe ON pe.id_pagina = p.id
              WHERE pe.id_rol = " . $idRol;
        $resultado = self::consultarSQL($query);

        return $resultado;
    }
}
