<?php

namespace Controllers;

use Model\Pagina;
use Model\Permiso;
use Model\Rol;
use Model\Usuario;
use MVC\Router;

class AccesosController
{

    public static function roles(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Rol::getErrores();
        $rol = new Rol();
        $roles = Rol::all();
        $paginas = Pagina::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $rol = new Rol($_POST['rol']);
            $errores = $rol->validar();

            if (empty($errores)) {
                // Guardar el rol primero y obtener el ID
                $rol->guardar();

                // Guardar los permisos para las páginas seleccionadas
                foreach ($_POST['paginas'] as $pagina_id) {
                    $rol->crearPermisos($pagina_id);
                }

                header('Location: /accesos/roles');
            }
        }

        // Enviar las páginas y los roles al template
        $router->render('home/accesos/roles', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'roles' => $roles,
            'rol' => $rol,
            'paginas' => $paginas,
        ]);
    }
    public static function eliminarRol()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $rol = Rol::find($id);
                // elimina la propiedad 
                $resultado = $rol->eliminar();
                // debuguear($usuario);
                if ($resultado) {
                    header('Location: /accesos/roles?resultado=3');
                }
            }
        }
    }
    public static function editarRol(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Rol::getErrores();
        $rol = new Rol();
        $roles = Rol::all();
        $paginas = Pagina::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            
            $rol = new Rol($_POST['rol']);
            
            //revisar que el array de errores este vacio
            $errores = $rol->validar();
            
            if (empty($errores)) {
                $resultado = $rol->guardar();
                
                if ($resultado) {
                    $resultado = $rol->eliminarPermiso();
                    if ($resultado) {
                        // Guardar los permisos para las páginas seleccionadas
                        foreach ($_POST['paginas'] as $pagina_id) {
                            $rol->crearPermisos($pagina_id);
                        }
                        //redirecionar al usuario
                        header('Location: /accesos/roles?resultado=2');
                    }
                }
            }
        }

        $router->render('home/accesos/roles', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'roles' => $roles,
            'paginas' => $paginas,
            'rol' => $rol
        ]);
    }
    public static function usuario(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $usuario = new Usuario();
        $roles = Rol::all();
        $usuarios = Usuario::all();
        $errores = Usuario::getErrores();

        //ejecutar el codigo despues de que el usuario envia el formulario 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {         
            $usuario = new Usuario($_POST['usuario']);
            // debuguear($usuario);
            $errores = $usuario->validar();
            
            $_POST['usuario']['password'] = password_hash($_POST['usuario']['password'], PASSWORD_BCRYPT);
            $usuario = new Usuario($_POST['usuario']);
            //revisar que el array de errores este vacio
            if (empty($errores)) {
                $resultado = $usuario->guardar();
                if ($resultado) {
                    header('Location: /accesos/usuario');
                }else{
                    $errores=Usuario::getErrores();
                }
            }
        }

        $router->render('home/accesos/usuario', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'usuario' => $usuario,
            'usuarios' => $usuarios,
            'roles' => $roles
        ]);
    }

    public static function eliminarUser()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $usuario = Usuario::find($id);
                // elimina la propiedad 
                $resultado = $usuario->eliminar();
                // debuguear($usuario);
                if ($resultado) {
                    header('Location: /accesos/usuario?resultado=3');
                }
            }
        }
    }
    public static function editar(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Usuario::getErrores();

        $usuario = new Usuario();
        $usuarios = Usuario::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $_POST['usuario']['password'] = password_hash($_POST['usuario']['password'], PASSWORD_BCRYPT);

            $usuario = new Usuario($_POST['usuario']);
            // debuguear($usuario);

            //revisar que el array de errores este vacio
            $errores = $usuario->validar();

            if (empty($errores)) {
                $resultado = $usuario->guardar();
                if ($resultado) {
                    //redirecionar al usuario
                    header('Location: /accesos/usuario?resultado=2');
                }
            }
        }

        $router->render('home/accesos/usuario', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'usuario' => $usuario,
            'usuarios' => $usuarios
        ]);
    }
    
}
