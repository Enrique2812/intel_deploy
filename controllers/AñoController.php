<?php
namespace Controllers;


use Model\Año; // Asegúrate de incluir el modelo Año

class AñoController {
    public static function obtenerAños() {
        return Año::todos();
    }
}
