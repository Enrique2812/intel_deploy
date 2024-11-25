<!--**********************************
            Sidebar start
        ***********************************-->
<?php
$icosModuls = array(
    "Accesos" => "fa-light fa-address-card",
    "Gestión" => "fa-light fa-school",
    "Tareas" => "fa-light fa-books",
    "Configuración" => "fa-thin fa-gears",
    "Calificación" => "fa-light fa-ranking-star",
    "Asistencia" => "fa-light fa-clipboard-user",
    "Aristóteles" => "fa-light fa-head-side-brain",
    "Inicio" => "flaticon-025-dashboard", // Ejemplo de página sin módulo
    "Clases en vivo" => "fa-light fa-ranking-star",
    "Contabilidad" => "fa-light fa-clipboard-user",
    "Pagos" => "fa-light fa-head-side-brain",
);

?>
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="dropdown header-profile">
                <a class="nav-link" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                    <img src="/assets/images/profile/pic1.jpg" width="20" alt="">
                    <div class="header-info ms-3">
                        <span class="font-w600">Hola, <b><?php echo $_SESSION['nombre']; ?></b></span>
                        <small class="text-end font-w400"><?php echo $_SESSION['email']; ?></small>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end">
                    <a href="#" class="dropdown-item ai-icon">
                        <span class="ms-2">Perfil</span>
                    </a>
                    <a href="/logout" class="dropdown-item ai-icon">
                        <span class="ms-2">Cerrar sesión</span>
                    </a>
                </div>
            </li>

            <!-- Elemento 'Inicio' con icono directo -->
            <li><a class="ai-icon" href="/inicio" aria-expanded="false">
                <i class="<?php echo $icosModuls['Inicio']; ?>"></i>
                <span class="nav-text">Inicio</span>
            </a></li>

            <?php
            // Obtener las páginas permitidas del usuario desde la sesión
            $paginasPermitidas = $_SESSION['paginas'];

            // Organizar las páginas por módulo
            $modulos = [
                'Accesos' => ['/accesos/usuario', '/accesos/roles'],
                'Gestión' => ['/gestion/alumnos_aulas', '/gestion/profesor_aula', '/gestion/alumnos', '/gestion/profesores', '/gestion/cursos', '/gestion/grados', '/gestion/secciones', '/gestion/aulas'],
                'Tareas' => ['/Tareas/profesor', '/Tareas/alumno'],
                'Aristóteles' => ['/aristoteles/alumno', '/aristoteles/profesor'],
                'Configuración' => ['/configuracion/escolar', '/configuracion/tipoevaluacion'],
                'Calificación' => ['/calificaciones/calificacion', '/calificaciones/miscalificaciones', '/calificaciones/vertodo'],
                'Asistencia' => ['/asistencia/horario', '/asistencia/registrar', '/asistencia/general', '/asistencia/alumno', '/asistencia/calendario', '/asistencia/diariototal'],
                'Clases en vivo'=> ['/Clases_en_vivo/ClaseVivo'],
                'Contabilidad'=> ['/Contabilida/matricula-configuracion'],
                'Pagos'=> ['/Pagos/pago'],
            ];

            // Mostrar cada módulo si el usuario tiene acceso a alguna de sus páginas
            foreach ($modulos as $nombreModulo => $rutasModulo) {
                $paginasModulo = array_filter($paginasPermitidas, function ($pagina) use ($rutasModulo) {
                    return in_array($pagina->ruta, $rutasModulo);
                });

                // Solo mostrar el módulo si tiene páginas permitidas
                if (!empty($paginasModulo)) {
                    // Obtener el icono correspondiente del array $icosModuls
                    $icono = isset($icosModuls[$nombreModulo]) ? $icosModuls[$nombreModulo] : 'fa fa-folder'; // Icono por defecto si no se encuentra

                    echo "<li><a class='has-arrow ai-icon' href='javascript:void(0);' aria-expanded='false'>
                            <i class='{$icono}'></i>
                            <span class='nav-text'>{$nombreModulo}</span>
                        </a>
                        <ul aria-expanded='false'>";

                    foreach ($paginasModulo as $pagina) {
                        echo "<li><a href='{$pagina->ruta}'>{$pagina->nombre}</a></li>";
                    }

                    echo "</ul></li>";
                }
            }
            ?>
        </ul>
    </div>
</div>


<!--**********************************
            Sidebar end
        ***********************************-->