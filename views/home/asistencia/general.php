<div class="content-body">
    <div class="container-fluid">
        <!-- Breadcrumb Navigation -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Asistencia</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">General</a></li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- Filter and Forms Section -->
        <div class="row">
            <div class="col-xl-12">
                <div class="filter cm-content-box box-primary">
                    <div class="cm-content-body form excerpt">
                        <div class="card-body">
                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#miModal">
                                <i class="fas fa-pencil-alt"></i>
                            </a>


                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg edit" id="miModal" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <!-- Header -->
                                        <div class="modal-header">
                                            <h5 class="modal-title">Vinculación de Aula y Google Sheet</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <!-- Formulario -->
                                        <form id="vincularForm" class="modal-body">
                                            <div class="row mb-3">
                                                <label for="aulaSelect" class="col-sm-3 col-form-label">Selecciona un Aula:</label>
                                                <div class="col-sm-9">
                                                    <select id="aulaSelect" name="aula_id" class="form-select" onchange="actualizarGoogleSheetID(this)" required>
                                                        <option value="">Seleccionar Aula</option>
                                                        <?php foreach ($aulas as $aula): ?>
                                                            <option value="<?php echo htmlspecialchars($aula->id); ?>" data-idsheet="<?php echo htmlspecialchars($aulasGoogleSheet[$aula->id] ?? ''); ?>">
                                                                <?php echo htmlspecialchars($aula->nombre); ?>
                                                            </option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="fechaInicio" class="col-sm-3 col-form-label">Fecha de Inicio de Clases:</label>
                                                <div class="col-sm-9">
                                                    <input type="date" id="fechaInicio" name="fechaInicio" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="googleSheetURL" class="col-sm-3 col-form-label">URL del Google Sheet:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" id="googleSheetURL" name="googleSheetURL" class="form-control" placeholder="Pega el link del Google Sheet" required oninput="extraerGoogleSheetID(this)">

                                                </div>

                                            </div>

                                            <div class="row mb-3">
                                                <label for="googleSheetId" class="col-sm-3 col-form-label"></label>
                                                <div class="col-sm-9 d-flex">
                                                    <!-- Campo de texto -->
                                                    <input type="text" id="googleSheetID" name="googleSheetID" class="form-control me-2" readonly>

                                                    <!-- Botón -->
                                                    <button type="submit" class="btn btn-primary">Vincular</button>
                                                </div>
                                            </div>

                                        </form>
                                        <!-- Header -->
                                        <div class="modal-header">
                                            <h5 class="modal-title">Abrir Hojas de Aulas</h5>
                                        </div>

                                        <!-- Tabla -->
                                        <div class="modal-body">
                                            <table class="table" id="tablaAulas">
                                                <thead>
                                                    <tr>
                                                        <th>Aula</th>
                                                        <th>Link al Sheet</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <!-- Las filas se llenarán dinámicamente con JavaScript -->
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Search Form -->
                            <form id="form-buscar-asistencia" class="mt-4">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select name="grado" id="grado" class="form-control" required>
                                            <option value="">Seleccione un grado</option>
                                            <?php foreach ($grados as $grado): ?>
                                                <option value="<?= $grado->id; ?>"><?= $grado->descripcion; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select name="aula" id="aula" class="form-control" required>
                                            <option value="">Seleccione un aula</option>
                                        </select>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <input type="date" id="fechaIni" name="fechaInicio" class="form-control" required>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <input type="date" id="fechaFin" name="fechaFin" class="form-control" required>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <input type="text" id="alumnoDNI" name="alumnoDNI" placeholder="DNI alumno" class="form-control" required>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <button type="button" onclick="buscarGeneral()" class="btn btn-primary w-100">Buscar</button>
                                    </div>
                                </div>
                            </form>

                            <!-- Result Table -->
                            <div class="table-responsive mt-4">
                                <table id="example3" class="table table-striped">
                                    <thead>
                                        <tr>

                                            <th>DNI</th>
                                            <th>Alumno</th>
                                            <th>Ingreso</th>
                                            <th>Tardanza</th>
                                            <th>Salida</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Contenido dinámico -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function actualizarGoogleSheetID(selectElement) {
            const googleSheetID = selectElement.options[selectElement.selectedIndex].getAttribute('data-idsheet');

            document.getElementById('googleSheetID').value = googleSheetID || '';
        }
    </script>

    <script>
        document.getElementById('vincularForm').addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            fetch('/asistencia/vincular', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('¡Vinculación exitosa!');
                    } else {
                        alert('Error en la vinculación. Inténtalo nuevamente.');
                    }
                })
                .catch(error => {
                    console.error('Error en la petición:', error);
                    alert('Hubo un error en la conexión.');
                });
        });

        function actualizarGoogleSheetID(selectElement) {
            const googleSheetID = selectElement.options[selectElement.selectedIndex].getAttribute('data-idsheet');
            document.getElementById('googleSheetID').value = googleSheetID || '';
        }
    </script>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function buscarGeneral() {
            const grado = document.getElementById('grado').value;
            const aula = document.getElementById('aula').value;
            const fechaInicio = document.getElementById('fechaIni').value;
            const fechaFin = document.getElementById('fechaFin').value;
            const alumnoDNI = document.getElementById('alumnoDNI').value; // Obtener el valor del DNI

            // Validación de campos
            if (!grado || !aula || !fechaInicio || !fechaFin) {
                alert('Por favor, complete todos los campos para realizar la búsqueda.');
                return;
            }

            // Datos para la búsqueda
            const datosBusqueda = {
                grado,
                aula,
                fechaInicio,
                fechaFin,
                alumnoDNI
            };

            // Envío de datos mediante AJAX
            $.ajax({
                url: '/asistencia/buscarGeneral',
                type: 'GET',
                data: datosBusqueda,
                success: function(response) {
                    try {
                        document.querySelector('#example3 tbody').innerHTML = response;
                    } catch (error) {
                        console.error('Error procesando la respuesta:', error);
                        alert('Ocurrió un error inesperado. Intenta nuevamente.');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error en la petición:', status, error);
                    alert('Ocurrió un error al realizar la búsqueda.');
                }
            });
        }
    </script>


    <script>
        $(document).ready(function() {
            // Al cambiar el grado, se cargan las aulas correspondientes
            $('#grado').on('change', function() {
                const gradoId = $(this).val();

                if (gradoId) {
                    $.ajax({
                        url: '/asistencia/obtenerAulasPorGrado', // Cambia a tu ruta real
                        type: 'GET',
                        data: {
                            idGrado: gradoId
                        },
                        success: function(response) {
                            // Limpiar y actualizar el select de aulas
                            $('#aula').html('<option value="">Seleccione un aula</option>');
                            const aulas = JSON.parse(response);
                            aulas.forEach(function(aula) {
                                $('#aula').append('<option value="' + aula.id + '">' + aula.nombre + '</option>');
                            });
                        },
                        error: function() {
                            alert('Error al cargar las aulas');
                        }
                    });
                } else {
                    $('#aula').html('<option value="">Seleccione un aula</option>');
                }
            });
        });
        // Función para cargar las aulas dinámicamente cuando se abre el modal
        $(document).ready(function() {
            // Cargar las aulas con su sheetGoogleID cuando se abre el modal
            $('#miModal').on('show.bs.modal', function() {
                $.ajax({
                    url: '/asistencia/cargarAulasConSheets', // Cambia a la ruta correcta
                    type: 'GET',
                    success: function(response) {
                        // Limpiar la tabla antes de agregar nuevos datos
                        $('#tablaAulas tbody').empty();

                        // Parsear la respuesta JSON
                        const aulas = JSON.parse(response);

                        // Recorrer los datos de las aulas y agregar filas a la tabla
                        aulas.forEach(function(aula) {
                            const fila = `<tr>
                                    <td>${aula.aula_nombre}</td>
                                    <td><a href="https://docs.google.com/spreadsheets/d/${aula.googleSheetID}" target="_blank">Abrir hoja</a></td>
                                  </tr>`;
                            $('#tablaAulas tbody').append(fila);
                        });
                    },
                    error: function() {
                        alert('Error al cargar las aulas');
                    }
                });
            });
        });
    </script>
    <script>
        // Función para extraer el ID del Google Sheet del URL ingresado
        function extraerGoogleSheetID(input) {
            // Obtener el valor del input (URL)
            const url = input.value.trim();

            // Expresión regular para extraer el ID del Google Sheet
            const regex = /\/d\/([a-zA-Z0-9_-]+)\//;
            const match = url.match(regex);

            if (match && match[1]) {
                // Si hay una coincidencia, asignar el ID al campo oculto
                document.getElementById('googleSheetID').value = match[1];
            } else {
                // Si no hay coincidencia, limpiar el campo oculto
                document.getElementById('googleSheetID').value = '';
            }
        }
    </script>
</div>