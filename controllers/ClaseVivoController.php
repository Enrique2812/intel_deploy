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
use Model\Usuario;
use Model\Videoconferencia;
use MVC\Router;

class ClaseVivoController
{



    public static function vista(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $buscaAula = new Aula();
        $Aulas = Aula::all();
        $buscaGrado = new Grado();
        $buscaCurso = new Curso();
        $buscaProfesor = new Profesor(); // Añadido para buscar profesores
        $grados = Grado::all();
        $cursos = Curso::all();
        $aulasPermitidas = '';
        $Videoconferencia = [];
        $videoconferenciaProfesor = [];


        if ($_SESSION['rol'] === '4' && $_SESSION['matricula'] === '1') {
            // Lógica para alumnos

            $cursoAula = Curso::findCursoAula($_SESSION['id_aula']);
            $profesorAula = Profesor::findProfesorAula($_SESSION['id_aula']);

            if ($cursoAula && $profesorAula) {
                $_SESSION['id_curso'] = $cursoAula->id;
                $_SESSION['id_profesor'] = $profesorAula->id;
            } else {
                die('Error: No se pudieron obtener id_curso o id_profesor.');
            }

            $Videoconferencia = Videoconferencia::findByAulaCursoProfesor($_SESSION['id_aula'], $_SESSION['id_curso'], $_SESSION['id_profesor']);
            $Videoconferencia = array_filter($Videoconferencia, function ($vc) {
                return $vc->vision == 1;
            });

            foreach ($Videoconferencia as $vc) {

                $curso = $buscaCurso->find($vc->idcurso);
                $aula = $buscaAula->find($vc->idaula);
                $profesor = $buscaProfesor->find($vc->idprofesor); // Buscar el nombre del profesor

                $vc->curso_nombre = $curso ? $curso->descripcion : 'Nombre del Curso no encontrado';
                $vc->aula_nombre = $aula ? $aula->nombre : 'Nombre del Aula no encontrado';
                $vc->profesor_nombre = $profesor ? $profesor->nombre : $vc->profesor_nombre; // Utilizar profesor_nombre del objeto
            }
        }

        if ($_SESSION['rol'] === '5') {
            // Lógica para profesores
            $aulasPermitidas = Aula_personal_curso::findPersonal($_SESSION['id_profesor']);

            if (isset($_SESSION['id_profesor'])) {
                // Obtener la información del profesor y sus videoconferencias
                $Videoconferencia = Videoconferencia::findProfesorId($_SESSION['id_profesor']);
                $Videoconferencia = array_filter($Videoconferencia, function ($vc) {
                    return $vc->vision == 1;
                });
            } else {
                die('Error: Las variables de sesión no están definidas.');
            }
        } elseif ($_SESSION['rol'] === '1') {
            // Lógica para administrador
            $videoconferenciaProfesor = Videoconferencia::allConProfesores();
            $videoconferenciaProfesor = array_filter($videoconferenciaProfesor, function ($vc) {
                return $vc->vision == 1;
            });

            foreach ($videoconferenciaProfesor as $vc) {

                $curso = $buscaCurso->find($vc->idcurso);
                $aula = $buscaAula->find($vc->idaula);
                $profesor = $buscaProfesor->find($vc->idprofesor); // Buscar el nombre del profesor

                $vc->curso_nombre = $curso ? $curso->descripcion : 'Nombre del Curso no encontrado';
                $vc->aula_nombre = $aula ? $aula->nombre : 'Nombre del Aula no encontrado';
                $vc->profesor_nombre = $profesor ? $profesor->nombre : $vc->profesor_nombre; // Utilizar profesor_nombre del objeto
            }
        }

        $router->render('home/Clases_en_vivo/ClaseVivo', [
            'CurrentPage' => $CurrentPage,
            'buscaAula' => $buscaAula,
            'buscaGrado' => $buscaGrado,
            'buscaCurso' => $buscaCurso,
            'cursos' => $cursos,
            'Aulas' => $Aulas,
            'Videoconferencia' => $Videoconferencia,
            'videoconferenciaProfesor' => $videoconferenciaProfesor,
            'aulasPermitidas' => $aulasPermitidas,
            'grados' => $grados
        ]);
    }








