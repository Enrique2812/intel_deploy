<?php

namespace Model;

class ActiveRecord{
    
    // Base DE DATOS
    protected static $db;
    protected static $tabla='';
    protected static $columnasDB = [];

    //Error
    protected static $errores = [];

    // definir la conexion de BD
    public static function setBD($database)
    {
        self::$db = $database;
    }

    //validaciones
    public static function getErrores()
    {
        return static::$errores;
    }

    public function validar()
    {
        static::$errores=[];
        return static::$errores;
    }

    public function guardar()
    {
        // debuguear($this->id);
        if (!is_null($this->id)) {
            return $this->actualizar();
        } else {
            return $this->crear();
        }
    }
    // lista todas las registros 
    public static function all()
    {
        $query = "SELECT * FROM ".static::$tabla;

        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // obtener una cantidad especifica de registros
    public static function get($cantidad)
    {
        $query = "SELECT TOP ".$cantidad;        
        $query .= " * FROM ".static::$tabla;
        
        $resultado = self::consultarSQL($query);

        return $resultado;
    }

    // buscar un registro por su id 
    public static function find($id)
    {
        $query = "SELECT * FROM ".static::$tabla." where id={$id}";

        // debuguear($query);
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }
    public function crear()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();
        //insert en la base de datos
        $query = "INSERT INTO ".static::$tabla." ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES (' ";
        $query .= join("', '", array_values($atributos));
        $query .= " ') ";
        // debuguear($query);
        $resultado = self::$db->query($query);
        // debuguear($resultado);
        
        // Obtener la última id insertada
        if ($resultado) {
            $this->id = self::$db->lastInsertId();  // Guardar la id en la instancia del objeto
        }

        return $resultado;
    }
    public function actualizar()
    {
        //Sanitizar los datos
        $atributos = $this->sanitizarAtributos();

        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key}='{$value}'";
        }

        $query = "UPDATE TOP (1) ".static::$tabla." SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id= '" . $this->id . "' ";
        
        $resultado = self::$db->query($query);
        return $resultado;
    }

    public function eliminar()
    {
        // elimina la registro 
        $query = "DELETE TOP (1) FROM ".static::$tabla." Where id = " . $this->id ;
        // debuguear($query);
        $resultado = self::$db->query($query);
        return $resultado;
    }
    public static function consultarSQL($query)
    {
        //consulta de base de datos
        $resultado = self::$db->query($query);
        //iterar los resultados
        $array = [];
        foreach ($resultado as $registro) {
            $array[] = static::crearObjeto($registro);
        }
        //retornar los resultados 
        return $array;
    }
    public static function crearObjeto($registro)
    {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }
    public function atributos()
    {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna == 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }
    public function sanitizarAtributos()
    {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        return $sanitizado;
    }
    //sincronizar 
    public function sincroniza($args = [])
    {
        foreach ($args as $key => $value) {
            if (property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }
    //subida de archivos
    public function setImagen($imagen)
    {
        //elimina la imagen previa 
        if (!is_null($this->imagen)) {
            $this->borrarImagen();
        }
        //asigna el atributo de imagen el nombre de la imagen 
        if ($imagen) {
            $this->imagen = $imagen;
        }
    }

    //Eliminar el archivo 
    public function borrarImagen()
    {
        $existeImg = file_exists(CARPETA_IMAGEN . $this->imagen);
        if ($existeImg) {
            unlink(CARPETA_IMAGEN . $this->imagen);
        }
    }

}