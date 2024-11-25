<?php

namespace Model;

class Modulo extends ActiveRecord
{
    protected static $tabla = 'modulo';
    protected static $columnasDB = ['id', 'nombre'];

    public $id;
    public $nombre;

    public function obtenerPaginas()
    {
        $query = "SELECT * FROM pagina WHERE modulo_id = " . $this->id;
        return self::consultarSQL($query);
    }
    // Modelo Modulo
    public static function obtenerModulosPorRol($idRol)
    {
        $query = "SELECT DISTINCT m.* 
              FROM modulo m
              JOIN pagina p ON p.id_modulo = m.id
              JOIN permiso pe ON pe.id_pagina = p.id
              WHERE pe.id_rol = " . $idRol;

        $resultado = self::consultarSQL($query);
        debuguear($resultado);

        return $resultado;
    }
}
