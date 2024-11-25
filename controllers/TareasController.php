<?php

namespace Controllers;

use Model\Alumno;
use Model\Alumno_tarea;
use Model\Aula;
use Model\Aula_personal_curso;
use Model\Curso;
use Model\Grado;
use Model\Matricula;
use Model\Nivel;
use Model\Profesor;
use Model\Seccion;
use Model\Tarea;
use Model\Tipo_evaluacion;
use Model\Usuario;
use MVC\Router;

class TareasController
{
    public static function profesor(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $buscaAula = new Aula();
        $buscaGrado = new Grado();
        $buscaCurso = new Curso();
        $alumno_tareas = Alumno_tarea::all();
        $aulas = Aula::all();
        $grados = Grado::all();
        $cursos = Curso::all();
        $aulasPermitidas = '';
        $tareasProfesor = '';
        if ($_SESSION['rol'] === '5' && $_SESSION['tutor'] === '0') {
            $aulasPermitidas = Aula_personal_curso::findPersonal($_SESSION['id_profesor']);
            $tareasProfesor = Tarea::findProfesor($_SESSION['id_profesor']);
        } else if ($_SESSION['rol'] === '5' && $_SESSION['tutor'] === '1') {
            $aulasPermitidas = Aula_personal_curso::findPersonal($_SESSION['id_profesor']);
            $tareasProfesor = Tarea::all();
        }


        $router->render('home/Tareas/profesor', [
            'CurrentPage' => $CurrentPage,
            'buscaAula' => $buscaAula,
            'buscaGrado' => $buscaGrado,
            'buscaCurso' => $buscaCurso,
            'aulasPermitidas' => $aulasPermitidas,
            'grados' => $grados,
            'aulas' => $aulas,
            'alumno_tareas' => $alumno_tareas,
            'tareasProfesor' => $tareasProfesor,
            'cursos' => $cursos
        ]);
    }
    public static function alumno(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $buscaAula = new Aula();
        $buscaGrado = new Grado();
        $buscaCurso = new Curso();
        $cursos = Curso::all();
        $tareas = Tarea::all();
        $tareasAlumno='';
        $aulaAlumno = '';

        if ($_SESSION['rol'] === '4' && $_SESSION['matricula'] === '1') {
            $aulaAlumno = Aula_personal_curso::findCursoAula($_SESSION['id_aula']);
            $tareasAlumno= Alumno_tarea::findAlumno($_SESSION['id_alumno']);
        }

        $router->render('home/Tareas/alumno', [
            'CurrentPage' => $CurrentPage,
            'buscaAula' => $buscaAula,
            'buscaGrado' => $buscaGrado,
            'buscaCurso' => $buscaCurso,
            'cursos' => $cursos,
            'tareas' => $tareas,
            'tareasAlumno' => $tareasAlumno,
            'aulaAlumno' => $aulaAlumno
        ]);
    }

