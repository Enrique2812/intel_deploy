<div class="content-body">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Alumnos</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Aulas</a></li>
            </ol>
        </div>
        <!-- Filtros y acciones -->
        <div class="row">
            <!-- Listado de Aulas -->
            <div class="col-lg-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4 class="card-title">Listado de Aulas</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example2" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Nivel</th>
                                        <th>Grado</th>
                                        <th>Sección</th>
                                        <th>Turno</th>
                                        <th>Alumnos</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    use Model\Alumno;

                                    foreach ($aulas as $aula):
                                    ?>
                                        <tr>
                                            <td><?php echo $aula->nombre ?></td>
                                            <td>
                                                <?php foreach ($niveles as $nivele) : ?>
                                                    <?php
                                                    if ($aula->id_nivel === $nivele->id) {
                                                        echo $nivele->abreviatura;
                                                        continue;
                                                    }
                                                    ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <?php foreach ($grados as $grado) : ?>
                                                    <?php
                                                    if ($aula->id_grado === $grado->id) {
                                                        echo $grado->abreviatura;
                                                        continue;
                                                    }
                                                    ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <?php foreach ($secciones as $seccione) : ?>
                                                    <?php
                                                    if ($aula->id_seccion === $seccione->id) {
                                                        echo $seccione->abreviatura;
                                                        continue;
                                                    }
                                                    ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <?php foreach ($turnos as $turno) : ?>
                                                    <?php
                                                    if ($aula->id_turno === $turno->id) {
                                                        echo $turno->abreviatura;
                                                        continue;
                                                    }
                                                    ?>
                                                <?php endforeach; ?>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="#" class="btn btn-primary shadow sharp me-1" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $aula->id; ?>">
                                                        <i class="fa-solid fa-users fa-xl"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <!-- Modal -->
                                            <div class="modal fade bd-example-modal-lg edit" id="editModal-<?php echo $aula->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form class="modal-content" action="/gestion/alumnos_aulas" method="POST">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Seleccionar Alumno - <?php echo $aula->nombre; ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <!-- Campo de búsqueda -->
                                                                <div class="mb-3">
                                                                    <input type="text" id="searchAlumno" class="form-control" placeholder="Buscar alumno...">
                                                                    <input value="<?php echo $aula->id ?>" name="matricula[id_aula]" type="hidden" class="form-control input-default" placeholder="Nombre del rol">
                                                                    <input value="<?php echo $aula->id_año ?>" name="matricula[id_año]" type="hidden" class="form-control input-default" placeholder="Nombre del rol">
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="card border-0 pb-0">
                                                                        <div class="card-body p-0">
                                                                            <div id="DZ_W_Todo4" class="widget-media dlab-scroll px-4 my-4" style="height:370px;">
                                                                                <!-- Lista de alumnos -->
                                                                                <ul class="timeline" id="alumnosList">
                                                                                    <?php
                                                                                    $alumnosAsignadas = Alumno::obtenerAlumnoAula($aula->id);
                                                                                    $alumnosAsignadasIds = array_map(function ($alumno) {
                                                                                        return $alumno->id;
                                                                                    }, $alumnosAsignadas);

                                                                                    ?>

                                                                                    <?php foreach ($alumnos as $alumno) : ?>
                                                                                        <?php foreach ($usuarios as $usuario) : ?>
                                                                                            <?php if ($usuario->id === $alumno->id_usuario) : ?>
                                                                                                <li class="alumno-item">
                                                                                                    <div class="timeline-panel">
                                                                                                        <div class="form-check custom-checkbox checkbox-info check-lg me-3">
                                                                                                            <input type="checkbox" value="<?php echo $alumno->id; ?>"
                                                                                                                name="alumnos[]" class="form-check-input" id="customCheckBox<?php echo $alumno->id; ?>"
                                                                                                                <?php echo in_array($alumno->id, $alumnosAsignadasIds) ? 'checked' : ''; ?>>
                                                                                                            <label class="form-check-label" for="customCheckBox<?php echo $alumno->id; ?>"></label>
                                                                                                        </div>
                                                                                                        <div class="media-body">
                                                                                                            <h5 class="mb-0"><?php echo $usuario->nombre . " " . $usuario->apellidos . " - " . $usuario->dni; ?></h5>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </li>
                                                                                            <?php endif; ?>
                                                                                        <?php endforeach; ?>
                                                                                    <?php endforeach; ?>
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer d-flex justify-content-between">
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                            </div>
                                                        </form>
                                                    </div>

                                                </div>
                                            </div>
                                        </tr>
                                    <?php
                                    endforeach;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('keyup', function(event) {
            if (event.target && event.target.id === 'searchAlumno') {
                var searchValue = event.target.value.toLowerCase();
                var alumnos = document.querySelectorAll('#alumnosList .alumno-item');

                alumnos.forEach(function(alumno) {
                    var alumnoName = alumno.querySelector('.media-body h5').textContent.toLowerCase();
                    if (alumnoName.includes(searchValue)) {
                        alumno.style.display = '';
                    } else {
                        alumno.style.display = 'none';
                    }
                });
            }
        });
    </script>
</div>