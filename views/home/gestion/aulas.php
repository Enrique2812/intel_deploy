<div class="content-body">
    <div class="container-fluid">

        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gestion</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Aulas</a></li>
            </ol>
        </div>
        <!-- row -->

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
        <div class="row">
            <div class="col-12 mx-auto">
                <div class="card mx-auto">



                    <div class="card-body text-start ">
                        <!-- Botón que dispara el modal -->
                        <a href="/crear/aula" class="btn btn-primary mb-2"><span
                                class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                            </span>Agregar</a>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="card">

                                <div class="card-body">
                                    <div class="table-responsive">

                                        <table id="example" class="display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>Aula</th>
                                                    <th>Nivel</th>
                                                    <th>Grado</th>
                                                    <th>Tutor</th>
                                                    <th>Turno</th>
                                                    <th>Sección</th>
                                                    <th>Fecha</th>
                                                    <th>Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($aulas as $aula):
                                                ?>
                                                    <tr>

                                                        <td><?php echo $aula->nombre ?></td>
                                                        <td>
                                                            <?php foreach ($niveles as $nivel) : ?>
                                                                <?php
                                                                if ($aula->id_nivel === $nivel->id) {
                                                                    echo $nivel->abreviatura;
                                                                }
                                                                ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <td>
                                                            <?php foreach ($grados as $grado) : ?>
                                                                <?php
                                                                if ($aula->id_grado === $grado->id) {
                                                                    echo $grado->abreviatura;
                                                                }
                                                                ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <td>
                                                            <?php foreach ($profesores as $profesor) : ?>
                                                                <?php if ($aula->tutor ===  $profesor->id): ?>
                                                                    <?php foreach ($usuarios as $usuario) : ?>
                                                                        <?php if ($profesor->id_usuario === $usuario->id): ?>
                                                                            <?php echo $usuario->nombre . " " . $usuario->apellidos  ?>
                                                                        <?php endif; ?>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <td>
                                                            <?php foreach ($turnos as $turno) : ?>
                                                                <?php
                                                                if ($aula->id_turno === $turno->id) {
                                                                    echo $turno->abreviatura;
                                                                }
                                                                ?>
                                                            <?php endforeach; ?>
                                                        </td>
                                                        <td>
                                                            <?php foreach ($secciones as $seccione) : ?>
                                                                <?php
                                                                if ($aula->id_seccion === $seccione->id) {
                                                                    echo $seccione->abreviatura;
                                                                }
                                                                ?>

                                                            <?php
                                                            endforeach;
                                                            ?>
                                                        </td>
                                                        <td><?php echo date('d-m-Y', strtotime($aula->fecha_ingreso)); ?></td>
                                                        <td>

                                                            <div class="d-flex">
                                                                <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $aula->id; ?>"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="/eliminar/aula?id=<?php echo $aula->id ?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </td>

                                                        <!-- Modal -->
                                                        <div class="modal fade bd-example-modal-lg edit" id="editModal-<?php echo $aula->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Editar</h5>
                                                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                                        </button>
                                                                    </div>
                                                                    <form class="needs-validation" novalidate method="POST" action="/editar/aula">
                                                                        <div class="modal-body">

                                                                            <div class="form-validation">
                                                                                <div class="row">
                                                                                    <div class="col-xl-12">

                                                                                        <div class="mb-3 row">
                                                                                            <label class="col-lg-4 col-form-label" for="validationCustom01">Aula <span class="text-danger">*</span></label>
                                                                                            <div class="col-lg-6">
                                                                                                <input value="<?php echo $aula->nombre ?>" type="text" class="form-control" id="validationCustom01" name="aula[nombre]" placeholder="Introduzca el nombre del aula"  required>

                                                                                                <input type="hidden" id="aula[id]" value="<?php echo $aula->id ?>" name="aula[id]" required>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Campo del nivel -->
                                                                                        <div class="mb-3 row">
                                                                                            <label class="col-lg-4 col-form-label" for="nivel-<?php echo $aula->id; ?>">Nivel <span class="text-danger">*</span></label>
                                                                                            <div class="col-lg-6">
                                                                                                <div class="input-group transparent-append">
                                                                                                    <select name="aula[id_nivel]" class="form-select" id="nivel-<?php echo $aula->id; ?>" aria-label="Default select example">
                                                                                                        <option selected disabled>-Seleccione-</option>
                                                                                                        <?php if (isset($niveles) && is_array($niveles)) : ?>
                                                                                                            <?php foreach ($niveles as $nivel) : ?>
                                                                                                                <option value="<?php echo $nivel->id ?>" <?php echo ($nivel->id === $aula->id_nivel) ? 'selected' : '' ?>><?php echo $nivel->descripcion ?></option>
                                                                                                            <?php endforeach; ?>
                                                                                                        <?php endif; ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Campo del grado -->
                                                                                        <div class="mb-3 row">
                                                                                            <label class="col-lg-4 col-form-label" for="grado-<?php echo $aula->id; ?>">Grado <span class="text-danger">*</span></label>
                                                                                            <div class="col-lg-6">
                                                                                                <div class="input-group transparent-append">
                                                                                                    <select name="aula[id_grado]" class="form-select" id="grado-<?php echo $aula->id; ?>" aria-label="Default select example">
                                                                                                        <!-- Los grados se llenarán con JavaScript -->
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Campo del turno -->
                                                                                        <div class="mb-3 row">
                                                                                            <label class="col-lg-4 col-form-label" for="validationCustom03">Turno <span class="text-danger">*</span></label>
                                                                                            <div class="col-lg-6">
                                                                                                <div class="input-group transparent-append">
                                                                                                    <select name="aula[id_turno]" class="form-select" aria-label="Default select example">
                                                                                                        <option selected disabled>-Seleccione-</option>
                                                                                                        <?php if (isset($turnos) && is_array($turnos)) : ?>
                                                                                                            <?php foreach ($turnos as $turno) : ?>
                                                                                                                <?php if ($turno->id === $aula->id_turno) : ?>
                                                                                                                    <option value="<?php echo $turno->id ?>" selected><?php echo $turno->descripcion ?></option>
                                                                                                                <?php endif ?>
                                                                                                                <option value="<?php echo $turno->id ?>"><?php echo $turno->descripcion ?></option>
                                                                                                            <?php endforeach; ?>
                                                                                                        <?php endif; ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Campo de la sección -->
                                                                                        <div class="mb-3 row">
                                                                                            <label class="col-lg-4 col-form-label" for="validationCustom03">Sección <span class="text-danger">*</span></label>
                                                                                            <div class="col-lg-6">
                                                                                                <div class="input-group transparent-append">
                                                                                                    <select name="aula[id_seccion]" class="form-select" aria-label="Default select example">
                                                                                                        <?php if (isset($secciones) && is_array($secciones)) : ?>
                                                                                                            <?php foreach ($secciones as $seccion) : ?>
                                                                                                                <?php if ($seccion->id === $aula->id_seccion) : ?>
                                                                                                                    <option value="<?php echo $seccion->id ?>" selected><?php echo $seccion->descripcion ?></option>
                                                                                                                <?php endif ?>
                                                                                                                <option value="<?php echo $seccion->id ?>"><?php echo $seccion->descripcion ?></option>
                                                                                                            <?php endforeach; ?>
                                                                                                        <?php endif; ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <!-- Campo del tutor -->
                                                                                        <div class="mb-3 row">
                                                                                            <label class="col-lg-4 col-form-label" for="validationCustom03">Tutor <span class="text-danger">*</span></label>
                                                                                            <div class="col-lg-6">
                                                                                                <div class="input-group transparent-append">
                                                                                                    <select name="aula[tutor]" class="form-select" aria-label="Default select example">
                                                                                                        <?php if (isset($profesores) && is_array($profesores)) : ?>
                                                                                                            <?php foreach ($profesores as $profesor) : ?>
                                                                                                                <?php if (isset($usuarios) && is_array($usuarios)) : ?>
                                                                                                                    <?php foreach ($usuarios as $usuario) : ?>
                                                                                                                        <?php if ($profesor->id_usuario === $usuario->id && $profesor->tutor === '1'): ?>
                                                                                                                            <?php if ($profesor->id === $aula->tutor): ?>
                                                                                                                                <option value="<?php echo $profesor->id ?>" selected><?php echo $usuario->nombre ?></option>
                                                                                                                            <?php else : ?>
                                                                                                                                <option value="<?php echo $profesor->id ?>"><?php echo $usuario->nombre ?></option>
                                                                                                                            <?php endif; ?>
                                                                                                                        <?php endif; ?>
                                                                                                                    <?php endforeach; ?>
                                                                                                                <?php endif; ?>
                                                                                                            <?php endforeach; ?>
                                                                                                        <?php endif; ?>
                                                                                                    </select>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>

                                                                                        <input type="hidden" value="<?php echo $aula->fecha_ingreso ?>" name="aula[fecha_ingreso]" >

                                                                                        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                                                                        <script>
                                                                                            $(document).ready(function() {
                                                                                                var idNivel = <?php echo $aula->id_nivel; ?>;
                                                                                                var idGrado = <?php echo $aula->id_grado; ?>;
                                                                                                var aulaId = <?php echo $aula->id; ?>;



                                                                                                // Función para cargar los grados por nivel
                                                                                                function cargarGradosPorNivel(nivelId, gradoId, aulaId) {
                                                                                                    $.ajax({
                                                                                                        url: '/gestion/obtenerGradosPorNivel',
                                                                                                        type: "POST",
                                                                                                        data: {
                                                                                                            nivelId: nivelId
                                                                                                        },
                                                                                                        dataType: "json",
                                                                                                        success: function(data) {
                                                                                                            console.log('Datos recibidos:', data);
                                                                                                            $('#grado-' + aulaId).empty();
                                                                                                            $('#grado-' + aulaId).append('<option selected disabled>-Seleccione-</option>');
                                                                                                            if (data && data.length > 0) {
                                                                                                                $.each(data, function(key, value) {
                                                                                                                    var selected = (value.id == gradoId) ? 'selected' : '';
                                                                                                                    $('#grado-' + aulaId).append('<option value="' + value.id + '" ' + selected + '>' + value.descripcion + '</option>');
                                                                                                                });
                                                                                                            } else {
                                                                                                                $('#grado-' + aulaId).append('<option disabled>No hay grados disponibles</option>');
                                                                                                            }
                                                                                                            actualizarNombreAula(); // Actualizar el nombre del aula después de cargar los grados

                                                                                                            $('#editModal-' + aulaId).on('shown.bs.modal', function() {
                                                                                                                var nivelId = $('#nivel-' + aulaId).val(); // Obtén el id del nivel
                                                                                                                var gradoId = $('#grado-' + aulaId).val(); // Obtén el id del grado
                                                                                                                cargarGradosPorNivel(nivelId, gradoId, aulaId);
                                                                                                            });
                                                                                                        },
                                                                                                        error: function(jqXHR, textStatus, errorThrown) {
                                                                                                            console.log('Error al obtener los grados:', textStatus, errorThrown);
                                                                                                        }
                                                                                                    });
                                                                                                }

                                                                                                // Función para actualizar el nombre del aula
                                                                                                function actualizarNombreAula() {
                                                                                                    var nivel = $('#nivel-' + aulaId + ' option:selected').text();
                                                                                                    var grado = $('#grado-' + aulaId + ' option:selected').text();
                                                                                                    var tutor = $('select[name="aula[tutor]"] option:selected').text();
                                                                                                    if (nivel && grado && tutor) {
                                                                                                        $('#validationCustom01').val(nivel + ' ' + grado + ' ' + tutor);
                                                                                                    } else {
                                                                                                        $('#validationCustom01').val('');
                                                                                                    }
                                                                                                }

                                                                                                // Cargar grados al abrir el modal
                                                                                                $('#editModal-' + aulaId).on('shown.bs.modal', function() {
                                                                                                    cargarGradosPorNivel(idNivel, idGrado, aulaId);
                                                                                                });

                                                                                                // Cambiar grados cuando se selecciona un nivel diferente
                                                                                                $('#nivel-' + aulaId).on('change', function() {
                                                                                                    var nivelId = $(this).val();
                                                                                                    console.log('Nivel seleccionado:', nivelId);
                                                                                                    if (nivelId) {
                                                                                                        cargarGradosPorNivel(nivelId, null, aulaId);
                                                                                                    } else {
                                                                                                        $('#grado-' + aulaId).empty();
                                                                                                        $('#grado-' + aulaId).append('<option selected disabled>-Seleccione-</option>');
                                                                                                        actualizarNombreAula(); // Actualizar el nombre del aula cuando se cambia el nivel a vacío
                                                                                                    }
                                                                                                });

                                                                                                // Cambiar el nombre del aula cuando se selecciona el grado o el tutor
                                                                                                $('#grado-' + aulaId + ', select[name="aula[tutor]"]').on('change', function() {
                                                                                                    actualizarNombreAula();
                                                                                                });

                                                                                                // Inicializar el nombre del aula al cargar la página
                                                                                                actualizarNombreAula();
                                                                                            });
                                                                                        </script>

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
        </div>
    </div>
</div>