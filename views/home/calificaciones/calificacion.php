<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <?php if ($_SESSION['rol'] === '5'): ?>
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-titles">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Calificación</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Reporte</a></li>
                        </ol>
                    </div>
                    <div class="filter cm-content-box box-primary">

                        <div class="cm-content-body  form excerpt">


                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example3" class="display" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nro</th>
                                                        <th>Alumno</th>

                                                        <th>Fecha</th>
                                                        <th>T. Reporte</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($alumnos)): ?>
                                                        <?php $nro = 1; ?>
                                                        <?php foreach ($alumnos as $alumno): ?>
                                                            <tr>
                                                                <td><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""></td>
                                                                <td><?php echo $nro++; ?></td>
                                                                <td><a href="javascript:void(0);"><strong><?php echo $alumno->nombre_completo; ?></strong></a></td>
                                                                <td><a href="javascript:void(0);"><strong><?php echo $alumno->aula_nombre; ?></strong></a></td>
                                                                <td><a href="javascript:void(0);"><strong><?php echo date('d/m/Y'); ?></strong></a></td>
                                                                <td>
                                                                    <!-- Botón para abrir el modal -->
                                                                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalAgregar<?php echo $alumno->id; ?>">Agregar</button>
                                                                </td>
                                                            </tr>

                                                            <!-- Modal para Agregar Reporte -->
                                                            <div class="modal fade" id="modalAgregar<?php echo $alumno->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Agregar Reporte</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <form class="needs-validation" novalidate method="POST" action="/calificaciones/crear" enctype="multipart/form-data">
                                                                            <div class="modal-body">
                                                                                <div class="form-validation">
                                                                                    <div class="row">
                                                                                        <div class="col-xl-6">
                                                                                            <label for="archivo1_<?php echo $alumno->id; ?>" class="form-label">Reporte Mac</label>
                                                                                            <input class="form-control" type="file" id="archivo1_<?php echo $alumno->id; ?>" name="reporte[archivo_1]" required>
                                                                                        </div>
                                                                                        <div class="col-xl-6">
                                                                                            <label for="archivo2_<?php echo $alumno->id; ?>" class="form-label">Reporte Max</label>
                                                                                            <input class="form-control" type="file" id="archivo2_<?php echo $alumno->id; ?>" name="reporte[archivo_2]" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-xl-6">
                                                                                            <label for="archivo3_<?php echo $alumno->id; ?>" class="form-label">Reporte Psicologia</label>
                                                                                            <input class="form-control" type="file" id="archivo3_<?php echo $alumno->id; ?>" name="reporte[archivo_3]" required>
                                                                                        </div>
                                                                                        <div class="col-xl-6">
                                                                                            <label for="archivo4_<?php echo $alumno->id; ?>" class="form-label">Reporte Tutoria</label>
                                                                                            <input class="form-control" type="file" id="archivo4_<?php echo $alumno->id; ?>" name="reporte[archivo_4]" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-12">
                                                                                            <div class="mb-3">
                                                                                                <label for="descripcion_<?php echo $alumno->id; ?>">Descripción</label>
                                                                                                <textarea class="form-control" id="descripcion_<?php echo $alumno->id; ?>" name="reporte[descripcion]" placeholder="Descripción del reporte" required></textarea>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <input type="hidden" name="reporte[id_alumno]" value="<?php echo htmlspecialchars($alumno->id); ?>">
                                                                                    <input type="hidden" name="reporte[id_aula]" value="<?php echo htmlspecialchars($alumno->id_aula); ?>">
                                                                                    <input type="hidden" name="reporte[id_profesor]" value="<?php echo htmlspecialchars($_SESSION['id_profesor']); ?>">
                                                                                    <!-- <input type="hidden" name="reporte[id_ano]" value="<?php echo date('Y'); ?>"> -->
                                                                                    <input type="hidden" name="reporte[fecha_ingreso]" value="<?php echo date('Y-m-d'); ?>">
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


                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="6">No hay alumnos disponibles.</td>
                                                        </tr>
                                                    <?php endif; ?>
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
        <?php endif; ?>

        <?php if ($_SESSION['rol'] === '4'): ?>
            <div class="row">
                <div class="col-xl-12">
                    <div class="page-titles">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Calificación</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Calificaciones</a></li>
                        </ol>
                    </div>
                    <div class="filter cm-content-box box-primary">

                        <div class="cm-content-body  form excerpt">
                            <div class="card-body">



                            </div>

                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example3" class="display" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Nro</th>
                                                        <th>Alumno</th>
                                                        <th>Fecha</th>
                                                        <th>Reporte</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php if (!empty($reportes)): ?>
                                                        <?php $nro = 1; ?>
                                                        <?php foreach ($reportes as $reporte): ?>
                                                            <tr>
                                                                <td><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""></td>
                                                                <td><?php echo $nro++; ?></td>
                                                                <td><a href="javascript:void(0);"><strong><?php echo $reporte->nombre_aula; ?></strong></a></td>
                                                                <td><a href="javascript:void(0);"><strong><?php echo date('Y-m-d', strtotime($reporte->fecha_ingreso)); ?></strong></a></td>
                                                                <td>
                                                                    <!-- Botón para abrir el modal -->
                                                                    <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalVer<?php echo $reporte->id; ?>">Ver</button>
                                                                </td>
                                                            </tr>

                                                            <!-- Modal para Ver Reporte -->
                                                            <div class="modal fade" id="modalVer<?php echo $reporte->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                                <div class="modal-dialog modal-lg">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title">Ver Reporte</h5>
                                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                        
                                                                            <div class="form-validation">
                                                                                <div class="row">
                                                                                    <div class="col-xl-6">
                                                                                        <label class="form-label">Reporte Mac</label>
                                                                                        <p><a download="resueltos" href="../uploads/<?php echo urlencode(trim($reporte->archivo_1)); ?>"><?php echo $reporte->archivo_1; ?></a></p>
                                                                                    </div>
                                                                                    <div class="col-xl-6">
                                                                                        <label class="form-label">Reporte Max</label>
                                                                                        <p><a download="resueltos"  href="../uploads/<?php echo urlencode(trim($reporte->archivo_2)); ?>"><?php echo $reporte->archivo_2; ?></a></p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-xl-6">
                                                                                        <label class="form-label">Reporte Psicologia</label>
                                                                                        <p><a download="resueltos"  href="../uploads/<?php echo urlencode(trim($reporte->archivo_3)); ?>"><?php echo $reporte->archivo_3; ?></a></p>
                                                                                    </div>
                                                                                    <div class="col-xl-6">
                                                                                        <label class="form-label">Reporte Tutoria</label>
                                                                                        <p><a download="resueltos"  href="../uploads/<?php echo urlencode(trim($reporte->archivo_4)); ?>"><?php echo $reporte->archivo_4; ?></a></p>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-12">
                                                                                        <div class="mb-3">
                                                                                            <label class="form-label">Descripción</label>
                                                                                            <p><?php echo $reporte->descripcion; ?></p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="modal-footer d-flex justify-content-between">
                                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; ?>
                                                    <?php else: ?>
                                                        <tr>
                                                            <td colspan="6">No hay reportes disponibles.</td>
                                                        </tr>
                                                    <?php endif; ?>
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
        <?php endif; ?>
    </div>
</div>