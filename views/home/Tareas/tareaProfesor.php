<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Tareas</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Profesor</a></li>
            </ol>
        </div>
        <?php foreach ($errores as $error) : ?>
            <div class="alert alert-danger solid alert-dismissible fade show">
                <svg viewBox="0 0 24 24" width="24 " height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2"></polygon>
                    <line x1="15" y1="9" x2="9" y2="15"></line>
                    <line x1="9" y1="9" x2="15" y2="15"></line>
                </svg>
                <strong>!Error! </strong> <?php echo $error; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close">
                </button>
            </div>
        <?php endforeach; ?>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 ">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row d-flex align-items-center">
                                <!-- Selector de Aulas -->
                                <label for="titulo">Seleccionar aula y curso:</label>
                                <!-- Selector de Aulas y Cursos en una fila -->
                                <div class="col-xl-3 col-sm-6 mb-3">
                                    <select class="form-select" name="id_aula">
                                        <option value="AL">Todo</option>
                                        <?php $aulasMostradas = []; ?>
                                        <?php foreach ($aulasPermitidas as $aula): ?>
                                            <?php $aulaPersona = $buscaAula->find($aula->id_aula); ?>
                                            <?php if (!in_array($aulaPersona->id, $aulasMostradas)): ?>
                                                <?php $aulasMostradas[] = $aulaPersona->id;  ?>
                                                <?php if ($aulaPersona->id === $id_aula): ?>
                                                    <option value="<?php echo $aulaPersona->id ?>" selected><?php echo $aulaPersona->nombre ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $aulaPersona->id ?>"><?php echo $aulaPersona->nombre ?></option>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Selector de Cursos -->
                                <div class="col-xl-3 col-sm-6 mb-3">
                                    <select class="form-select" name="id_curso">
                                        <option value="AL">Todo</option>
                                        <?php $cursoMostradas = []; ?>
                                        <?php foreach ($aulasPermitidas as $curso): ?>
                                            <?php $cursoPersona = $buscaCurso->find($curso->id_curso); ?>
                                            <?php if (!in_array($cursoPersona->id, $cursoMostradas)): ?>
                                                <?php $cursoMostradas[] = $cursoPersona->id;  ?>
                                                <?php if ($cursoPersona->id === $id_curso): ?>
                                                    <option value="<?php echo $cursoPersona->id ?>" selected><?php echo $cursoPersona->descripcion ?></option>
                                                <?php else: ?>
                                                    <option value="<?php echo $cursoPersona->id ?>"><?php echo $cursoPersona->descripcion ?></option>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <!-- Botón Agregar -->
                                <div class="col-xl-4 mb-3">
                                    <button name="Seleccionar" type="submit" class="btn btn-primary mb-2"><span
                                            class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                                        </span>Seleccionar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <?php if ($_SESSION['rol'] == '5' && $seleccionar === true): ?>
                <div class="col-xl-12">
                    <div class="card">
                        <form method="post" enctype="multipart/form-data">
                            <div class="card-header">
                                <h4 class="card-title text-center">Asignar Tarea</h4>
                                <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Alumnos</button>
                                <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-xl">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Asignación de tarea</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h4 class="card-title">Alumnos</h4>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="table-responsive">
                                                            <table id="example5" class="display" style="min-width: 845px">
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            <div class="form-check custom-checkbox ms-2">
                                                                                <input type="checkbox" class="form-check-input" id="checkAll">
                                                                                <label class="form-check-label" for="checkAll"></label>
                                                                            </div>
                                                                        </th>
                                                                        <th>Nombres</th>
                                                                        <th>Genero</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php foreach ($matriculados as $matriculado): ?>
                                                                        <?php foreach ($alumnos as $alumno): ?>
                                                                            <?php if ($alumno->id === $matriculado->id_alumno): ?>
                                                                                <?php foreach ($usuarios as $usuario): ?>
                                                                                    <?php if ($usuario->id === $alumno->id_usuario): ?>
                                                                                        <tr>
                                                                                            <td>
                                                                                                <div class="form-check custom-checkbox ms-2">
                                                                                                    <input type="checkbox" class="form-check-input" name="alumnos[]" value="<?php echo $alumno->id; ?>" id="customCheckBox<?php echo $alumno->id; ?>">
                                                                                                    <label class="form-check-label" for="customCheckBox<?php echo $alumno->id; ?>"></label>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td><?php echo $usuario->nombre . ' ' . $usuario->apellidos ?></td>
                                                                                            <td><?php echo $usuario->sexo ?></td>
                                                                                        </tr>
                                                                                    <?php endif; ?>
                                                                                <?php endforeach; ?>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    <?php endforeach; ?>
                                                                </tbody>


                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <div class="row">
                                        <input value="<?php echo $_SESSION['id_profesor'] ?>" type="hidden" class="form-control input-default" id="titulo" name="tarea[id_profesor]" placeholder="Escribe el título">
                                        <!-- Primera columna del formulario -->
                                        <div class="col-md-6">
                                            <!-- Campos de título y descripción -->
                                            <input type="hidden" value="<?php echo $id_aula ?>" class="form-control input-default" id="titulo" name="tarea[id_aula]" placeholder="Escribe el título">
                                            <input type="hidden" value="<?php echo $id_curso ?>" class="form-control input-default" id="titulo" name="tarea[id_curso]" placeholder="Escribe el título">
                                            <div class="mb-3">
                                                <label for="titulo">Título:</label>
                                                <input type="text" class="form-control input-default" id="titulo" name="tarea[titulo]" placeholder="Escribe el título">
                                            </div>
                                            <div class="mb-3">
                                                <label for="descripcion">Descripción:</label>
                                                <textarea class="form-control input-default" id="descripcion" name="tarea[descripcion]" rows="5" placeholder="Escribe la descripción"></textarea>
                                            </div>
                                        </div>
                                        <!-- Segunda columna del formulario -->
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <p class="mb-1">Fecha de inicio:</p>
                                                <!-- <input  class="datepicker-default form-control" id="datepicker" name="tarea[fechaInicio]"> -->
                                                <!-- <label for="fechaInicio">Fecha de inicio:</label> -->
                                                <input type="date" class="form-control " name="tarea[fecha_inicio]">
                                            </div>
                                            <div class="mb-3">
                                                <p class="mb-1">Fecha de fin:</p>
                                                <!-- <input  class="datepicker-default form-control" id="datepicker" name="tarea[fechaFin]"> -->
                                                <!-- <label for="fechaFin">Fecha de fin:</label> -->
                                                <input type="date" class="form-control " name="tarea[fecha_fin]">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tarea">Tarea:</label>
                                                <input type="file" class="form-control input-default" id="tarea" name="tarea[archivo]">
                                            </div>
                                            <div class="mb-3">
                                                <label for="tarea">Tipo de evaluación:</label>
                                                <select id="sexo" name="tarea[tipo_evaluacion]" class="nice-select form-control default-select dashboard-select-2 h-auto wide" required>
                                                    <option value="" disabled selected>Seleccione...</option>
                                                    <?php foreach ($tipos_evaluacion as $tipos) : ?>
                                                        <option value="<?php echo $tipos->id ?>"><?php echo $tipos->nombre ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Botón de submit -->
                                    <div class="submit-btn-container text-end mt-4">
                                        <button type="submit" name="Subir" class="btn btn-primary">Subir</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            <?php endif; ?>
        </div>
    </div>
</div>