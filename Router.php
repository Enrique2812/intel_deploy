<?php

namespace MVC;

class Router
{

    public $rutasGet = [];
    public $rutasPost = [];
    public $rutasProtegidas = [];

    public function get($url, $fn, $protegida = false)
    {
        $this->rutasGet[$url] = $fn;
        if ($protegida) {
            $this->rutasProtegidas[] = $url;
        }
    }

    public function post($url, $fn, $protegida = false)
    {
        $this->rutasPost[$url] = $fn;
        if ($protegida) {
            $this->rutasProtegidas[] = $url;
        }
    }
    public function comprobarRutas()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $auth = $_SESSION['login'] ?? null;
        $paginasAsignadas = $_SESSION['paginas'] ?? [];

        $urlActual = $_SERVER['PATH_INFO'] ?? '/';
        $metodo = $_SERVER['REQUEST_METHOD'];

        // Dependencias de rutas
        $dependenciasRutas = [
            '/accesos/usuario' => ['/crear/usuario', '/editar/usuario', '/eliminar/usuario'],
            '/accesos/roles' => ['/crear/roles', '/editar/roles', '/eliminar/roles'],
            '/gestion/alumnos_aulas' => [],
            '/gestion/profesor_aula' => ['/crear/profesor_aula'],
            '/gestion/alumnos' => ['/crear/alumnos','/editar/alumnos','/eliminar/alumnos'],
            '/gestion/aulas' => ['/crear/aula','/editar/aula','/eliminar/aula','/gestion/obtenerGradosPorNivel'],
            '/gestion/cursos' => ['/crear/cursos','/editar/cursos','/eliminar/cursos'],
            '/gestion/grados' => [],
            '/gestion/profesores' => ['/crear/profesores','/eliminar/profesores','/editar/profesores'],
            '/gestion/secciones' => [],
            '/Tareas/alumno' => ['/Tareas/tareaAlumno','/Tareas/contenido'],
            '/Tareas/profesor' => ['/Tareas/tareaProfesor','/Tareas/asignacion','/Tareas/contenido'],
            '/calificaciones/calificacion' => ['/calificaciones/crear'],
            '/calificaciones/miscalificaciones' => [],
            '/calificaciones/vertodo' => [],
            '/asistencia/alumno' => ['/asistencia/buscarPorCorreoYRangoFechas'],
            '/asistencia/calendario' => [],
            '/asistencia/diariototal' => ['/asistencia/cargar-nivel','/asistencia/buscarPorDia'],
            '/asistencia/general' => ['/asistencia/vincular','/asistencia/buscarGeneral','/asistencia/obtenerAulasPorGrado','/asistencia/cargarAulasConSheets'],
            '/asistencia/horaio' => [],
            '/asistencia/registrar' => ['/asistencia/cambiarEstado','/asistencia/cargarAlumnos','/asistencia/registrar-ingreso','/asistencia/registrar-salida', '/asistencia/obtener-google-sheet-id', '/asistencia/vincular-google-sheet-id'],
            '/aristoteles/profesor' => ['/aristoteles/tarea','/aristoteles/crear','/aristoteles/contenido','/aristoteles/video','/aristoteles/estado','/aristoteles/getGradosByNivel','/aristoteles/crearTarea' ],
            '/aristoteles/alumno' => ['/aristoteles/contenido','/aristoteles/video',],
            '/configuracion/escolar' => ['/crear/anio'],
            '/Clases_en_vivo/ClaseVivo' => ['/Clases_en_vivo/alumno','/Clases_en_vivo/profesor','/Clases_en_vivo/crearvideoconferencia','/editar/ClaseVivo','/cambiarVision/ClaseVivo'],
            '/Contabilida/matricula-configuracion' => [],
            '/Pagos/pago' => [],
            // Otras dependencias de rutas
        ];

        // Verificar si la página actual o alguna dependiente está permitida
        $paginasPermitidas = array_column($paginasAsignadas, 'ruta');

        // Agregar rutas dependientes a la lista de páginas permitidas
        foreach ($paginasPermitidas as $pagina) {
            if (isset($dependenciasRutas[$pagina])) {
                $paginasPermitidas = array_merge($paginasPermitidas, $dependenciasRutas[$pagina]);
            }
        }

        // Encontrar la función asociada con la ruta actual
        if ($metodo === 'GET') {
            $fn = $this->rutasGet[$urlActual] ?? null;
        } else {
            $fn = $this->rutasPost[$urlActual] ?? null;
        }

        // Verificar si la ruta está protegida y si el usuario está autenticado
        if (in_array($urlActual, $this->rutasProtegidas) && !$auth) {
            header('location: /');
            exit;
        }

        // Verificar si la ruta está permitida
        if (!in_array($urlActual, $paginasPermitidas) && $auth) {
            header('location: /inicio');
            exit;
        }

        if ($fn) {
            call_user_func($fn, $this);
        } else {
            $this->error();
        }
    }


    public function render($view, $datos = [])
    {
        // debuguear($datos);
        foreach ($datos as $key => $value) {
            $$key = $value;
        }
        ob_start();

        include __DIR__ . "/views/$view.php";
        $contenido = ob_get_clean();
        include __DIR__ . "/views/layout.php";
    }
    public function error()
    {
        include __DIR__ . "/views/error.php";
    }

    public function renderLogin($datos = [])
    {
        // debuguear($datos);
        foreach ($datos as $key => $value) {
            $$key = $value;
        }

        include __DIR__ . "/views/login.php";
    }
}
