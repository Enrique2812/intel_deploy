<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Tareas</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Alumno</a></li>
                    </ol>
                </div>
                <?php if ($_SESSION['rol'] === '4') : ?>
                    <div class="filter cm-content-box box-primary">
                        <div class="cm-content-body  form excerpt">
                            <div class="card-body">
                                <div class="row d-flex align-items-center">
                                    <!-- Selector de Cursos -->
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="cursoSelect" class="form-select">
                                            <option value="AL">Todo</option>
                                            <?php foreach ($aulaAlumno as $curso): ?>
                                                <?php $cursoAula = $buscaCurso->find($curso->id_curso); ?>
                                                <option value="<?php echo $cursoAula->id ?>"><?php echo $cursoAula->descripcion ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <?php if ($_SESSION['rol'] === '4') : ?>
                <?php foreach ($tareasAlumno as $tareaA): ?>
                    <?php foreach ($tareas as $tarea): ?>
                        <?php if ($tarea->id === $tareaA->id_tarea) : ?>
                            <div class="col-xl-3 col-sm-6 ">
                                <a href="/Tareas/contenido?id=<?php echo $tareaA->id ?>&A=<?php echo 1?>">
                                    <div class="card <?php if ($tareaA->estado === '0') { echo 'text-bg-light'; } else { echo 'text-bg-success'; } ?>">
                                        <div class="card-body invoice-card position-unset d-flex align-items-center justify-content-between">
                                            <div class="card-data me-2">
                                                <h2 class="fs-18"><?php echo $tarea->titulo; ?></h2>
                                                <h5 class="invoice-num"><?php echo $tarea->fecha_inicio . ' hasta ' . $tarea->fecha_fin; ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </div>
</div>