<div class="content-body">
    <!-- row -->
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Clases en vivo</a></li>
            </ol>
        </div>




        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body text-start">

                        <?php

                        if ($_SESSION['rol'] === '4'): ?>
                            <h2>Videoconferencias Disponibles</h2>
                            <div class="row">

                                <?php if (!empty($Videoconferencia)): ?>
                                    <?php foreach ($Videoconferencia as $videoconferencia): ?>
                                        <div class="col-md-2 mb-2">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($videoconferencia->curso_nombre); ?></h5>
                                                    <p class="card-text">
                                                        <strong>Profesor:</strong> <?php echo htmlspecialchars($videoconferencia->profesor_nombre ?? ''); ?><br>
                                                        <strong>Aula:</strong> <?php echo htmlspecialchars($videoconferencia->aula_nombre); ?><br>
                                                        <strong>Descripción:</strong> <?php echo htmlspecialchars($videoconferencia->descripcion); ?><br>
                                                        <strong>Fecha:</strong> <?php echo htmlspecialchars($videoconferencia->fecha); ?><br>
                                                        <strong>Hora de Inicio:</strong> <?php echo htmlspecialchars($videoconferencia->hora_inicio); ?><br>
                                                        <strong>Hora de Fin:</strong> <?php echo htmlspecialchars($videoconferencia->hora_fin); ?><br>
                                                    </p>
                                                    <a href="<?php echo htmlspecialchars($videoconferencia->url); ?>" target="_blank" class="btn btn-primary">Unirse a la Videoconferencia</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No hay videoconferencias disponibles.</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($_SESSION['rol'] === '5'): ?>

                            <!-- Botón que dispara el modal -->
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                                <span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i></span>Agregar
                            </button>

                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ingrese Videoconferencia</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form class="needs-validation" novalidate method="POST" action="/Clases_en_vivo/crearvideoconferencia">
                                            <div class="modal-body">
                                                <div class="form-validation">
                                                    <!-- primero -->
                                                    <div class="row">
                                                        <!-- Selector de Aula -->
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="aulaSelect">Aula</label>
                                                                <select id="aulaSelect" class="form-select" name="videoconferencia[idaula]" aria-label="Seleccionar Aula" onchange="filtrarCursos()">
                                                                    <option value="">Todo</option>
                                                                    <?php $aulasMostradas = []; ?>
                                                                    <?php foreach ($aulasPermitidas as $aula): ?>
                                                                        <?php
                                                                        $aulaPersona = $buscaAula->find($aula->id_aula);
                                                                        if (!in_array($aulaPersona->id, $aulasMostradas)):
                                                                            $aulasMostradas[] = $aulaPersona->id;
                                                                        ?>
                                                                            <option value="<?php echo $aulaPersona->id ?>"><?php echo $aulaPersona->nombre ?></option>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Selector de Curso -->
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="cursoSelect">Curso</label>
                                                                <select id="cursoSelect" class="form-select" name="videoconferencia[idcurso]" aria-label="Seleccionar Curso" disabled>
                                                                    <option value="">Todo</option>
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- JavaScript para Filtrar Cursos -->
                                                        <script>
                                                            function filtrarCursos() {
                                                                const aulaId = document.getElementById('aulaSelect').value;
                                                                const cursoSelect = document.getElementById('cursoSelect');
                                                                cursoSelect.innerHTML = '<option value="">Todo</option>'; // Resetear opciones
                                                                cursoSelect.disabled = !aulaId; // Deshabilitar si no hay aula seleccionada

                                                                if (aulaId) {
                                                                    // Obtener cursos relacionados con el aula seleccionada
                                                                    <?php foreach ($aulasPermitidas as $curso): ?>
                                                                        <?php $cursoPersona = $buscaCurso->find($curso->id_curso); ?>
                                                                        if (<?php echo $curso->id_aula; ?> == aulaId) {
                                                                            const option = document.createElement('option');
                                                                            option.value = "<?php echo $cursoPersona->id; ?>";
                                                                            option.text = "<?php echo $cursoPersona->descripcion; ?>";
                                                                            cursoSelect.add(option);
                                                                        }
                                                                    <?php endforeach; ?>
                                                                }
                                                            }
                                                        </script>

                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="fecha">Fecha</label>
                                                                <input type="date" class="form-control" id="fecha" name="videoconferencia[fecha]" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="hora_inicio">Hora Inicio</label>
                                                                <input type="time" class="form-control" id="hora_inicio" name="videoconferencia[hora_inicio]" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="hora_fin">Hora Fin</label>
                                                                <input type="time" class="form-control" id="hora_fin" name="videoconferencia[hora_fin]" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="url">URL</label>
                                                                <input type="text" class="form-control" id="url" name="videoconferencia[url]" placeholder="URL de la videoconferencia" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-3">
                                                                <label for="descripcion">Descripción</label>
                                                                <textarea class="form-control" id="descripcion" name="videoconferencia[descripcion]" placeholder="Descripción de la videoconferencia" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" name="videoconferencia[idprofesor]" value="<?php echo $_SESSION['id_profesor']; ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer d-flex justify-content-between">
                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                                <button name="Subir" type="submit" class="btn btn-primary">Registrar</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Mostrar videoconferencias del profesor -->
                            <h2>Mis Videoconferencias</h2>
                            <div class="row">
                                <?php if (!empty($Videoconferencia)): ?>
                                    <?php foreach ($Videoconferencia as $videoconferencia): ?>
                                        <?php foreach ($Aulas as $Aula): ?>
                                            <?php if ($Aula->id === $videoconferencia->idaula): ?>
                                                <?php $videoconferencia->aula_nombre = $Aula->nombre; ?>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                        <div class="col-md-2 mb-2">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo $videoconferencia->curso_nombre; ?></h5> <!-- Usar curso_nombre -->
                                                    <p class="card-text">
                                                        <strong>Profesor:</strong> <?php echo $videoconferencia->profesor_nombre; ?><br> <!-- Usar aula_nombre -->
                                                        <strong>Aula:</strong> <?php echo $videoconferencia->aula_nombre; ?><br> <!-- Usar aula_nombre -->
                                                        <strong>Descripción:</strong> <?php echo $videoconferencia->descripcion; ?><br>
                                                        <strong>Fecha:</strong> <?php echo $videoconferencia->fecha; ?><br>
                                                        <strong>Hora de Inicio:</strong> <?php echo $videoconferencia->hora_inicio; ?><br>
                                                        <strong>Hora de Fin:</strong> <?php echo $videoconferencia->hora_fin; ?><br>
                                                    </p>
                                                    <a href="<?php echo $videoconferencia->url; ?>" target="_blank" class="btn btn-primary">Unirse a la Videoconferencia</a>

                                                    <!-- Botones de editar y eliminar -->
                                                    <div class="mt-2">
                                                        <!-- Botón para abrir el modal de Editar -->
                                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalEditar<?php echo $videoconferencia->id; ?>">Editar</button>
                                                        <!-- Botón para abrir el modal de Confirmación de Eliminación -->
                                                        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modalEliminar<?php echo $videoconferencia->id; ?>">Eliminar</button>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal para Editar Videoconferencia -->
                                        <div class="modal fade" id="modalEditar<?php echo $videoconferencia->id; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Editar Videoconferencia</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <form class="needs-validation" novalidate method="POST" action="/editar/ClaseVivo">
                                                        <div class="modal-body">
                                                            <!-- Campos del formulario con valores precargados -->
                                                            <input type="hidden" name="videoconferencia[id]" value="<?php echo htmlspecialchars($videoconferencia->id); ?>">
                                                            <input type="hidden" name="videoconferencia[idaula]" value="<?php echo htmlspecialchars($videoconferencia->idaula); ?>">
                                                            <input type="hidden" name="videoconferencia[idcurso]" value="<?php echo htmlspecialchars($videoconferencia->idcurso); ?>">
                                                            <input type="hidden" name="videoconferencia[idprofesor]" value="<?php echo htmlspecialchars($videoconferencia->idprofesor); ?>">
                                                            <input type="hidden" name="videoconferencia[curso_nombre]" value="<?php echo htmlspecialchars($videoconferencia->curso_nombre); ?>">
                                                            <input type="hidden" name="videoconferencia[aula_nombre]" value="<?php echo htmlspecialchars($videoconferencia->aula_nombre); ?>">
                                                            <input type="hidden" name="videoconferencia[profesor_nombre]" value="<?php echo htmlspecialchars($videoconferencia->profesor_nombre); ?>">
                                                            <!-- Resto de campos, con value asignado para precargar -->
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="mb-3">
                                                                        <label for="fecha">Fecha</label>
                                                                        <input type="date" class="form-control" id="fecha" name="videoconferencia[fecha]" required value="<?php echo htmlspecialchars($videoconferencia->fecha); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="mb-3">
                                                                        <label for="hora_inicio">Hora Inicio</label>
                                                                        <input type="time" class="form-control" id="hora_inicio" name="videoconferencia[hora_inicio]" required value="<?php echo htmlspecialchars($videoconferencia->hora_inicio); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-xl-6">
                                                                    <div class="mb-3">
                                                                        <label for="hora_fin">Hora Fin</label>
                                                                        <input type="time" class="form-control" id="hora_fin" name="videoconferencia[hora_fin]" required value="<?php echo htmlspecialchars($videoconferencia->hora_fin); ?>">
                                                                    </div>
                                                                </div>
                                                                <div class="col-xl-6">
                                                                    <div class="mb-3">
                                                                        <label for="url">URL</label>
                                                                        <input type="text" class="form-control" id="url" name="videoconferencia[url]" required value="<?php echo htmlspecialchars($videoconferencia->url); ?>">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="mb-3">
                                                                        <label for="descripcion">Descripción</label>
                                                                        <textarea class="form-control" id="descripcion" name="videoconferencia[descripcion]" required><?php echo htmlspecialchars($videoconferencia->descripcion); ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-between">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
                                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Modal para Confirmación de Eliminación -->
                                        <div class="modal fade" id="modalEliminar<?php echo $videoconferencia->id; ?>" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">Confirmar Eliminación</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Estás seguro de que quieres eliminar esta videoconferencia?</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                                        <form method="POST" action="/cambiarVision/ClaseVivo">
                                                            <!-- Campos ocultos para enviar el ID de la videoconferencia -->
                                                            <input type="hidden" name="id" value="<?php echo htmlspecialchars($videoconferencia->id); ?>">
                                                            <button type="submit" class="btn btn-danger">Sí, Eliminar</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No hay videoconferencias disponibles.</p>
                                <?php endif; ?>
                            </div>

                        <?php endif; ?>

                        <?php if ($_SESSION['rol'] === '1'): ?>
                            <h2>Videoconferencias de Todos los Profesores</h2>
                            <div class="row">
                                <?php if (!empty($videoconferenciaProfesor)): ?>
                                    <?php foreach ($videoconferenciaProfesor as $videoconferencia): ?>
                                        <div class="col-md-2 mb-2">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title"><?php echo htmlspecialchars($videoconferencia->curso_nombre); ?></h5>
                                                    <p class="card-text">
                                                        <strong>Profesor:</strong> <?php echo htmlspecialchars($videoconferencia->profesor_nombre ?? ''); ?><br>
                                                        <strong>Aula:</strong> <?php echo htmlspecialchars($videoconferencia->aula_nombre); ?><br>
                                                        <strong>Descripción:</strong> <?php echo htmlspecialchars($videoconferencia->descripcion); ?><br>
                                                        <strong>Fecha:</strong> <?php echo htmlspecialchars($videoconferencia->fecha); ?><br>
                                                        <strong>Hora de Inicio:</strong> <?php echo htmlspecialchars($videoconferencia->hora_inicio); ?><br>
                                                        <strong>Hora de Fin:</strong> <?php echo htmlspecialchars($videoconferencia->hora_fin); ?><br>
                                                    </p>
                                                    <a href="<?php echo htmlspecialchars($videoconferencia->url); ?>" target="_blank" class="btn btn-primary">Unirse a la Videoconferencia</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No hay videoconferencias disponibles.</p>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>






                    </div>
                </div>
            </div>
        </div>
    </div>

</div>