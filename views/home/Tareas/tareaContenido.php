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

            </div>
        </div>
        <div class="row">
            <?php if ($_SESSION['rol'] === '1' || $_SESSION['rol'] === '5'): ?>
                <div class="row">
                    <!-- Columna para la tabla -->
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="card">
                            <div class="card-body">
                                <a download="<?php echo $tarea->titulo; ?>" class="btn btn-primary mb-2" href="../tareasAsignadas/<?php echo $tarea->archivo; ?>">
                                    <span><i class="fa-solid fa-download"></i></span> Descargar Tarea
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example2" class="display table" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Nombres y Apellidos</th>
                                                <th>Estado</th>
                                                <th>Tarea</th>
                                                <th>Nota</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($tareaA as $tarea_A): ?>
                                                <?php foreach ($Alumnos as $alumno): ?>
                                                    <?php foreach ($Usuarios as $Usuario): ?>
                                                        <?php if ($alumno->id === $tarea_A->id_alumno && $Usuario->id === $alumno->id_usuario): ?>
                                                            <tr>
                                                                <td><?php echo $Usuario->nombre . ' ' . $Usuario->apellidos; ?></td>
                                                                <td>
                                                                    <?php
                                                                    if ($tarea_A->estado === '1') {
                                                                        echo 'Subió su tarea';
                                                                    } else {
                                                                        echo 'Sin tarea';
                                                                    }
                                                                    ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($tarea_A->estado === '1') { ?>
                                                                        <a download="<?php echo $Usuario->nombre . '-' . $Usuario->apellidos;  ?> " class="btn btn-primary" href="/alumnosTareas/<?php echo $tarea_A->archivo; ?>">
                                                                            <i class="fa-solid fa-download"></i> Descargar
                                                                        </a>
                                                                    <?php } else { ?>
                                                                        <div class="btn btn-danger">
                                                                            <i class="fa-solid fa-exclamation"></i> Sin archivo
                                                                        </div>
                                                                    <?php } ?>

                                                                </td>
                                                                <td>
                                                                    <input value="" type="number" class="form-control" id="dni" name="[]" required>

                                                                </td>
                                                            </tr>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Columna para la descripción del aula -->
                    <!-- <div class="col-lg-6 col-md-12 col-12">
                        <div class="card">
                            <div class="row no-gutters"> -->
                    <!-- Imagen del tutor centrada -->
                    <!-- <div class="col-12 text-center p-3">
                                    <img class="img-fluid rounded-circle" src="/assets/images/profesor.png" alt="Imagen del Tutor" style="max-width: 150px; height: auto;">
                                </div> -->
                    <!-- Descripción del Aula -->
                    <!-- <div class="col-12">
                                    <div class="card-body text-center">
                                        <h4>Descripción del Aula</h4>
                                        <p><strong>Aula:</strong> <?php
                                                                    // echo $Aula->nombre;
                                                                    ?></p>
                                        <p><strong>Tutor:</strong> <?php
                                                                    // echo $usuarioTutor->nombre . ' ' . $usuarioTutor->apellidos; 
                                                                    ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>-->

                </div>

            <?php endif; ?>
            <?php if ($_SESSION['rol'] === '4'): ?>
                <div class="col-12">
                    <div class="card">
                        <form method="post" enctype="multipart/form-data">
                            <!-- Encabezado de la sección de tareas -->
                            <div class="row mb-3">
                                <!-- Detalle de la tarea -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <h3>Tarea:<?php echo $tarea->titulo ?></h3>
                                        <h4>Curso: <?php echo $Curso->descripcion ?></h4>
                                        <p>Descripción:<?php echo $tarea->descripcion ?></p>
                                        <a href="../tareasAsignadas/<?php echo $tarea->archivo ?>" class="btn btn-secondary" download="<?php echo $tarea->titulo; ?>">Descargar Tarea</a>
                                    </div>
                                </div>
                                <!-- Subir tarea -->
                                <div class="row mb-3">
                                    <div class="col-12">
                                        <label for="subirTarea" class="form-label">Subir Tarea</label>
                                        <input type="hidden" value="<?php echo $tareaA->id ?>" class="form-control input-default" id="tarea" name="alumno_tarea[id]">
                                        <input type="hidden" value="<?php echo $tarea->id ?>" class="form-control input-default" id="tarea" name="alumno_tarea[id_tarea]">
                                        <input type="hidden" value="<?php echo $_SESSION['id_alumno'] ?>" class="form-control input-default" id="tarea" name="alumno_tarea[id_alumno]">
                                        <input type="hidden" value="1" class="form-control input-default" id="tarea" name="alumno_tarea[estado]">
                                        <input type="hidden" value="<?php echo date('Y-m-d') ?>" class="form-control input-default" id="tarea" name="alumno_tarea[fecha_entrega]">
                                        <input type="file" class="form-control input-default" id="tarea" name="alumno_tarea[archivo]">
                                    </div>
                                </div>
                                <!-- Botón de subir -->
                                <div class="row mt-3 justify-content-end">
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary">Subir</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>