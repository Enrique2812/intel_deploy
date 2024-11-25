<?php

namespace Controllers;

use Model\Alumno;
use Model\Aula;
use Model\Profesor;
use Model\Reportes;
use Model\Matricula;
use MVC\Router;

class CalificacionController
{
    public static function calificacion(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $aulas = Aula::all();
        $alumnos = Alumno::all();
        $profesores = Profesor::all();
        $alumnos = [];
        $reportes = [];

        // Verificar rol y autenticación
        if ($_SESSION['rol'] === '5' && isset($_SESSION['id_profesor'])) {
            // Obtener alumnos del tutor en una sola consulta
            $alumnos = Alumno::obtenerAlumnosPorTutor($_SESSION['id_profesor']);
        } elseif ($_SESSION['rol'] === '4' && isset($_SESSION['id_alumno'])) { // Obtener reportes del alumno 
            $reportes = Reportes::obtenerReportesPorAlumno($_SESSION['id_alumno']);
        }

        $router->render('home/calificaciones/calificacion', [
            'CurrentPage' => $CurrentPage,
            'aulas' => $aulas,
            'profesores' => $profesores,
            'alumnos' => $alumnos,
            'reportes' => $reportes
        ]);
    }

    public static function crear(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Reportes::getErrores();
        $alumnos = Alumno::all();
        $aulas = Aula::all();

        $alumnos = Alumno::obtenerAlumnosPorTutor($_SESSION['id_profesor']);


        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['Subir'])) { // Crear el reporte con los datos del formulario 
                $args = $_POST['reporte'];

                $reporte = new Reportes($args); // Asignar archivos subidos 
                $matriculareporte = Matricula::IdAulaReporte($reporte->id_alumno);
                $reporte->id_aula = $matriculareporte->id_aula;

                try {
                    if ($_FILES['reporte']['name']['archivo_1']) {
                        $reporte->archivo_1 = self::subirArchivo($_FILES['reporte']['name']['archivo_1'], $_FILES['reporte']['tmp_name']['archivo_1']);
                    }
                    if ($_FILES['reporte']['name']['archivo_2']) {
                        $reporte->archivo_2 = self::subirArchivo($_FILES['reporte']['name']['archivo_2'], $_FILES['reporte']['tmp_name']['archivo_2']);
                    }
                    if ($_FILES['reporte']['name']['archivo_3']) {
                        $reporte->archivo_3 = self::subirArchivo($_FILES['reporte']['name']['archivo_3'], $_FILES['reporte']['tmp_name']['archivo_3']);
                    }
                    if ($_FILES['reporte']['name']['archivo_4']) {
                        $reporte->archivo_4 = self::subirArchivo($_FILES['reporte']['name']['archivo_4'], $_FILES['reporte']['tmp_name']['archivo_4']);
                    }
                } catch (\Exception $e) {
                    $errores[] = $e->getMessage();
                } // Asignar fecha de ingreso 
                $reporte->fecha_ingreso = date('Y-m-d'); // Validar y guardar el reporte 
                $errores = $reporte->validar();
                // debuguear($errores);

                if (empty($errores)) {
                    $resultado = $reporte->guardar();
                    if ($resultado) { // Mostrar mensaje de éxito 
                        echo "Reporte guardado exitosamente.";
                    } else { // Mostrar mensaje de error 
                        echo "Error al guardar el reporte.";
                    }
                } else { // Mostrar errores de validación 
                    print_r($errores);
                }
            }
        }
        $router->render(
            'home/calificaciones/calificacion',
            ['CurrentPage' => $CurrentPage, 'alumnos' => $alumnos, 'aulas' => $aulas, 'errores' => $errores]
        );
    }
    private static function subirArchivo($nombreArchivo, $tempNombre)
    {
        $rutaDestino = __DIR__ . 'uploads/' . $nombreArchivo; // Ruta donde se guardarán los archivos

        // Verificar que el directorio de destino existe
        if (!is_dir(__DIR__ . 'uploads/')) {
            mkdir(__DIR__ . 'uploads/', 0777, true); // Crear el directorio si no existe
        }

        // Verificar si el archivo temporal existe
        if (!file_exists($tempNombre)) {
            throw new \Exception('El archivo temporal no existe: ' . $tempNombre);
        }

        // Mover el archivo
        if (move_uploaded_file($tempNombre, $rutaDestino)) {
            echo "Archivo movido a: " . $rutaDestino;
            return $nombreArchivo;
        } else {
            throw new \Exception('No se pudo mover el archivo ' . $nombreArchivo . ' a ' . $rutaDestino);
        }
    }









    public static function miscalificaciones(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $router->render('home/calificaciones/miscalificaciones', [
            'CurrentPage' => $CurrentPage
        ]);
    }
    public static function vertodo(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $router->render('home/calificaciones/vertodo', [
            'CurrentPage' => $CurrentPage
        ]);
    }
}
