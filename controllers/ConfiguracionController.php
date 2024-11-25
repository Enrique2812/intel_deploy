<?php 

namespace Controllers;

use MVC\Router;
use Model\Año;
use Model\TipoPeriodo;
use Model\Evaluacion;

class ConfiguracionController {
    public static function escolar(Router $router) {
        $CurrentPage = 'table-datatable-basic';
        
        $anios = Año::todos_tabla();
    
        $tiposPeriodoData = TipoPeriodo::todos();
    
        $tiposPeriodo = [];
        foreach ($tiposPeriodoData as $tipo) {
            $tiposPeriodo[$tipo->id] = $tipo;
        }
    
        $router->render('home/configuracion/escolar', [
            'CurrentPage' => $CurrentPage,
            'anios' => $anios,
            'tiposPeriodo' => $tiposPeriodo
        ]);
    }
    

    public static function tipoevaluacion(Router $router) {
        $CurrentPage = 'table-datatable-basic';
        
        // Obtener todos los años y evaluaciones
        $anios = Año::todos_tabla(); 
        $evaluaciones = Evaluacion::todos();

        $router->render('home/configuracion/tipoevaluacion', [
            'CurrentPage' => $CurrentPage,
            'anios' => $anios,
            'evaluaciones' => $evaluaciones
        ]);
    }

    public static function crearEvaluacion() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $evaluacionData = $_POST['evaluacion'];

            $evaluacion = new Evaluacion($evaluacionData);

            if ($evaluacion->guardar()) {
                header('Location: /configuracion/tipoevaluacion');
                exit;
            } else {
                echo "Error al guardar la evaluación.";
            }
        } else {
            header('Location: /configuracion/tipoevaluacion');
            exit;
        }
    }
    public static function crearAnio() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $anioData = $_POST['anio'];
    
            $anio = new Año($anioData);
    
            if ($anio->guardar()) {
                header('Location: /configuracion/escolar');
                exit;
            } else {
                echo "Error al guardar el año.";
            }
        } else {
            header('Location: /configuracion/escolar');
            exit;
        }
    }
    
}
