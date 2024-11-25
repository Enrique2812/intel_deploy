<?php 

namespace Controllers;

use MVC\Router;

class ContabilidadController{
    public static function matriculaConfiguracion(Router $router){
        
        $CurrentPage='table-datatable-basic';


        $router->render('home/Contabilida/matricula-configuracion',[
            'CurrentPage'=>$CurrentPage
        ]);
    }
    
}