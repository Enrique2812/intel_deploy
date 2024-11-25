<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Gestión</a></li>
                <li class="breadcrumb-item  active"><a href="javascript:void(0)">Crear Aulas</a></li>
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
        <div class="row page-titles">
            <form class="needs-validation" novalidate method="POST" action="/crear/aula">
                <div class="row">
                    <div class="col-xl-6">

                        <div class="row mb-3">
                            <label for="nivel" class="col-sm-4 col-form-label">Nivel <span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                <select name="aula[id_nivel]" id="nivel" class="form-select" required>
                                    <option selected disabled>-Seleccione-</option>
                                    <?php foreach ($niveles as $nivel) : ?>
                                        <option value="<?php echo $nivel->id ?>" data-abreviatura="<?php echo $nivel->abreviatura ?>"><?php echo $nivel->descripcion ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Debes seleccionar un nivel.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="grado" class="col-sm-4 col-form-label">Grado <span class="text-danger">*</span></label>
                            <div class="col-sm-8">

                                <select name="aula[id_grado]" id="grado" class="form-select" required>
                                    <option selected disabled>-Seleccione-</option>
                                    <?php foreach ($grados as $grado) : ?>
                                        <option value="<?php echo $grado->id ?>" data-abreviatura="<?php echo $grado->abreviatura ?>"><?php echo $grado->descripcion ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Debes seleccionar un grado.</div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="tutor" class="col-sm-4 col-form-label">Tutor (Sección) <span class="text-danger">*</span></label>
                            <div class="col-sm-8">

                                <select name="aula[tutor]" id="single-select" class="form-select">
                                    <option selected disabled>-Seleccione-</option>
                                    <?php foreach ($profesores as $profesor) : ?>
                                        <?php foreach ($usuarios as $usuario) : ?>
                                            <?php if ($profesor->id_usuario === $usuario->id && $profesor->tutor === '1'&& $profesor->estadoAula != '1'): ?>
                                                <option value="<?php echo $profesor->id ?>" data-nombre="<?php echo $usuario->nombre ?>"><?php echo $usuario->nombre ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Debes seleccionar un tutor.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="nombreAula" class="col-sm-4 col-form-label">Nombre del Aula:</label>
                            <div class="col-sm-8">

                                <input type="text" class="form-control" id="nombreAula" name="aula[nombre]" readonly>
                            </div>
                        </div>
                    </div>

                    <style>
                        .nice-select .list {
                            max-height: 200px;
                            /* Altura máxima cuando está desplegado */
                            overflow-y: auto;
                            /* Scroll vertical */
                        }
                    </style>

                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <div class="col-xl-6">
                        <div class="row mb-3">
                            <label for="turno" class="col-sm-4 col-form-label">Turno</label>
                            <div class="col-sm-8">

                                <select name="aula[id_turno]" id="turno" class="nice-select form-control default-select dashboard-select-2 h-auto wide" required>
                                    <option selected disabled>-Seleccione-</option>
                                    <?php foreach ($turnos as $turno) : ?>
                                        <option value="<?php echo $turno->id ?>"><?php echo $turno->descripcion ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">
                                    Debes seleccionar un turno.
                                </div>
                            </div>
                        </div>
                        <script>
                            document.addEventListener('DOMContentLoaded', (event) => {
                                const turnoSelect = document.getElementById('turno');
                                const form = turnoSelect.closest('form');

                                form.addEventListener('submit', (e) => {
                                    if (turnoSelect.value === "") {
                                        turnoSelect.setCustomValidity('Debes seleccionar un turno.');
                                        turnoSelect.classList.add('is-invalid');
                                        e.preventDefault();
                                    } else {
                                        turnoSelect.setCustomValidity('');
                                        turnoSelect.classList.remove('is-invalid');
                                    }
                                });
                            });
                        </script>
                        <!-- <div class="row mb-3">
                            <label for="seccion" class="col-sm-4 col-form-label">Sección</label>
                            <div class="col-sm-8">
                                <select name="aula[id_seccion]" id="seccion" class="nice-select form-control default-select dashboard-select-2 h-auto wide" required> -->
                                    <!-- <option selected disabled>-Seleccione-</option> -->
                                    <?php
                                    //  foreach ($secciones as $seccion) :
                                      ?>
                                        <!-- <option value="<?php                                        
                                        //  echo $seccion->id
                                          ?>"><?php 
                                        //  echo $seccion->descripcion 
                                          ?></option> -->
                                    <?php 
                                // endforeach;
                                 ?>
                                <!-- </select>
                                <div class="invalid-feedback">
                                    Debes seleccionar una sección.
                                </div>
                            </div>
                        </div> -->
                        <script>
                            document.addEventListener('DOMContentLoaded', (event) => {
                                const seccionSelect = document.getElementById('seccion');
                                const form = seccionSelect.closest('form');

                                form.addEventListener('submit', (e) => {
                                    if (seccionSelect.value === "") {
                                        seccionSelect.setCustomValidity('Debes seleccionar una sección.');
                                        seccionSelect.classList.add('is-invalid');
                                        e.preventDefault();
                                    } else {
                                        seccionSelect.setCustomValidity('');
                                        seccionSelect.classList.remove('is-invalid');
                                    }
                                });
                            });
                        </script>
                        <div class="row mb-3">
                            <label for="multi-value-select" class="col-sm-4 col-form-label">Cursos</label>
                            <div class="col-sm-8">
                                <select name="cursos[]" id="multi-value-select" multiple="multiple" class="form-control">
                                    <?php foreach ($cursos as $curso) : ?>
                                        <option value="<?php echo $curso->id ?>"><?php echo $curso->descripcion ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback"></div> <!-- Deja este div vacío -->
                            </div>
                        </div>
                        <script>
                            $(document).ready(function() {
                                $('#grado').prop('disabled', true); // Inicialmente deshabilitar el desplegable "grado"

                                function updateNombreAula() {
                                    var nivel = $('#nivel option:selected').data('abreviatura');
                                    var grado = $('#grado option:selected').data('abreviatura');
                                    var tutor = $('#single-select option:selected').data('nombre');
                                    if (nivel && grado && tutor) {
                                        $('#nombreAula').val(nivel + ' ' + grado + ' ' + tutor);
                                    } else {
                                        $('#nombreAula').val('');
                                    }
                                }

                                $('#nivel, #grado, #single-select').on('change', function() {
                                    updateNombreAula();
                                });

                                $('#nivel').on('change', function() {
                                    var nivelId = $(this).val();
                                    if (nivelId) {
                                        $('#grado').prop('disabled', false); // Habilitar el desplegable "grado" cuando se seleccione "nivel"
                                        $.ajax({
                                            url: '/gestion/obtenerGradosPorNivel',
                                            type: "POST",
                                            data: {
                                                nivelId: nivelId
                                            },
                                            dataType: "json",
                                            success: function(data) {
                                                $('#grado').empty();
                                                $('#grado').append('<option selected disabled>-Seleccione-</option>');
                                                $.each(data, function(key, value) {
                                                    $('#grado').append('<option value="' + value.id + '" data-abreviatura="' + value.abreviatura + '">' + value.descripcion + '</option>');
                                                });
                                                updateNombreAula();
                                            },
                                            error: function() {
                                                console.log('Error al obtener los grados');
                                            }
                                        });
                                    } else {
                                        $('#grado').empty();
                                        $('#grado').append('<option selected disabled>-Seleccione-</option>');
                                        $('#grado').prop('disabled', true); // Mantener "grado" deshabilitado si no se selecciona "nivel"
                                    }
                                });

                                // Añadir esta función para verificar si todos los campos requeridos están llenos
                                function validateForm() {
                                    let isValid = true;

                                    $('select[required]').each(function() {
                                        if ($(this).val() === null) {
                                            isValid = false;
                                            $(this).addClass('is-invalid'); // Añadir borde rojo
                                        } else {
                                            $(this).removeClass('is-invalid'); // Quitar borde rojo si está lleno
                                        }
                                    });

                                    if ($('#single-select').val() === null) {
                                        isValid = false;
                                        $('#single-select').addClass('is-invalid'); // Añadir borde rojo
                                    } else {
                                        $('#single-select').removeClass('is-invalid'); // Quitar borde rojo si está lleno
                                    }

                                    if ($('#turno').val() === null) {
                                        isValid = false;
                                        $('#turno').addClass('is-invalid'); // Añadir borde rojo
                                    } else {
                                        $('#turno').removeClass('is-invalid'); // Quitar borde rojo si está lleno
                                    }

                                    if ($('#seccion').val() === null) {
                                        isValid = false;
                                        $('#seccion').addClass('is-invalid'); // Añadir borde rojo
                                    } else {
                                        $('#seccion').removeClass('is-invalid'); // Quitar borde rojo si está lleno
                                    }

                                    if ($('#multi-value-select').val() === null || $('#multi-value-select').val().length === 0) {
                                        isValid = false;
                                        $('#multi-value-select').addClass('is-invalid'); // Añadir borde rojo
                                    } else {
                                        $('#multi-value-select').removeClass('is-invalid'); // Quitar borde rojo si está lleno
                                    }

                                    return isValid;
                                }

                                // Adjuntar la validación al evento de envío del formulario sin mostrar una alerta
                                $('form').on('submit', function(event) {
                                    if (!validateForm()) {
                                        event.preventDefault(); // Prevenir el envío del formulario si la validación falla
                                    }
                                });
                            });
                        </script>
                    </div>
                    <div class="card-body d-flex justify-content-between">
                        <!-- Botón que dispara el modal -->
                        <a href="/gestion/aulas" class="btn btn-danger mb-2"><span
                                class="btn-icon-start text-info"><i class="fa-solid fa-xmark fa-xl"></i>
                            </span>Cancelar</a>
                        <button type="submit" class="btn btn-rounded btn-success"><span
                                class="btn-icon-start text-success"><i class="fa fa-upload color-success"></i>
                            </span>Guardar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>