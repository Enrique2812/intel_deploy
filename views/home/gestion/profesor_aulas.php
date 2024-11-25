<div class="content-body">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Profesores</a></li>
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
                                        <th>
                                            <center>Nombre</center>
                                        </th>
                                        <th>
                                            <center>Nivel</center>
                                        </th>
                                        <th>
                                            <center>Grado</center>
                                        </th>
                                        <th>
                                            <center>Sección</center>
                                        </th>
                                        <th>
                                            <center>Turno</center>
                                        </th>
                                        <th>
                                            <center>Cursos y Docentes</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    foreach ($aulas as $aula):
                                    ?>
                                        <tr>
                                            <td>
                                                <center>
                                                    <?php echo $aula->nombre ?>
                                            </td>
                                            </center>
                                            <td>
                                                <center>

                                                    <?php foreach ($niveles as $nivele) : ?>
                                                        <?php
                                                        if ($aula->id_nivel === $nivele->id) {
                                                            echo $nivele->descripcion;
                                                            continue;
                                                        }
                                                        ?>
                                                    <?php endforeach; ?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>

                                                    <?php foreach ($grados as $grado) : ?>
                                                        <?php
                                                        if ($aula->id_grado === $grado->id) {
                                                            echo $grado->descripcion;
                                                            continue;
                                                        }
                                                        ?>
                                                    <?php endforeach; ?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>

                                                    <?php foreach ($secciones as $seccione) : ?>
                                                        <?php
                                                        if ($aula->id_seccion === $seccione->id) {
                                                            echo $seccione->descripcion;
                                                            continue;
                                                        }
                                                        ?>
                                                    <?php endforeach; ?>
                                                </center>
                                            </td>
                                            <td>
                                                <center>

                                                    <?php foreach ($turnos as $turno) : ?>
                                                        <?php
                                                        if ($aula->id_turno === $turno->id) {
                                                            echo $turno->descripcion;
                                                            continue;
                                                        }
                                                        ?>
                                                    <?php endforeach; ?>
                                                </center>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <a href="#" class="btn btn-primary shadow sharp me-1" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $aula->id; ?>">
                                                        <i class="fa-solid fa-book fa-xl"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <!-- Modal -->
                                            <div class="modal fade bd-example-modal-lg edit" id="editModal-<?php echo $aula->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <form class="modal-content" action="/crear/profesor_aula" method="POST">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Seleccionar Profesor por curso - <?php echo $aula->nombre; ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="col-lg-12">
                                                                    <div class="card border-0 pb-0">
                                                                        <div class="card-body p-0">
                                                                            <div id="DZ_W_Todo4" class="widget-media dlab-scroll px-4 my-4" style="height:370px;">
                                                                                <?php foreach ($cursos_personal as $index => $cursos_persona) : ?>
                                                                                    <?php if ($aula->id === $cursos_persona->id_aula) : ?>
                                                                                        <input type="hidden" name="persona_curso[<?php echo $index; ?>][id]" value="<?php echo $cursos_persona->id; ?>">
                                                                                        <input type="hidden" name="persona_curso[<?php echo $index; ?>][estado]" value="<?php echo $cursos_persona->estado; ?>">
                                                                                        <input type="hidden" name="persona_curso[<?php echo $index; ?>][id_curso]" value="<?php echo $cursos_persona->id_curso; ?>">
                                                                                        <input type="hidden" name="persona_curso[<?php echo $index; ?>][id_aula]" value="<?php echo $cursos_persona->id_aula; ?>">
                                                                                        <input type="hidden" name="persona_curso[<?php echo $index; ?>][id_año]" value="<?php echo $cursos_persona->id_año; ?>">
                                                                                        <input type="hidden" name="persona_curso[<?php echo $index; ?>][fecha_ingreso]" value="<?php echo $cursos_persona->fecha_ingreso; ?>">

                                                                                        <div class="mb-3 p-2">
                                                                                            <?php foreach ($cursos as $curso) : ?>
                                                                                                <?php if ($cursos_persona->id_curso === $curso->id) : ?>
                                                                                                    <label class="col-form-label" for="id_rol"><?php echo $curso->descripcion; ?> <span class="text-danger">*</span></label>
                                                                                                <?php endif; ?>
                                                                                            <?php endforeach; ?>

                                                                                            <div class="col-xl-12 mb-3">
                                                                                                <select name="persona_curso[<?php echo $index; ?>][id_personal]" class="form-control" style="max-height: 50px; overflow-y: auto;" required>
                                                                                                    <option value="" selected disabled>Abrir selección</option>
                                                                                                    <?php foreach ($profesores as $profesor) : ?>
                                                                                                        <?php foreach ($usuarios as $usuario) : ?>
                                                                                                            <?php if ($profesor->id_usuario === $usuario->id): ?>
                                                                                                                <option value="<?php echo $profesor->id ?>"
                                                                                                                    <?php echo ($cursos_persona->id_personal === $profesor->id) ? 'selected' : ''; ?>>
                                                                                                                    <?php echo $usuario->nombre . ' ' . $usuario->apellidos; ?>
                                                                                                                </option>
                                                                                                            <?php endif; ?>
                                                                                                        <?php endforeach; ?>
                                                                                                    <?php endforeach; ?>
                                                                                                </select>
                                                                                                <div class="invalid-feedback">
                                                                                                    Debes seleccionar un profesor.
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                                <style>
                                                                                    .limited-select {
                                                                                        max-height: 200px;
                                                                                        /* Ajusta según lo que necesites */
                                                                                        overflow-y: auto;
                                                                                    }
                                                                                </style>
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
</div>