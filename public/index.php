<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../includes/app.php';

use Controllers\AccesosController;
use Controllers\GestionController;
use Controllers\LoginController;
use Controllers\TareasController;
use Controllers\AristotelesController;
use Controllers\AsistenciaController;
use Controllers\ConfiguracionController;
use Controllers\CalificacionController;
use Controllers\ClaseVivoController;
use Controllers\ContabilidadController;
use Controllers\PagosController;
use MVC\Router;

$router=new Router;

//login 
$router->get('/',[LoginController::class,'login']);
$router->post('/',[LoginController::class,'login']);
$router->get('/logout',[LoginController::class,'logout']);

// Crud de super 
$router->get('/inicio',[LoginController::class,'inicio'],true);



// modulo de acceso
$router->get('/accesos/usuario',[AccesosController::class,'usuario'],true);
$router->post('/crear/usuario',[AccesosController::class,'usuario'],true);
$router->get('/eliminar/usuario',[AccesosController::class,'eliminarUser'],true);
$router->post('/editar/usuario',[AccesosController::class,'editar'],true);

$router->get('/accesos/roles',[AccesosController::class,'roles'],true);
$router->post('/crear/roles',[AccesosController::class,'roles'],true);
$router->get('/eliminar/roles',[AccesosController::class,'eliminarRol'],true);
$router->post('/editar/roles',[AccesosController::class,'editarRol'],true);

// modulo de gestión
$router->get('/gestion/alumnos_aulas',[GestionController::class,'alumnoAula'],true);
$router->post('/gestion/alumnos_aulas',[GestionController::class,'alumnoAula'],true);

$router->get('/gestion/profesor_aula',[GestionController::class,'profesorAula'],true);
$router->post('/crear/profesor_aula',[GestionController::class,'crearProfesorAula'],true);

$router->get('/gestion/alumnos',[GestionController::class,'alumnos'],true);
$router->post('/crear/alumnos',[GestionController::class,'alumnos'],true);
$router->post('/editar/alumnos',[GestionController::class,'editarAlumnos'],true);
$router->get('/eliminar/alumnos',[GestionController::class,'eliminarAlumnos'],true);

$router->get('/gestion/cursos',[GestionController::class,'cursos'],true);
$router->get('/gestion/grados',[GestionController::class,'grados'],true);
$router->get('/gestion/profesores',[GestionController::class,'profesores'],true);
$router->post('/crear/profesores',[GestionController::class,'Profesores'],true);
$router->get('/eliminar/profesores',[GestionController::class,'eliminarProfesores'],true);
$router->post('/editar/profesores',[GestionController::class,'editarProfesores'],true);

$router->get('/gestion/aulas',[GestionController::class,'aulas'],true);
$router->post('/editar/aula',[GestionController::class,'editaraulas'],true);
$router->post('/crear/aula',[GestionController::class,'crearAula'],true);
$router->get('/crear/aula',[GestionController::class,'crearAula'],true);
$router->get('/eliminar/aula',[GestionController::class,'eliminaraulas'],true);

$router->get('/gestion/secciones',[GestionController::class,'secciones'],true);

// modulo de tareas
$router->get('/Tareas/alumno',[TareasController::class,'alumno'],true);
$router->get('/Tareas/profesor',[TareasController::class,'profesor'],true);
$router->get('/Tareas/asignacion',[TareasController::class,'crear'],true);
$router->post('/Tareas/asignacion',[TareasController::class,'crear'],true);
$router->get('/Tareas/contenido',[TareasController::class,'contenido'],true);
$router->post('/Tareas/contenido',[TareasController::class,'contenido'],true);


// modulo de aristoteles
$router->get('/aristoteles/profesor',[AristotelesController::class,'profesor'],true);
$router->get('/aristoteles/tarea',[AristotelesController::class,'tarea'],true);
$router->post('/aristoteles/tarea',[AristotelesController::class,'tarea'],true);
$router->post('/aristoteles/crearTarea',[AristotelesController::class,'crearTarea'],true);
$router->get('/aristoteles/estado',[AristotelesController::class,'estadoAristoteles'],true);

$router->get('/aristoteles/alumno',[AristotelesController::class,'alumno'],true);
$router->get('/aristoteles/contenido',[AristotelesController::class,'contenido'],true);
$router->get('/aristoteles/video',[AristotelesController::class,'video'],true);


