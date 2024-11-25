<?php

namespace Model;

class Asistencia extends ActiveRecord
{
    protected static $tabla = 'asistencia'; // Nombre de la tabla en la base de datos
    protected static $columnasDB = ['id', 'id_alumno', 'fecha', 'hora_ingreso', 'hora_salida', 'tardanza', 'estado'];

    public $id;
    public $id_alumno;
    public $fecha;
    public $hora_ingreso;
    public $hora_salida;
    public $tardanza;
    public $estado;
    public $dni;
    public $nombre;
    public $apellidos;
    public $grado; // g.abreviatura
    public $aula;  // a.nombre
    public $NumeroDeAsistencias; // COUNT(asi.id)

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->id_alumno = $args['id_alumno'] ?? null;
        $this->fecha = $args['fecha'] ?? date('Y-m-d');
        $this->hora_ingreso = $args['hora_ingreso'] ?? null;
        $this->hora_salida = $args['hora_salida'] ?? null;
        $this->tardanza = $args['tardanza'] ?? 0;
        $this->estado = $args['estado'] ?? 'Presente';
    }

    public static function buscarAsistenciaPorAlumnoYFecha($idAlumno, $fecha)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id_alumno = :id_alumno AND fecha = :fecha";
        $params = [
            'id_alumno' => $idAlumno,
            'fecha' => $fecha
        ];

        $resultado = self::consultarSQL($query, $params);
        return array_shift($resultado);
    }

    public function guardar()
    {
        $query = "INSERT INTO " . static::$tabla . " (id_alumno, fecha, hora_ingreso, hora_salida, tardanza, estado) 
                  VALUES (:id_alumno, :fecha, :hora_ingreso, :hora_salida, :tardanza, :estado)";

        $params = [
            'id_alumno' => $this->id_alumno,
            'fecha' => $this->fecha,
            'hora_ingreso' => $this->hora_ingreso,
            'hora_salida' => $this->hora_salida,
            'tardanza' => $this->tardanza,
            'estado' => $this->estado
        ];

        $resultado = self::$db->prepare($query);
        return $resultado->execute($params);
    }

    public function actualizar()
    {
        $query = "UPDATE " . static::$tabla . " SET 
                  hora_ingreso = :hora_ingreso, 
                  hora_salida = :hora_salida, 
                  tardanza = :tardanza, 
                  estado = :estado 
                  WHERE id = :id";

        $params = [
            'hora_ingreso' => $this->hora_ingreso,
            'hora_salida' => $this->hora_salida,
            'tardanza' => $this->tardanza,
            'estado' => $this->estado,
            'id' => $this->id
        ];

        $resultado = self::$db->prepare($query);
        return $resultado->execute($params);
    }

    public function eliminar()
    {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = :id";
        $params = ['id' => $this->id];

        $resultado = self::$db->prepare($query);
        return $resultado->execute($params);
    }

    public static function obtenerAsistenciaPorRangoFechas($idAlumno, $fechaInicio, $fechaFin)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id_alumno = :id_alumno 
                  AND fecha BETWEEN :fechaInicio AND :fechaFin";

        $params = [
            'id_alumno' => $idAlumno,
            'fechaInicio' => $fechaInicio,
            'fechaFin' => $fechaFin
        ];

        return self::consultarSQL($query, $params);
    }

    public function actualizarHoraSalida()
    {
        $query = "UPDATE " . static::$tabla . " SET hora_salida = :hora_salida WHERE id_alumno = :id_alumno AND fecha = :fecha";

        $stmt = self::$db->prepare($query);
        $stmt->bindValue(':hora_salida', $this->hora_salida);
        $stmt->bindValue(':id_alumno', $this->id_alumno);
        $stmt->bindValue(':fecha', $this->fecha);

        if ($stmt->execute()) {
            return true;
        } else {
            $errorInfo = $stmt->errorInfo();
            error_log('Error en la actualización de hora de salida: ' . implode(', ', $errorInfo));
            return false;
        }
    }


    public static function buscarPorFechaYAlumno($fecha, $id_alumno)
    {
        $query = "SELECT * FROM " . static::$tabla . " WHERE fecha = :fecha AND id_alumno = :id_alumno";
        $stmt = self::$db->prepare($query);
        $stmt->bindValue(':fecha', $fecha);
        $stmt->bindValue(':id_alumno', $id_alumno);
        $stmt->execute();
        error_log("Consulta SQL: " . $query);


        return $stmt->fetchAll();
    }
    public static function buscarGeneral($idGrado, $idAula, $fechaInicio, $fechaFin)
    {
        $idGrado = intval($idGrado);
        $idAula = intval($idAula);
        $fechaInicio = htmlspecialchars($fechaInicio, ENT_QUOTES, 'UTF-8');
        $fechaFin = htmlspecialchars($fechaFin, ENT_QUOTES, 'UTF-8');

        $query = "SELECT
                        a.id_alumno,
                        alum.id_usuario,
                        u.nombre,
                        u.apellidos,
                        u.dni,
                        a.fecha,
                        a.hora_ingreso,
                        a.hora_salida,
                        a.tardanza,
                        m.id_aula,
                        al.id_grado
                    FROM
                        asistencia a
                    JOIN
                        matricula m ON a.id_alumno = m.id_alumno
                    JOIN
                        aula al ON m.id_aula = al.id
                    JOIN
                        alumno alum ON a.id_alumno = alum.id
                    JOIN
                        usuario u ON alum.id_usuario = u.id
                    WHERE
                        a.fecha BETWEEN '$fechaInicio' AND '$fechaFin'
                        AND al.id_grado = $idGrado
                        AND al.id = $idAula";

        // Ejecutar la consulta
        return self::consultarSQL($query);
    }
    public static function buscarPorCorreoYRangoFechas($email, $fechaInicio, $fechaFin)
    {
        $query = "SELECT 
                      a.fecha,
                      a.hora_ingreso,
                      a.tardanza,
                      a.hora_salida
                  FROM " . static::$tabla . " a
                  INNER JOIN alumno al ON a.id_alumno = al.id
                  INNER JOIN usuario u ON al.id_usuario = u.id
                  WHERE u.email = '$email'
                    AND a.fecha BETWEEN '$fechaInicio' AND '$fechaFin'";

        // Debug para verificar la consulta y parámetros
        error_log("Query: $query");

        // Ejecutar consulta y obtener resultados
        $resultados = self::consultarSQL($query);

        error_log(print_r($resultados, true));

        return $resultados;
    }
    public static function buscarAsistenciaPorDia($nivel, $fechapd)
    {
        $query = "SELECT 
    g.abreviatura AS grado,
    a.nombre AS aula,
    COUNT(asi.id) AS NumeroDeAsistencias
FROM 
    Aula a
INNER JOIN 
    Grado g ON a.id_grado = g.id
INNER JOIN 
    Matricula m ON a.id = m.id_aula
INNER JOIN 
    Asistencia asi ON m.id_alumno = asi.id_alumno
WHERE 
    a.id_nivel = '$nivel'
    AND asi.fecha = '$fechapd'
GROUP BY 
    g.abreviatura, a.nombre
ORDER BY 
    g.abreviatura, a.nombre;";

        // Debug para verificar la consulta y parámetros
        error_log("Query: $query");

        // Ejecutar consulta y obtener resultados
        $resultados = self::consultarSQL($query);

        error_log(print_r($resultados, true));

        return $resultados;
    }
    

    
}
