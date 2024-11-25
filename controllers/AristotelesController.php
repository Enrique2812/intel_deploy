<?php

namespace Controllers;

use Model\Aristoteles;
use Model\Aula;
use Model\Curso;
use Model\Grado;
use Model\Nivel;
use Model\Seccion;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Alumno;
use Model\Alumno_tarea;
use Model\Aula_personal_curso;
use Model\Matricula;
use Model\Tarea;
use Model\Tipo_evaluacion;
use Model\Usuario;

class AristotelesController
{
    public static function profesor(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $aristoteles = Aristoteles::all();
        $buscaAula = new Aula();
        $buscaNivel = new Nivel();
        $buscaGrado = new Grado();
        $buscaSeccion = new Seccion();
        $buscaCurso = new Curso();
        $aulas = Aula::all();
        $niveles = Nivel::all();
        $grados = Grado::all();
        $secciones = Seccion::all();
        $cursos = Curso::all();
        $aulasPermitidas = '';
        if ($_SESSION['rol'] === '5') {
            $aulasPermitidas = Aula_personal_curso::findPersonal($_SESSION['id_profesor']);
        }
        $router->render('home/aristoteles/profesor', [
            'CurrentPage' => $CurrentPage,
            'aristoteles' => $aristoteles,
            'buscaAula' => $buscaAula,
            'buscaNivel' => $buscaNivel,
            'buscaGrado' => $buscaGrado,
            'buscaCurso' => $buscaCurso,
            'buscaSeccion' => $buscaSeccion,
            'aulasPermitidas' => $aulasPermitidas,
            'aulas' => $aulas,
            'niveles' => $niveles,
            'grados' => $grados,
            'secciones' => $secciones,
            'cursos' => $cursos
        ]);
    }
    public static function alumno(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $buscaAula = new Aula();
        $buscaNivel = new Nivel();
        $buscaGrado = new Grado();
        $buscaSeccion = new Seccion();
        $buscaCurso = new Curso();
        $cursos = Curso::all();
        $niveles = Nivel::all();
        $grados = Grado::all();
        $secciones = Seccion::all();
        $aulaAlumno = '';

        if ($_SESSION['rol'] === '4' && $_SESSION['matricula'] === '1') {
            $aulaAlumno = Aula_personal_curso::findCursoAula($_SESSION['id_aula']);
        }
        $aristoteles = Aristoteles::all();
        $router->render('home/aristoteles/alumno', [
            'CurrentPage' => $CurrentPage,
            'buscaAula' => $buscaAula,
            'buscaNivel' => $buscaNivel,
            'buscaGrado' => $buscaGrado,
            'buscaCurso' => $buscaCurso,
            'buscaSeccion' => $buscaSeccion,
            'niveles' => $niveles,
            'grados' => $grados,
            'secciones' => $secciones,
            'cursos' => $cursos,
            'aulaAlumno' => $aulaAlumno,
            'aristoteles' => $aristoteles
        ]);
    }
    public static function tarea(Router $router)
    {
        $CurrentPage = 'form-ckeditor';

        $aulasPermitidas = Aula_personal_curso::findPersonal($_SESSION['id_profesor']);
        $niveles = Nivel::all();
        $grados = Grado::all();
        $secciones = Seccion::all();
        $cursos = Curso::all();
        $aulas = Aula::all();
        $id_curso = '';
        $id_aula = '';
        $brusquedad = false;
        $errores = Aristoteles::getErrores();
        // Verifica si se envían datos para crear una tarea
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['buscar'])) {
                // Sincroniza con los datos enviados
                $id_curso = $_POST['id_curso'];
                $id_aula = $_POST['id_aula'];
                $brusquedad = true;
            }
            if (isset($_POST['registrar'])) {
                $url_video = $_POST['urlVideo'];

                // Verificar si es un enlace largo de YouTube (youtube.com/watch?v=VIDEO_ID)
                if (strpos($url_video, 'watch?v=') !== false) {
                    $video_id = explode('watch?v=', $url_video)[1];
                    $video_id = explode('&', $video_id)[0];  // Para eliminar posibles parámetros adicionales
                    $url_embed = 'https://www.youtube.com/embed/' . $video_id;

                    // Verificar si es un enlace corto de YouTube (youtu.be/VIDEO_ID)
                } elseif (strpos($url_video, 'youtu.be/') !== false) {
                    $video_id = explode('youtu.be/', $url_video)[1];
                    $url_embed = 'https://www.youtube.com/embed/' . $video_id;
                }

                // debuguear($_FILES);
                // Procesar los datos del formulario
                $aristoteles = new Aristoteles([
                    'titulo' => $_POST['titulo'],
                    'id_curso' => $_POST['id_curso'],
                    'id_aula' => $_POST['id_aula'],
                    'id_tarea' => $_POST['id_tarea'],
                    'urlVideo' => $url_embed
                ]);

                //generar un nombre unico
                // Procesar los archivos si se subieron
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] == UPLOAD_ERR_OK) {
                    $nombreImagen = md5(uniqid(rand(), true)) . '.jpg';
                    $imagen = Image::make($_FILES['imagen']['tmp_name'])->fit(1920, 1080);
                    $aristoteles->setImagen($nombreImagen);
                }

                $errores = $aristoteles->validar();

                // Procesar los archivos adicionales si se subieron
                $camposArchivo = [
                    'pd_teoria' => 'pd_teoria',
                    'pd_practica' => 'pd_practica',
                    'pd_problemas_resueltos' => 'pd_problemas_resueltos',
                    'pd_esquemas' => 'pd_esquemas',
                    'pd_tiempo' => 'pd_tiempo',
                    'pd_lectura' => 'pd_lectura',
                    'pd_retroalimentacion' => 'pd_retroalimentacion',
                ];

                foreach ($camposArchivo as $campo => $atributo) {
                    if (isset($_FILES[$campo]) && $_FILES[$campo]['error'] == UPLOAD_ERR_OK) {
                        $nombreArchivo = guardarArchivo($_FILES[$campo]);
                        $aristoteles->$atributo = $nombreArchivo;
                    }
                }

                if (empty($errores)) {
                    // Crear la carpeta para subir imágenes si no existe
                    if (!is_dir(CARPETA_IMAGEN)) {
                        mkdir(CARPETA_IMAGEN);
                    }

                    // Guardar la información en la base de datos
                    $resultado = $aristoteles->guardar();

                    // Almacenar la imagen solo si se subió una
                    if ($nombreImagen && isset($imagen)) {
                        $imagen->save(CARPETA_IMAGEN . $nombreImagen);
                    }

                    // Redirigir si el guardado fue exitoso
                    if ($resultado) {
                        header('Location: /aristoteles/tarea');
                        exit;
                    }
                }
            }
            // debuguear($_POST);
        }

        $router->render('home/aristoteles/tarea', [
            'CurrentPage' => $CurrentPage,
            'niveles' => $niveles,
            'grados' => $grados,
            'secciones' => $secciones,
            'cursos' => $cursos,
            'aulas' => $aulas,
            'id_curso' => $id_curso,
            'id_aula' => $id_aula,
            'brusquedad' => $brusquedad,
            'aulasPermitidas' => $aulasPermitidas,
            'errores' => $errores
        ]);
    }
    public static function estadoAristoteles()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $id = filter_var($id, FILTER_VALIDATE_INT);
            if ($id) {
                $arist = Aristoteles::find($id);
                // elimina la propiedad 
                $resultado = $arist->estado();
                // debuguear($usuario);
                if ($resultado) {
                    header('Location: /aristoteles/profesor?resultado=3');
                }
            }
        }
    }
    public static function contenido(Router $router)
    {
        $CurrentPage = 'form-ckeditor';
        $id = validarRedirrecionar('/inicio');

        $tipos_evaluacion=Tipo_evaluacion::all();
        $aristoteles = Aristoteles::find($id);

        $router->render('home/aristoteles/contenido', [
            'CurrentPage' => $CurrentPage,
            'tipos_evaluacion' => $tipos_evaluacion,
            'aristoteles' => $aristoteles,
        ]);
    }

    public static function crearTarea(Router $router)
    {
        $CurrentPage = 'form-ckeditor';
        // Crear la tarea si no hay errores
        $tarea = new Tarea();

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Crear la tarea si no hay errores
            $tarea = new Tarea($_POST['tarea']);
            $aristoteles = new Aristoteles();

            // Manejo de archivo subido
            if (isset($_FILES['tarea']["tmp_name"]['archivo']) && $_FILES['tarea']['error']['archivo'] == UPLOAD_ERR_OK) {
                $nombreArchivo = guardarTareas($_FILES['tarea']["tmp_name"]['archivo']);
                $tarea->archivo = $nombreArchivo;
            }

            // Validar la tarea
            $errores = $tarea->validar();

            if (empty($errores)) {
                $id_aula=$_POST['tarea']['id_aula'];
                $id_aristoteles=$_POST['id_aristoteles'];
                // Guardar la tarea en la base de datos
                $resultado = $tarea->guardar();
                $aristotelesCambio= $aristoteles::find($id_aristoteles);
                $aristotelesCambio->id_tarea=$tarea->id;
                
                $alumnosMatricula=Matricula::findAlumnosAlula($id_aula);
                // Si el registro es exitoso, ahora guarda la relación alumnos-tarea
                if ($resultado) {
                    $aristotelesCambio->guardar();
                    $idTarea = $tarea->id; // Obtén el ID de la tarea recién creada
                    foreach ($alumnosMatricula as $idAlumno) {
                        // Crear un registro en la tabla que asocie la tarea con los alumnos
                        $tareaAlumno=new Alumno_tarea([
                            'id_tarea' => $idTarea,
                            'id_alumno' => $idAlumno->id_alumno
                        ]);

                        $tareaAlumno->guardar();
                    }

                    // Redirigir si todo fue exitoso
                    header('Location: /Tareas/profesor');
                }
            }
        }

        $router->render('home/aristoteles/contenido', [
            'CurrentPage' => $CurrentPage,
            'tarea' => $tarea,
        ]);
    }

    public static function video(Router $router)
    {
        $CurrentPage = 'form-ckeditor';
        $id = validarRedirrecionar('/inicio');

        $aristoteles = Aristoteles::find($id);

        $router->render('home/aristoteles/contenidoVideo', [
            'CurrentPage' => $CurrentPage,
            'aristoteles' => $aristoteles,
        ]);
    }
}
