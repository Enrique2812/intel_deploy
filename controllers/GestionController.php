<?php

namespace Controllers;

use Model\Alumno;
use Model\Aula;
use Model\Aula_personal_curso;
use Model\Grado;
use Model\Nivel;
use Model\Profesor;
use Model\Seccion;
use Model\Turno;
use Model\Usuario;
use Model\Curso;
use Model\Matricula;
use Model\Año;
use MVC\Router;
use Helpers\AñoHelper;


class GestionController
{
    public static function alumnoAula(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $año = null;

        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);
        }

        $aulas = $año ? Aula::allByIdAño($año->id) : Aula::all();
        $niveles = Nivel::all();
        $grados = Grado::all();
        $secciones = Seccion::all();
        $turnos = Turno::all();
        $alumnos = Alumno::all();
        $usuarios = Usuario::all();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matricula = new Matricula($_POST['matricula']);

            if ($matricula) {
                // Guardar los permisos para las páginas seleccionadas
                foreach ($_POST['alumnos'] as $alumnos_id) {
                    $matricula->crearCursos($alumnos_id);
                }
                header('Location: /gestion/alumnos_aulas');
                exit;
            }
        }

        $router->render('home/gestion/alumnos_aulas', [
            'CurrentPage' => $CurrentPage,
            'aulas' => $aulas,
            'niveles' => $niveles,
            'grados' => $grados,
            'secciones' => $secciones,
            'turnos' => $turnos,
            'alumnos' => $alumnos,
            'usuarios' => $usuarios,
            'selectedYear' => $selectedYear,
            'año' => $año
        ]);
    }


    public static function profesorAula(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $año = null;



        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);
        }

        $aulas = $año ? Aula::allByIdAño($año->id) : Aula::all();

        $profesores = Profesor::all();
        $niveles = Nivel::all();
        $grados = Grado::all();
        $secciones = Seccion::all();
        $turnos = Turno::all();
        $cursos = Curso::all();
        $cursos_personal = Aula_personal_curso::all();
        $usuarios = Usuario::all();

        $router->render('home/gestion/profesor_aulas', [
            'CurrentPage' => $CurrentPage,
            'aulas' => $aulas,
            'niveles' => $niveles,
            'grados' => $grados,
            'secciones' => $secciones,
            'turnos' => $turnos,
            'profesores' => $profesores,
            'usuarios' => $usuarios,
            'cursos' => $cursos,
            'cursos_personal' => $cursos_personal,
            'selectedYear' => $selectedYear,
            'año' => $año
        ]);
    }



    public static function crearProfesorAula(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $año = null;



        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);
        }

        $aulas = $año ? Aula::allByIdAño($año->id) : Aula::all();

        $profesores = $año ? Usuario::allByIdAñoProfesor($año->id) : Profesor::all(); // Usa el método que ya tienes


        $niveles = Nivel::all();
        $grados = Grado::all();
        $secciones = Seccion::all();
        $turnos = Turno::all();

        $cursos = Curso::all();
        $cursos_personal = Aula_personal_curso::all();
        $usuarios = Usuario::all();



        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Recibimos el array de persona_curso[] enviado desde el formulario
            $persona_curso_array = $_POST['persona_curso'];

            // Iteramos sobre cada conjunto de datos del array
            foreach ($persona_curso_array as $persona_curso_data) {
                // Creamos una nueva instancia de Aula_personal_curso para cada conjunto de datos
                $persona_curso = new Aula_personal_curso($persona_curso_data);

                // Guardamos cada conjunto de datos en la base de datos
                $resultado = $persona_curso->guardar();

                // Puedes agregar validación de resultados aquí, pero por simplicidad
                // asumiremos que todos los guardados se procesan correctamente
            }

            // Si todo se guarda correctamente, redirigimos al usuario
            if ($resultado) {
                header('Location: /gestion/profesor_aula?resultado=2');
            }
        }


        $router->render('home/gestion/profesor_aulas', [
            'CurrentPage' => $CurrentPage,
            'aulas' => $aulas,
            'niveles' => $niveles,
            'grados' => $grados,
            'secciones' => $secciones,
            'turnos' => $turnos,
            'profesores' => $profesores,
            'usuarios' => $usuarios,
            'cursos' => $cursos,
            'cursos_personal' => $cursos_personal
        ]);
    }

    public static function alumnos(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $usuario = new Usuario();
        $errores = Usuario::getErrores();

        $selectedYear = $_SESSION['selectedYear'] ?? null;

        $año = null;

        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);

            if ($año) {
                $usuarios = Usuario::allAlumno();
            } else {
                $usuarios = [];
            }
        } else {
            $usuarios = [];
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuarioData = $_POST['usuario'] ?? [];

            // Encriptar la contraseña si está presente
            if (!empty($usuarioData['password'])) {
                $usuarioData['password'] = password_hash($usuarioData['password'], PASSWORD_BCRYPT);
            }

            if ($año) {
                $usuarioData['idaño'] = $año->id;
            }

            $usuario = new Usuario($usuarioData);

            // Validar los datos
            $errores = $usuario->validar();

            if (empty($errores)) {
                $resultado = $usuario->guardar();

                if ($resultado) {
                    $alumno = new Alumno(['id_usuario' => $usuario->id]);
                    $resultado = $alumno->guardar();

                    if ($resultado) {
                        header('Location: /gestion/alumnos');
                        exit;
                    }
                } else {
                    $errores = Usuario::getErrores();
                }
            }
        }

        // Renderizar la vista
        $router->render('home/gestion/alumnos', [
            'CurrentPage' => $CurrentPage,
            'usuario' => $usuario,
            'usuarios' => $usuarios,
            'errores' => $errores,
            'año' => $año,
        ]);
    }


    public static function eliminarAlumnos()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $usuario = Usuario::find($id);
                $alumno = Alumno::find($usuario->id);
                // elimina la propiedad
                $resultado = $alumno->eliminar();
                if ($resultado) {
                    header('Location: /gestion/alumnos?resultado=3');
                }
            }
        }
    }
    public static function editarAlumnos(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Alumno::getErrores();

        $usuario = new Usuario();
        $alumno = new Alumno();
        $usuarios = Usuario::allalumno();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario = new Usuario($_POST['usuario']);
            $errores = $usuario->validar();
            $_POST['usuario']['password'] = password_hash($_POST['usuario']['password'], PASSWORD_BCRYPT);

            // debuguear($_POST['usuario']);
            $usuario = new Usuario($_POST['usuario']);

            //revisar que el array de errores este vacio
            if (empty($errores)) {
                // debuguear($usuario);
                $resultado = $usuario->guardar();
                // debuguear($resultado);
                if ($resultado) {
                    if ($resultado) {
                        header('Location: /gestion/alumnos');
                    }
                } else {
                    $errores = Usuario::getErrores();
                }
            }
        }

        $router->render('home/gestion/alumnos', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'usuario' => $usuario,
            'alumno' => $alumno,
            'usuarios' => $usuarios
        ]);
    }
    public static function cursos(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $router->render('home/gestion/cursos', [
            'CurrentPage' => $CurrentPage
        ]);
    }
    public static function grados(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $router->render('home/gestion/grados', [
            'CurrentPage' => $CurrentPage
        ]);
    }
    public static function profesores(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Profesor::getErrores();

        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $añosDisponibles = $GLOBALS['añosDisponibles'] ?? null;

        $usuario = new Usuario();
        $profesor = new Profesor();
        $usuarios = [];
        $profesores = Profesor::all();
        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);

            if ($año) {
                $usuarios = Usuario::allProfesor();
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['usuario']['password'] = password_hash($_POST['usuario']['password'], PASSWORD_BCRYPT);

            $usuario = new Usuario($_POST['usuario']);

            if ($año) {
                $usuario->idaño = $año->id;
            }

            $tipo = $_POST['tutor'];
            $errores = $usuario->validar();

            if (empty($errores)) {
                // Guardar el usuario
                $resultado = $usuario->guardar();
                if ($resultado) {
                    $profesor = new Profesor(['id_usuario' => $usuario->id, 'tutor' => $tipo, 'estadoAula' => '0']);
                    $resultado = $profesor->guardar();

                    if ($resultado) {
                        header('Location: /gestion/profesores');
                        exit;
                    } else {
                        $errores = Profesor::getErrores(); // Cargar errores si falla el guardado del profesor
                    }
                } else {
                    $errores = Usuario::getErrores(); // Cargar errores si falla el guardado del usuario
                }
            }
        }


        $router->render('home/gestion/profesores', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'usuario' => $usuario,
            'profesor' => $profesor,
            'usuarios' => $usuarios,
            'añosDisponibles' => $añosDisponibles,
            'selectedYear' => $selectedYear,
            'profesores' => $profesores,
            'año' => $año
        ]);
    }

    public static function editarProfesores(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Profesor::getErrores();
    
        $usuario = new Usuario();
        $profesor = new Profesor();
        $profesores = Profesor::all();
        $usuarios = Usuario::allProfesor();
    
        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $año = null;
    
        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);
            if (!$año) {
                $errores[] = "El año seleccionado no existe en la base de datos.";
            }
        }
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['usuario']['password'] = password_hash($_POST['usuario']['password'], PASSWORD_BCRYPT);
            $usuario = new Usuario($_POST['usuario']);
            
            if ($año) {
                $usuario->idaño = $año->id;
            } else {
                $errores[] = "No se pudo asignar el año porque no existe.";
            }
    
            $errores = $usuario->validar();
            if (empty($errores)) {
                $resultado = $usuario->guardar();
    
                if ($resultado) {
                    $_POST['profesor']['id_usuario'] = $usuario->id;
                    $profesor = new Profesor($_POST['profesor']);
    
                    $errores = $profesor->validar();
                    if (empty($errores)) {
                        $resultado = $profesor->guardar();
                        if ($resultado) {
                            header('Location: /gestion/profesores');
                            exit;
                        }
                    }
                } else {
                    $errores = Usuario::getErrores();
                }
            }
        }
    
        // Renderizar la vista con los datos necesarios
        $router->render('home/gestion/profesores', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'usuario' => $usuario,
            'profesor' => $profesor,
            'profesores' => $profesores,
            'usuarios' => $usuarios
        ]);
    }
    public static function eliminarProfesores()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $usuario = Usuario::find($id);
                $profesor = Profesor::find($usuario->id);
                // elimina la propiedad 
                $resultado = $profesor->eliminar();
                // debuguear($resultado);
                // debuguear($usuario);
                if ($resultado) {
                    header('Location: /gestion/profesores?resultado=3');
                }
            }
        }
    }
    public static function secciones(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $router->render('home/gestion/secciones', [
            'CurrentPage' => $CurrentPage
        ]);
    }

    //secion de aulas aaron //////////////////////////////////////////////////
    public static function aulas(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $aula = new Aula();
        $grados = Grado::all();
        $niveles = Nivel::all();
        $turnos = Turno::all();
        $usuarios = Usuario::all();
        $profesores = Profesor::all();
        $secciones = Seccion::all();
        $cursos = Curso::all();
        $errores = Aula::getErrores();

        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $aulas = [];

        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);

            if ($año) {
                $aulas = Aula::allByIdAño($año->id);
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aula = new Aula($_POST['aula']);
            $errores = $aula->validar();
            if (empty($errores)) {
                $resultado = $aula->guardar();
                if ($resultado) {
                    header('Location: /gestion/aulas');
                    exit;
                }
            }
        }

        $router->render('home/gestion/aulas', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'aula' => $aula,
            'aulas' => $aulas,
            'grados' => $grados,
            'niveles' => $niveles,
            'turnos' => $turnos,
            'profesores' => $profesores,
            'usuarios' => $usuarios,
            'cursos' => $cursos,
            'secciones' => $secciones,
            'año' => $año
        ]);
    }


    public static function crearAula(Router $router)
    {
        $CurrentPage = 'uc-select2';
        $aula = new Aula();
        $grados = Grado::all();
        $niveles = Nivel::all();
        $turnos = Turno::all();
        $secciones = Seccion::all();
        $cursos = Curso::all();
        $profesores = Profesor::all();
        $usuarios = Usuario::all();
        $errores = Aula::getErrores();

        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $año = null;

        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aula = new Aula($_POST['aula']);
            $profesorEdit=Profesor::findProfesor($aula->tutor);

            $profesorEdit->estadoAula=1;
            if ($año) {
                $aula->id_año = $año->id;
            }

            $errores = $aula->validar();
            if (empty($errores)) {
                $resultado = $aula->guardar();
                $profesorEdit->guardar();
                if ($resultado) {
                    foreach ($_POST['cursos'] as $cursos_id) {
                        $aula->crearCursos($cursos_id);
                    }

                    header('Location: /gestion/aulas');
                    exit;
                }
            }
        }

        $router->render('home/gestion/crearAula', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'aula' => $aula,
            'grados' => $grados,
            'niveles' => $niveles,
            'turnos' => $turnos,
            'profesores' => $profesores,
            'cursos' => $cursos,
            'secciones' => $secciones,
            'usuarios' => $usuarios,

        ]);
    }


    public static function eliminaraulas()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $aula = Aula::find($id);
                if ($aula) { // Verifica que el aula exista
                    $resultado = $aula->eliminarAula(); // Llama al nuevo método
                    if ($resultado) {
                        header('Location: /gestion/aulas?resultado=3');
                    } else {
                        header('Location: /gestion/aulas?resultado=error'); // O cualquier otro mensaje que quieras
                    }
                } else {
                    header('Location: /gestion/aulas?resultado=no_encontrado');
                }
            }
        }
    }



    public static function editaraulas(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Aula::getErrores();
        $aula = new Aula();
        $aulas = Aula::all();

        // Obtener los datos necesarios para la vista
        $niveles = Nivel::all();
        $grados = Grado::all();
        $profesores = Profesor::all();
        $turnos = Turno::all();
        $usuarios = Usuario::all();  // Asegúrate de que esta función existe
        $secciones = Seccion::all();  // Asegúrate de que esta función existe

        // Captura del año seleccionado de la sesión
        $selectedYear = $_SESSION['selectedYear'] ?? null;
        $año = null;

        if ($selectedYear) {
            $año = Año::findByNumero($selectedYear);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $aula = new Aula($_POST['aula']);

            // Asigna el ID del año a la instancia de Aula
            if ($año) {
                $aula->id_año = $año->id;
            }

            // Validar y guardar en la base de datos
            $errores = $aula->validar();
            if (empty($errores)) {
                $resultado = $aula->guardar();
                if ($resultado) {
                    // Redireccionar al usuario
                    header('Location: /gestion/aulas?resultado=2');
                    exit;
                }
            }
        }

        // Pasar los datos a la vista
        $router->render('home/gestion/aulas', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'aula' => $aula,
            'aulas' => $aulas,
            'niveles' => $niveles,
            'grados' => $grados,
            'profesores' => $profesores,
            'turnos' => $turnos,
            'usuarios' => $usuarios,
            'secciones' => $secciones
        ]);
    }





    // CURSO AARON ////////////////////////////////////////////////////////
    public static function curso(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $curso = new Curso();
        $cursos = Curso::all();
        $errores = Curso::getErrores();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $curso = new Curso($_POST['curso']);
            //  debuguear($aula);
            $errores = $curso->validar();
            if (empty($errores)) {
                $resultado = $curso->guardar();
                if ($resultado) {
                    header('Location: /gestion/cursos');
                }
            }
        }
        $router->render('home/gestion/cursos', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'cursos' => $cursos,
            'curso' => $curso
        ]);
    }

    public static function eliminarCurso()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $curso = Curso::find($id);
                // elimina la propiedad 
                $resultado = $curso->eliminar();
                // debuguear($usuario);
                if ($resultado) {
                    header('Location: /gestion/cursos?resultado=3');
                }
            }
        }
    }

    public static function editarCurso(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Curso::getErrores();

        $curso = new Curso();
        $cursos = Curso::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {



            $curso = new Curso($_POST['curso']);
            // debuguear($_POST['curso']);

            //revisar que el array de errores este vacio
            $errores = $curso->validar();

            if (empty($errores)) {
                $resultado = $curso->guardar();
                if ($resultado) {
                    //redirecionar al usuario
                    header('Location: /gestion/cursos?resultado=2');
                }
            }
        }

        $router->render('home/gestion/cursos', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'curso' => $curso,
            'cursos' => $cursos
        ]);
    }

    public static function crearCurso(Router $router)
    {
        $CurrentPage = 'uc-select2';
        $curso = new Curso();
        $cursos =   Curso::all();
        $errores = Curso::getErrores();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {


            $curso = new Curso($_POST['curso']);
            //  debuguear($aula);
            $errores = $curso->validar();
            if (empty($errores)) {
                $resultado = $curso->guardar();
                if ($resultado) {
                    header('Location: /gestion/cursos');
                }
            }
        }
        $router->render('home/gestion/crearCurso', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'curso' => $curso,
            'cursos' => $cursos

        ]);
    }

    public static function obtenerGradosPorNivel()
    {
        if (isset($_POST['nivelId'])) {
            $nivelId = intval($_POST['nivelId']);  // Convertimos a entero por seguridad

            $query = "SELECT * FROM grado WHERE id_nivel = $nivelId";
            $result = Grado::consultarSQL($query);

            if ($result) {
                echo json_encode($result);
            } else {
                echo json_encode(['error' => 'No se encontraron grados para el nivel seleccionado']);
            }
        } else {
            echo json_encode(['error' => 'No se recibió un ID de nivel válido']);
        }
    }
}
