<?php 

namespace Controllers;

use MVC\Router;

class PagosController{
    public static function pago(Router $router){
        
        $CurrentPage='table-datatable-basic';


        $router->render('home/Pagos/pago',[
            'CurrentPage'=>$CurrentPage
        ]);
    }
    
}