    public static function crear(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';

        $tipos_evaluacion=Tipo_evaluacion::all();
        $buscaAula = new Aula();
        $buscaCurso = new Curso();
        $alumnos = Alumno::all();
        $usuarios = Usuario::all();
        $matriculados = '';
        $aulasPermitidas = '';
        $errores = Tarea::getErrores();
        $seleccionar = false;
        $id_aula = '';
        $id_curso = '';

        if ($_SESSION['rol'] === '5') {
            $aulasPermitidas = Aula_personal_curso::findPersonal($_SESSION['id_profesor']);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_POST['Seleccionar'])) {
                $id_aula = $_POST['id_aula'];
                $id_curso = $_POST['id_curso'];
                $matriculados = Matricula::findAlumnosAlula($id_aula);
                $seleccionar = true;
            }
            if (isset($_POST['Subir'])) {
                // Verificar que al menos un alumno fue seleccionado
                if (empty($_POST['alumnos'])) {
                    $errores[] = 'Debes seleccionar al menos un alumno para asignar la tarea.';
                } else {
                    // Crear la tarea si no hay errores
                    $tarea = new Tarea($_POST['tarea']);

                    // Manejo de archivo subido
                    if (isset($_FILES['tarea']["tmp_name"]['archivo']) && $_FILES['tarea']['error']['archivo'] == UPLOAD_ERR_OK) {
                        $nombreArchivo = guardarTareas($_FILES['tarea']["tmp_name"]['archivo']);
                        $tarea->archivo = $nombreArchivo;
                    }

                    // Validar la tarea
                    $errores = $tarea->validar();

                    if (empty($errores)) {
                        // Guardar la tarea en la base de datos
                        $resultado = $tarea->guardar();

                        // Si el registro es exitoso, ahora guarda la relación alumnos-tarea
                        if ($resultado) {
                            $idTarea = $tarea->id; // Obtén el ID de la tarea recién creada
                            foreach ($_POST['alumnos'] as $idAlumno) {
                                // Crear un registro en la tabla que asocie la tarea con los alumnos
                                $tareaAlumno=new Alumno_tarea([
                                    'id_tarea' => $idTarea,
                                    'id_alumno' => $idAlumno
                                ]);

                                $tareaAlumno->guardar();
                            }

                            // Redirigir si todo fue exitoso
                            header('Location: /Tareas/profesor');
                        }
                    }
                }
            }
        }
        $router->render('home/Tareas/tareaProfesor', [
            'CurrentPage' => $CurrentPage,
            'alumnos' => $alumnos,
            'usuarios' => $usuarios,
            'matriculados' => $matriculados,
            'errores' => $errores,
            'buscaAula' => $buscaAula,
            'buscaCurso' => $buscaCurso,
            'aulasPermitidas' => $aulasPermitidas,
            'seleccionar' => $seleccionar,
            'id_aula' => $id_aula,
            'tipos_evaluacion' => $tipos_evaluacion,
            'id_curso' => $id_curso
        ]);
    }
    public static function contenido(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $id = validarRedirrecionar('/inicio');
        $Alumnos=Alumno::all();
        $Usuarios=Usuario::all();
        $Alumno='';
        $Tutor='';
        $usuarioTutor='';
        $Aula='';

        if($_SESSION['rol'] === '4'){
            $ari=valiadarContenidoAristoteles('/inicio');
            if($ari===1){
                $tareaA = Alumno_tarea::find($id);
                $tarea = Tarea::find($tareaA->id_tarea);
                $Curso=Curso::find($tarea->id_curso);
                $Alumno=Alumno::find($_SESSION['id_alumno']);
            }
            if($ari===2){
                $tarea = Tarea::find($id);
                $Curso=Curso::find($tarea->id_curso);
                $Alumno=Alumno::find($_SESSION['id_alumno']);
                $tareaA = Alumno_tarea::findAlumnoTarea($_SESSION['id_alumno'],$id);
                // debuguear($tareaA);
            }
        }else if($_SESSION['rol'] === '5'){
            $tarea = Tarea::find($id);
            $Curso=Curso::find($tarea->id_curso);
            $tareaA = Alumno_tarea::findTarea($id);
            $Aula=Aula::find($tarea->id_aula);
            $Tutor=Profesor::findProfesor($Aula->tutor);
            $usuarioTutor=Usuario::find($Tutor->id_usuario);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
            // Crear la tarea si no hay errores
            $tarea = new Alumno_tarea($_POST['alumno_tarea']);
            
            // Manejo de archivo subido
            if (isset($_FILES['alumno_tarea']["tmp_name"]['archivo']) && $_FILES['alumno_tarea']['error']['archivo'] == UPLOAD_ERR_OK) {
                $nombreArchivo = guardarTareasAlumno($_FILES['alumno_tarea']["tmp_name"]['archivo']);
                $tarea->archivo = $nombreArchivo;
            }
            // Validar la tarea
            
            $errores = $tarea->validar();
            if (empty($errores)) {
                // Guardar la tarea en la base de datos
                $resultado = $tarea->guardar();
                // Si el registro es exitoso, ahora guarda la relación alumnos-tarea
                if ($resultado) {
                    // Redirigir si todo fue exitoso
                    header('Location: /Tareas/alumno');
                }
            }
        }
        
        $router->render('home/Tareas/tareaContenido', [
            'CurrentPage' => $CurrentPage,
            'Curso' => $Curso,
            'Aula' => $Aula,
            'usuarioTutor' => $usuarioTutor,
            'Alumno' => $Alumno,
            'Alumnos' => $Alumnos,
            'Usuarios' => $Usuarios,
            'tarea' => $tarea,
            'tareaA' => $tareaA
        ]);
    }
}
