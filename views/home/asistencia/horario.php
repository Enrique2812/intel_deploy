<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Asistencia</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Horarios</a></li>
                    </ol>
                </div>
                <div class="filter cm-content-box box-primary">


                    <div class="card-body text-start">

                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Agregar</button>

                        <!-- Modal -->
                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Agregar Horario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" action="">
                                        <input type="hidden" id="horario_id" name="horario_id">
                                            <div class="mb-3">
                                                <label for="id_nivel" class="form-label">Nivel</label>
                                                <input type="text" class="form-control" id="id_nivel" name="id_nivel" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Descripcion" class="form-label">Descripción</label>
                                                <input type="text" class="form-control" id="Descripcion" name="Descripcion" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="HoraIni" class="form-label">Hora Inicio</label>
                                                <input type="time" class="form-control" id="HoraIni" name="HoraIni" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="HoraFin" class="form-label">Hora Fin</label>
                                                <input type="time" class="form-control" id="HoraFin" name="HoraFin" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </form>
                                    </div>



                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="card-body text-start">



                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title">HORARIOS</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table id="example3" class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:80px;"><strong>#</strong></th>
                                                                <th><strong>Nivel</strong></th>
                                                                <th><strong>Descripcion</strong></th>
                                                                <th><strong>Hora Ini</strong></th>
                                                                <th><strong>Hora Fin</strong></th>
                                                                <th class="text-end"><strong>Acciones</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($horarios as $index => $horario): ?>
                                                                <tr>
                                                                <td><?php echo htmlspecialchars($horario->id ?? ''); ?></td>
                                                                    <td><?php echo htmlspecialchars($horario->id_nivel ?? ''); ?></td>
                                                                    <td><?php echo htmlspecialchars($horario->Descripcion ?? ''); ?></td>
                                                                    <td><?php echo date('H:i:s', strtotime($horario->HoraIni)); ?></td>
                                                                    <td><?php echo date('H:i:s', strtotime($horario->HoraFin)); ?></td>

                                                                    <td class="text-end">
                                                                        <div class="dropdown">
                                                                            <button type="button" class="btn btn-success light sharp" data-bs-toggle="dropdown">
                                                                                <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1">
                                                                                    <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                                        <rect x="0" y="0" width="24" height="24" />
                                                                                        <circle fill="#000000" cx="5" cy="12" r="2" />
                                                                                        <circle fill="#000000" cx="12" cy="12" r="2" />
                                                                                        <circle fill="#000000" cx="19" cy="12" r="2" />
                                                                                    </g>
                                                                                </svg>
                                                                            </button>
                                                                            <div class="dropdown-menu">
                                                                                <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"
                                                                                    data-id="<?php echo $horario->id; ?>"
                                                                                    data-id_nivel="<?php echo $horario->id_nivel; ?>"
                                                                                    data-descripcion="<?php echo $horario->Descripcion; ?>"
                                                                                    data-hora_ini="<?php echo $horario->HoraIni; ?>"
                                                                                    data-hora_fin="<?php echo $horario->HoraFin; ?>"
                                                                                    onclick="loadHorarioData(this)">Editar</a>

                                                                                <a class="dropdown-item" href="#">Delete</a>
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
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
                </div>
            </div>
        </div>
    </div>
    <script>
        function loadHorarioData(button) {
            var id = button.getAttribute('data-id');
            var idNivel = button.getAttribute('data-id_nivel');
            var descripcion = button.getAttribute('data-descripcion');
            var horaIni = button.getAttribute('data-hora_ini');
            var horaFin = button.getAttribute('data-hora_fin');

            // Asignar los valores al modal
            document.getElementById('horario_id').value = id;
            document.getElementById('id_nivel').value = idNivel;
            document.getElementById('Descripcion').value = descripcion;
            document.getElementById('HoraIni').value = horaIni;
            document.getElementById('HoraFin').value = horaFin;
        }
    </script>

</div>