    public static function crearvideoconferencia(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $buscaAula = new Aula();
        $buscaCurso = new Curso();
        $alumnos = Alumno::all();
        $usuarios = Usuario::all();
        $matriculados = '';
        $aulasPermitidas = '';
        $errores = Videoconferencia::getErrores();
        $seleccionar = false;
        $id_aula = '';
        $id_curso = '';

        if ($_SESSION['rol'] === '5') {
            $aulasPermitidas = Aula_personal_curso::findPersonal($_SESSION['id_profesor']);
        }
        // debuguear($aulasPermitidas);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // debuguear($_POST);

            if (isset($_POST['Seleccionar'])) {
                $id_aula = $_POST['id_aula'];
                $id_curso = $_POST['id_curso'];
                $matriculados = Matricula::findAlumnosAlula($id_aula);
                $seleccionar = true;
            }

            if (isset($_POST['Subir'])) {
                // Crear la videoconferencia si no hay errores
                $videoconferencia = new Videoconferencia($_POST['videoconferencia']);
                $errores = $videoconferencia->validar();

                if (empty($errores)) {
                    $resultado = $videoconferencia->guardar();

                    if ($resultado) {
                        // Aquí no es necesario guardar individualmente para cada alumno
                        header('Location: /Clases_en_vivo/ClaseVivo');
                    } else {
                        $errores[] = 'No se pudo guardar la videoconferencia en la base de datos.';
                    }
                }
            }
        }

        $router->render('home/Clases_en_vivo/ClaseVivo', [
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
            'id_curso' => $id_curso
        ]);
    }


    public static function editar(Router $router)
    {
        $CurrentPage = 'table-datatable-basic';
        $errores = Videoconferencia::getErrores();
        $videoconferencia = new Videoconferencia($_POST['videoconferencia']);
        // Asignar los valores
        // debuguear($videoconferencia);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // $videoconferencia = new Videoconferencia($_POST['videoconferencia']);
            // // Asignar los valores
            // debuguear($videoconferencia);
            $args = $_POST['videoconferencia'];
            $videoconferencia->sincronizar($args);

            // Validar
            $errores = $videoconferencia->validar();

            if (empty($errores)) {
                $resultado = $videoconferencia->guardar();
                if ($resultado) {
                    header('Location: /Clases_en_vivo/ClaseVivo?resultado=2');
                }
            }
        }

        $router->render('home/Clases_en_vivo/ClaseVivo', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores,
            'videoconferencia' => $videoconferencia
        ]);
    }


    public static function cambiarVision(Router $router)
    {
        // Definimos la página actual y posibles errores
        $CurrentPage = 'table-datatable-basic';
        $errores = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            // Obtenemos el ID de la videoconferencia desde el formulario
            $id = $_POST['id'] ?? null;

            if ($id) {
                // Buscamos la videoconferencia en la base de datos
                $videoconferencia = Videoconferencia::find($id);

                if ($videoconferencia) {
                    // Cambiamos la visión a 0 para "ocultar"
                    $videoconferencia->vision = 0;

                    // Guardamos los cambios en la base de datos
                    $resultado = $videoconferencia->guardar();

                    if ($resultado) {
                        // Redirigimos con un mensaje de éxito
                        header('Location: /Clases_en_vivo/ClaseVivo?resultado=3');
                        exit;
                    } else {
                        $errores[] = "Error al actualizar la videoconferencia.";
                    }
                } else {
                    $errores[] = "Videoconferencia no encontrada.";
                }
            } else {
                $errores[] = "ID de videoconferencia no válido.";
            }
        }

        // Renderizamos la vista con errores si hubo algún problema
        $router->render('home/Clases_en_vivo/ClaseVivo', [
            'CurrentPage' => $CurrentPage,
            'errores' => $errores
        ]);
    }
}
