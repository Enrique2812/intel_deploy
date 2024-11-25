<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Configuración</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Años</a></li>
                    </ol>
                </div>
                <div class="filter cm-content-box box-primary">


                    <div class="card-body  text-start">


                        <!-- Botón que dispara el modal -->
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><span
                                class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                            </span>Agregar</button>


                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Datos del año escolar</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                        </button>
                                    </div>
                                    <form class="needs-validation" novalidate method="POST" action="/crear/anio">
                                        <div class="modal-body">
                                            <div class="form-validation">
                                                <div class="row">
                                                    <div class="col-xl-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="descripcion">Descripción <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="descripcion" name="anio[descripcion]" placeholder="Introduzca una descripción" required>
                                                            <div class="invalid-feedback">
                                                                Debes llenar el campo de descripción.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="id_tipo_periodo">Período <span class="text-danger">*</span></label>
                                                            <div class="col-xl-12 mb-3">
                                                                <select id="id_tipo_periodo" name="anio[id_tipo_periodo]" class="nice-select form-control default-select dashboard-select-2 h-auto wide" required>
                                                                    <option value="1">Bimestre</option>
                                                                    <option value="2">Trimestre</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Debes seleccionar un período.
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="cantidad_periodos">Cantidad de periodos <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="cantidad_periodos" name="anio[cantidad_periodos]" placeholder="Introduzca la cantidad de periodos" required>
                                                            <div class="invalid-feedback">
                                                                Debes introducir una cantidad válida.
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-xl-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="semanas_periodo">Nro de semanas <span class="text-danger">*</span></label>
                                                            <input type="number" class="form-control" id="semanas_periodo" name="anio[semanas_periodo]" placeholder="Introduzca el número de semanas" required>
                                                            <div class="invalid-feedback">
                                                                Debes introducir un número válido.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="numero">Año <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" id="numero" name="anio[numero]" placeholder="Introduzca el año" required>
                                                            <div class="invalid-feedback">
                                                                Debes llenar el campo de año.
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-between">
                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary">Registrar</button>
                                        </div>
                                    </form>


                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="card">

                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>

                                            <th>Nombre</th>
                                            <th>Cantidad</th>
                                            <th>Semanas c/u</th>
                                            <th>Año</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($anios as $anio): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($tiposPeriodo[$anio->id_tipo_periodo]->tipo_periodo ?? 'Desconocido'); ?></td>
                                                <td><?= htmlspecialchars($anio->cantidad_periodos); ?></td>
                                                <td><?= htmlspecialchars($anio->semanas_periodo); ?></td>
                                                <td><?= htmlspecialchars($anio->numero); ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
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