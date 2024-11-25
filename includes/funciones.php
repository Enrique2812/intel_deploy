<?php


define('TEMPLATES_URL', __DIR__ . '/template');
define('FUNCIONES_URL', 'funciones.php');
define('CARPETA_ARISTOTELES', $_SERVER['DOCUMENT_ROOT'] . '/archivos/');
define('CARPETA_IMAGEN', $_SERVER['DOCUMENT_ROOT'] . '/imagenes/');
define('CARPETA_TAREA', $_SERVER['DOCUMENT_ROOT'] . '/tareasAsignadas/');
define('CARPETA_TAREA_Alumno', $_SERVER['DOCUMENT_ROOT'] . '/alumnosTareas/');



function incluirTemplate(string $nombre, bool $inicio = false)
{
    include TEMPLATES_URL . "/{$nombre}.php";
}

function estaAutenticado()
{
    session_start();

    if (!$_SESSION['login']) {
        header('location: /bienes_raices/index.php');
    }
}

function debuguear($variable)
{
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

function s($html)
{
    $s = htmlspecialchars($html);
    return $s;
}

function validarTipoContenido($tipo)
{
    $tipos = ['propiedad', 'vendedor'];
    return in_array($tipo, $tipos);
}

// Muestra los mensajes
function mostrarNotificacion($codigo)
{
    $mensaje = '';

    switch ($codigo) {
        case 1:
            $mensaje = 'Creada Correctamente';
            break;
        case 2:
            $mensaje = 'Actualizada Correctamente';
            break;
        case 3:
            $mensaje = 'Eliminada Correctamente';
            break;
        default:
            $mensaje = false;
            break;
    }
    return $mensaje;
}

function validarRedirrecionar(string $url)
{
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if (!$id) {
        header('Location: ${url}');
    }

    return $id;
}

function valiadarContenidoAristoteles(string $url)
{
    $Ari = $_GET['A'];
    $Ari = filter_var($Ari, FILTER_VALIDATE_INT);

    if (!$Ari) {
        header('Location: ${url}');
    }

    return $Ari;
}

function guardarArchivo($archivo) {
    $nombreArchivo = md5(uniqid(rand(), true)) . ".pdf";
    move_uploaded_file($archivo['tmp_name'],CARPETA_ARISTOTELES . $nombreArchivo);
    return $nombreArchivo;
}

function guardarTareas($archivo) {
    $nombreArchivo = md5(uniqid(rand(), true)) . ".pdf";
    // debuguear($archivo);
    move_uploaded_file($archivo,CARPETA_TAREA . $nombreArchivo);
    return $nombreArchivo;
}

function guardarTareasAlumno($archivo) {
    $nombreArchivo = md5(uniqid(rand(), true)) . ".pdf";
    // debuguear($archivo);
    move_uploaded_file($archivo,CARPETA_TAREA_Alumno . $nombreArchivo);
    return $nombreArchivo;
}
