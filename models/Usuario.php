<?php

namespace Model;

use PDO;

class Usuario extends ActiveRecord
{

    protected static $tabla = 'usuario';
    protected static $columnasDB = [
        'id', 'nombre', 'email', 'email_opcional', 'email_dam', 'password', 
        'id_rol', 'apellidos', 'dni', 'telefono', 'domicilio', 
        'sexo', 'fecnac', 'estado', 'idaño', 'fecha_ingreso'
    ];
    
    public $id;
    public $nombre;
    public $email;
    public $email_opcional;
    public $email_dam;
    public $password;
    public $id_rol;
    public $apellidos;
    public $dni;
    public $telefono;
    public $domicilio;
    public $sexo;
    public $fecnac;
    public $estado;
    public $idaño;
    public $fecha_ingreso;

    
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->email_opcional = $args['email_opcional'] ?? '';
        $this->email_dam = $args['email_dam'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->id_rol = $args['id_rol'] ?? '';
        $this->apellidos = $args['apellidos'] ?? '';
        $this->dni = $args['dni'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->domicilio = $args['domicilio'] ?? '';
        $this->sexo = $args['sexo'] ?? '';
        $this->fecnac = $args['fecnac'] ?? null;
        $this->estado = $args['estado'] ?? 1;
        $this->idaño = $args['idaño'] ?? null;
        $this->fecha_ingreso = $args['fecha_ingreso'] ?? null;
    }
    

    public function validar()
    {

        if (!$this->nombre) {
            self::$errores[] = "Debes añadir un Nombre";
        }

        if (!$this->dni) {
            self::$errores[] = "Debes añadir un DNI";
        }

        if (!$this->email) {
            self::$errores[] = "Debes añadir un Email";
        }

        if (!$this->id_rol) {
            self::$errores[] = "Selecciona un rol";
        }


        if (!$this->password) {
            self::$errores[] = "Ingrese una contraseña";
        }

        return self::$errores;
    }


    public function validarLogin()
    {
        if (!$this->email) {
            self::$errores[] = "Ingrese un Email";
        }

        if (!$this->password) {
            self::$errores[] = "Ingrese la contraseña";
        }

        return self::$errores;
    }

    public function existeUsuario()
    {

        $query = "SELECT TOP (1) * FROM " . self::$tabla;
        $query .= " WHERE email= '" . $this->email . "'";
        // debuguear($query);
        $resultado = self::$db->query($query);
        if (!$resultado->rowCount()) {
            self::$errores[] = 'Usuario no existe';
            return;
        }
        return $resultado;
    }
    public function comprobarPassword($resultado)
    {
        $usuario = $resultado->fetch(PDO::FETCH_OBJ);

        $autenticado = password_verify($this->password, $usuario->password);

        if (!$autenticado) {
            self::$errores[] = 'El password es incorrecto ';
        } else {
            $this->nombre = $usuario->nombre;
            $this->id_rol = $usuario->id_rol;
            $this->id = $usuario->id;
        }
        return $autenticado;
    }
    public function autenticar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        //llenar el arreglo de sesion

        $_SESSION['email'] = $this->email;
        $_SESSION['nombre'] = $this->nombre;
        $_SESSION['rol'] = $this->id_rol;
        $_SESSION['login'] = true;
        // debuguear($_SESSION);
    }
    
    public function guardar()
    {
        // debuguear($this->id);
        if (!is_null($this->id)) {
            // Verificar si el correo ya existe
            return $this->actualizar();
        } else {
            // Verificar si el correo ya existe
            if ($this->existeCorreo()) {
                self::$errores[] = "El correo ya existe , ingrese otro correo";
            }
            if($this->existeDNI()){
                self::$errores[] = "El DNI ya existe , ingrese otro ";
                return false ;
            }else{
                return $this->crear();
            }
        }
    }
    public function existeDNI()
    {
        $query = "SELECT TOP 1 * FROM ".static::$tabla." WHERE dni = '".$this->dni."'";
        
        $respuesta = self::$db->prepare($query);
        $respuesta->execute();
        return $respuesta->fetch(); // Si devuelve algo, el correo ya existe
    }
    
    public function existeCorreo()
    {
        $query = "SELECT TOP 1 * FROM ".static::$tabla." WHERE email = '".$this->email."'";

        $respuesta = self::$db->prepare($query);
        $respuesta->execute();
        return $respuesta->fetch(); // Si devuelve algo, el correo ya existe
    }
    
    public function crear()
    {
        $atributos = $this->sanitizarAtributos();    
    
        // Si no existe, procede a insertar
        $query = "INSERT INTO ".static::$tabla." ( ";
        $query .= join(', ', array_keys($atributos));
        $query .= ") VALUES ('";
        $query .= join("', '", array_values($atributos));
        $query .= "')";
        
        $resultado = self::$db->query($query);
    
        if ($resultado) {
            $this->id = self::$db->lastInsertId();
        }
    
        return $resultado;
    }
    public static function allProfesor(){
        
        $query = "SELECT u.* FROM profesor";
        $query .= " pr INNER JOIN ".static::$tabla." u ON u.id=pr.id_usuario";

        // debuguear($query);
        $resultado = self::consultarSQL($query);

        return $resultado;
    }
    public static function allAlumno(){
        
        $query = "SELECT u.* FROM alumno";
        $query .= " pr INNER JOIN ".static::$tabla." u ON u.id=pr.id_usuario";

        // debuguear($query);
        $resultado = self::consultarSQL($query);

        return $resultado;
    }
    public static function allByIdAño($idAño)
    {
        $query = "SELECT * FROM usuario WHERE idaño = {$idAño}";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    public static function allByIdAñoProfesor($idAño)
    {
        $query = "SELECT u.* FROM profesor pr ";
        $query .= "INNER JOIN " . static::$tabla . " u ON u.id = pr.id_usuario ";
        $query .= "WHERE u.idaño = '{$idAño}'";

        $resultado = self::consultarSQL($query);
        return $resultado;
    }
    public static function findByDNI($dni)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE dni = ?";
        $stmt = self::$db->prepare($query);
        $stmt->execute([$dni]);
        $result = $stmt->fetch();

        return $result ? new self($result) : null;
    }
}