// modulo de configuraicon
$router->get('/configuracion/escolar',[ConfiguracionController::class,'escolar'],true);
$router->post('/crear/anio', [ConfiguracionController::class, 'crearAnio']);
$router->get('/configuracion/tipoevaluacion',[ConfiguracionController::class,'tipoevaluacion'],true);

//modulo de cursos
$router->get('/gestion/cursos',[GestionController::class,'curso'],true);
$router->post('/crear/cursos',[GestionController::class,'crearCurso'],true);
$router->get('/crear/cursos',[GestionController::class,'crearCurso'],true);
$router->post('/editar/cursos',[GestionController::class,'editarCurso'],true);
$router->get('/eliminar/cursos',[GestionController::class,'eliminarCurso'],true);

////modulo calificaciones
//modulo de calificacion
$router->get('/calificaciones/calificacion',[CalificacionController::class,'calificacion'],true);
$router->post('/calificaciones/crear',[CalificacionController::class,'crear'],true);

//modulo de miscalificaciones
$router->get('/calificaciones/miscalificaciones',[CalificacionController::class,'miscalificaciones'],true);

//modulo de vertodo
$router->get('/calificaciones/vertodo',[CalificacionController::class,'vertodo'],true);


////modulo asistencia
//modulo de alumno
$router->get('/asistencia/alumno',[AsistenciaController::class,'alumno'],true);
$router->post('/asistencia/buscarPorCorreoYRangoFechas', [AsistenciaController::class, 'buscarPorCorreoYRangoFechas']);


//modulo de calendario
$router->get('/asistencia/calendario',[AsistenciaController::class,'calendario'],true);

//modulo de diario total
$router->get('/asistencia/diariototal',[AsistenciaController::class,'diariototal'],true);

$router->post('/asistencia/buscarPorDia',[AsistenciaController::class,'buscarPorDia'],true);


$router->post('/asistencia/cargar-nivel',[AsistenciaController::class,'cargarNivel'],true);

//modulo de general
$router->get('/asistencia/general',[AsistenciaController::class,'general'],true);
$router->get('/asistencia/cargarAulasConSheets',[AsistenciaController::class,'cargarAulasConSheets'],true);

//modulo de horario
$router->get('/asistencia/horario',[AsistenciaController::class,'horario'],true);
$router->post('/asistencia/horario',[AsistenciaController::class,'horario'],true);


// Ruta para cargar alumnos por aula
$router->get('/asistencia/cargarAlumnos', [AsistenciaController::class, 'cargarAlumnos']);

// Ruta para registrar ingreso
$router->post('/asistencia/registrar-ingreso', [AsistenciaController::class, 'registrarIngreso']);

// Ruta para registrar salida
$router->post('/asistencia/registrar-salida', [AsistenciaController::class, 'registrarSalida']);

//modulo de registrar
$router->get('/asistencia/registrar',[AsistenciaController::class,'registrar'],true);
$router->post('/asistencia/registrar',[AsistenciaController::class,'registrar'],true);
$router->post('/asistencia/cambiarEstado', [AsistenciaController::class, 'cambiarEstado']);
$router->post('/asistencia/vincular', [AsistenciaController::class, 'vincularGoogleSheet']);

$router->get('/asistencia/buscarGeneral', [AsistenciaController::class, 'buscarGeneral']);
$router->get('/asistencia/obtenerAulasPorGrado', [AsistenciaController::class, 'obtenerAulasPorGrado']);

//modulo de clases en vivo
$router->get('/Clases_en_vivo/ClaseVivo',[ClaseVivoController::class,'vista'],true);
$router->post('/Clases_en_vivo/crearvideoconferencia',[ClaseVivoController::class,'crearvideoconferencia'],true);
$router->post('/editar/ClaseVivo',[ClaseVivoController::class,'editar'],true);
$router->post('/cambiarVision/ClaseVivo',[ClaseVivoController::class,'cambiarVision'],true);

//modulo de contrabilidad
$router->get('/Contabilida/matricula-configuracion',[ContabilidadController::class,'matriculaConfiguracion'],true);

//modulo de pagos
$router->get('/Pagos/pago',[PagosController::class,'pago'],true);

$router->post('/gestion/obtenerGradosPorNivel', [GestionController::class, 'obtenerGradosPorNivel'], true);

$router->comprobarRutas();