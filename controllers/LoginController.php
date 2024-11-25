<?php

namespace Controllers;

use Model\Alumno;
use Model\Aula;
use Model\Aula_personal_curso;
use Model\Matricula;
use Model\Pagina;
use Model\Profesor;
use Model\Usuario;
use MVC\Router;

class LoginController
{

    public static function inicio(Router $router)
    {
        $CurrentPage = 'index';
        $router->render('home/inicio', [
            'CurrentPage' => $CurrentPage
        ]);
    }

    public static function login(Router $router)
    {
        $CurrentPage = 'page-login';
        $usuario = new Usuario();
        $errores = Usuario::getErrores();
        //ejecutar el codigo despues de que el usuario envia el formulario 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = new Usuario($_POST);
            $errores = $usuario->validarLogin();
            // debuguear($usuario);
            if (empty($errores)) {
                $resultado = $usuario->existeUsuario();
                if (!$resultado) {
                    $errores = Usuario::getErrores();
                } else {
                    $autenticacion = $usuario->comprobarPassword($resultado);
                    if ($autenticacion) {
                        $usuario->autenticar();

                        $_SESSION['paginas'] = Pagina::obtenerPaginasPorRol($usuario->id_rol);

                        // Agregar /inicio como una página siempre accesible
                        $_SESSION['paginas'][] = (object)[
                            'id' => null,
                            'nombre' => 'Inicio',
                            'ruta' => '/inicio',
                            'id_modulo' => null
                        ];
                        // Agregar /inicio como una página siempre accesible
                        $_SESSION['paginas'][] = (object)[
                            'id' => null,
                            'nombre' => 'Logout',
                            'ruta' => '/logout',
                            'id_modulo' => null
                        ];
                        
                        if ($_SESSION['rol'] === '4') {
                            $Alumno = Alumno::find($usuario->id);
                            if ($Alumno) {
                                $matricula = Matricula::findAula($Alumno->id);
                                $_SESSION['id_alumno'] = $Alumno->id;
                                if ($matricula) {
                                    $_SESSION['matricula'] = '1';
                                    $_SESSION['id_aula'] = $matricula[0]->id_aula;
                                } else {
                                    $_SESSION['matricula'] = '0';
                                }
                            }
                        } else if ($_SESSION['rol'] === '5') {
                            $profesor = Profesor::find($usuario->id);
                            if ($profesor) {
                                if ($profesor->tutor === '1') {
                                    $_SESSION['id_aulas'] = Aula_personal_curso::findPersonal($profesor->id);
                                    $aula = Aula::findAulaTutor($profesor->id);
                                    $_SESSION['id_profesor'] = $profesor->id;
                                    $_SESSION['tutor'] = '1';
                                    if ($aula) {
                                        $_SESSION['id_aula'] = $aula[0]->id;
                                    }
                                } else if ($profesor->tutor === '0') {
                                    $_SESSION['id_profesor'] = $profesor->id;
                                    $_SESSION['tutor'] = '0';
                                }
                            }
                        }

                        header('location: /inicio');
                    } else {
                        $errores = Usuario::getErrores();
                    }
                }
            }
        }
        $router->renderLogin([
            'CurrentPage' => $CurrentPage,
            'usuario' => $usuario,
            'errores' => $errores
        ]);
    }

    public static function logout()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];
        header('location: /');
    }
}
