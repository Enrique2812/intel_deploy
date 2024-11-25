<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Tareas</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Profesor</a></li>
                    </ol>
                </div>
                <?php if ($_SESSION['rol'] === '5') : ?>
                    <div class="filter cm-content-box box-primary">
                        <div class="cm-content-body  form excerpt">
                            <div class="card-body">
                                <div class="row d-flex align-items-center">
                                    <!-- Selector de Aulas -->
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="aulaSelect" class="form-select" aria-label="Default select example">
                                            <option value="AL">Todo</option>
                                            <?php $aulasMostradas = []; ?>
                                            <?php foreach ($aulasPermitidas as $aulaP) : ?>
                                                <?php foreach ($aulas as $aula) : ?>
                                                    <?php if (!in_array($aulaP->id_aula, $aulasMostradas)): ?>
                                                        <?php if ($aula->id === $aulaP->id_aula): ?>
                                                            <?php $aulasMostradas[] = $aulaP->id_aula;  ?>
                                                            <option value="<?php echo $aula->id; ?>"><?php echo $aula->nombre; ?></option>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- Selector de Cursos -->
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="cursoSelect" class="form-select">
                                            <option value="AL">Todo</option>
                                            <?php $cursosMostradas = []; ?>
                                            <?php foreach ($aulasPermitidas as $cursoP) : ?>
                                                <?php foreach ($cursos as $curso) : ?>
                                                    <?php if (!in_array($cursoP->id_curso, $cursosMostradas)): ?>
                                                        <?php if ($cursoP->id_curso === $curso->id): ?>
                                                            <?php $cursosMostradas[] = $cursoP->id_curso;  ?>
                                                            <option value="<?php echo $curso->id; ?>"><?php echo $curso->descripcion; ?></option>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <!-- Botón Agregar -->
                                    <div class="col-xl-4 mb-3">
                                        <a href="/Tareas/asignacion" class="btn btn-primary mb-2"><span
                                                class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                                            </span>Agregar
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <?php if ($_SESSION['rol'] === '5' && $_SESSION['tutor'] === '0') : ?>
                <?php foreach ($tareasProfesor as $tarea): ?>
                    <?php $contadoAlumno = 0 ?>
                    <?php $contadoAlumnoEstado = 0 ?>
                    <?php foreach ($alumno_tareas as $alumno_tarea): ?>
                        <?php if ($alumno_tarea->id_tarea === $tarea->id) : ?>
                            <?php $contadoAlumno++ ?>
                        <?php endif; ?>
                        <?php if ($alumno_tarea->id_tarea === $tarea->id && $alumno_tarea->estado === '1') : ?>
                            <?php $contadoAlumnoEstado++ ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <div class="col-xl-3 col-sm-6 ">
                        <a href="/Tareas/contenido?id=<?php echo $tarea->id ?>">
                            <div class="card <?php if ($contadoAlumnoEstado != $contadoAlumno) {
                                                    echo 'text-bg-light';
                                                } else {
                                                    echo 'text-bg-primary';
                                                } ?>">
                                <div class="card-body invoice-card position-unset d-flex align-items-center justify-content-between">
                                    <div class="card-data me-2">
                                        <h2 class="fs-18"><?php echo $tarea->titulo; ?></h2>
                                        <h5 class="invoice-num"><?php echo $tarea->fecha_inicio . ' hasta ' . $tarea->fecha_fin; ?></h5>
                                    </div>
                                    <div>
                                        <div class="btn btn-success mb-2">
                                            <span class="donut1 text-dark"><?php echo $contadoAlumnoEstado; ?>/<?php echo $contadoAlumno; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($_SESSION['rol'] === '5' &&  $_SESSION['tutor'] === '1') : ?>
                    <?php foreach ($tareasProfesor as $tarea): ?>
                        
                    <?php if ($_SESSION['id_aula'] === $tarea->id_aula): ?>
                        <?php $contadoAlumno = 0 ?>
                        <?php $contadoAlumnoEstado = 0 ?>
                        <?php foreach ($alumno_tareas as $alumno_tarea): ?>
                            <?php if ($alumno_tarea->id_tarea === $tarea->id) : ?>
                                <?php $contadoAlumno++ ?>
                            <?php endif; ?>
                            <?php if ($alumno_tarea->id_tarea === $tarea->id && $alumno_tarea->estado === '1') : ?>
                                <?php $contadoAlumnoEstado++ ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="col-xl-3 col-sm-6 ">
                            <div class="card text-bg-info">
                                <div class="card-body invoice-card position-unset d-flex align-items-center justify-content-between">
                                    <div class="card-data me-2">
                                        <h2 class="fs-18 text-white"><?php echo $tarea->titulo; ?></h2>
                                        <h5 class="invoice-num"><?php echo $tarea->fecha_inicio . ' hasta ' . $tarea->fecha_fin; ?></h5>
                                    </div>
                                    <div>
                                        <div class="btn btn-success mb-2">
                                            <span class="donut1 text-dark"><?php echo $contadoAlumnoEstado; ?>/<?php echo $contadoAlumno; ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php elseif ($_SESSION['id_profesor'] === $tarea->id_profesor): ?>
                        <?php $contadoAlumno = 0 ?>
                        <?php $contadoAlumnoEstado = 0 ?>
                        <?php foreach ($alumno_tareas as $alumno_tarea): ?>
                            <?php if ($alumno_tarea->id_tarea === $tarea->id) : ?>
                                <?php $contadoAlumno++ ?>
                            <?php endif; ?>
                            <?php if ($alumno_tarea->id_tarea === $tarea->id && $alumno_tarea->estado === '1') : ?>
                                <?php $contadoAlumnoEstado++ ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <div class="col-xl-3 col-sm-6 ">
                            <a href="/Tareas/contenido?id=<?php echo $tarea->id ?>">
                                <div class="card <?php if ($contadoAlumnoEstado != $contadoAlumno) {
                                                        echo 'text-bg-light';
                                                    } else {
                                                        echo 'text-bg-primary';
                                                    } ?>">
                                    <div class="card-body invoice-card position-unset d-flex align-items-center justify-content-between">
                                        <div class="card-data me-2">
                                            <h2 class="fs-18"><?php echo $tarea->titulo; ?></h2>
                                            <h5 class="invoice-num"><?php echo $tarea->fecha_inicio . ' hasta ' . $tarea->fecha_fin; ?></h5>
                                        </div>
                                        <div>
                                            <div class="btn btn-success mb-2">
                                                <span class="donut1 text-dark"><?php echo $contadoAlumnoEstado; ?>/<?php echo $contadoAlumno; ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>