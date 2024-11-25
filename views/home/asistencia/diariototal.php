<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">

                <!-- Breadcrumb -->
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Asistencia</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Diario Total</a></li>
                    </ol>
                </div>

                <!-- Filtro y Tabla -->
                <div class="filter cm-content-box box-primary">
                    <div class="cm-content-body form excerpt">
                        <div class="card-body">

                            <!-- Filtros -->
                            <div class="row">
                                <!-- Fecha -->
                                <div class="col-xl-3 col-xxl-6 col-md-6 mb-3">
                                    <label class="form-label">Fecha</label>
                                    <input type="date" id="fecha" name="fecha" class="form-control me-2" required placeholder="Fecha">
                                </div>

                                <!-- Nivel -->
                                <div class="col-xl-3 col-sm-6 mb-3 mb-sm-0">
                                    <label class="form-label">Nivel</label>
                                    <select id="nivelSelect" name="nivel" class="form-control">
                                        <option value="">Seleccione un nivel</option>
                                    </select>
                                </div>

                                <div class="col-xl-3 col-sm-6 mb-3 mb-sm-0 d-flex align-items-center justify-content-center">
                                    <label class="form-label"></label>
                                    <button id="buscarAsistencia" type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">Buscar</button>
                                </div>




                            </div>

                            <!-- Tabla de Resultados -->
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example3" class="display" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th>Grado</th>
                                                        <th>Aula</th>
                                                        <th>N° Asistencias</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="aulasTableBody">
                                                    <tr>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    </tr>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function() {
        function cargarNiveles() {
            $.ajax({
                url: '/asistencia/cargar-nivel', // Ruta para cargar los niveles
                type: 'POST',
                success: function(response) {
                    if (response.success) {
                        const selectNiveles = $('#nivelSelect');
                        selectNiveles.empty();
                        selectNiveles.append('<option value="">Seleccione un nivel</option>');
                        response.data.forEach(nivel => {
                            selectNiveles.append(
                                `<option value="${nivel.id}">${nivel.descripcion} (${nivel.abreviatura})</option>`
                            );
                        });
                    } else {
                        console.error("Error al cargar niveles:", response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                }
            });
        }

        function buscarAsistencias() {
            const fecha = $('#fecha').val();
            const nivel = $('#nivelSelect').val();

            // Log inicial con los datos enviados
            console.log("Datos enviados: Fecha -", fecha, "Nivel -", nivel);

            if (!fecha || !nivel) {
                console.warn("Faltan datos: Fecha o Nivel no seleccionados.");
                alert('Por favor, selecciona una fecha y un nivel.');
                return;
            }

            $.ajax({
                url: '/asistencia/buscarPorDia',
                type: 'POST',
                data: {
                    fecha,
                    nivel
                },
                success: function(response) {
                    console.log("Respuesta recibida del servidor:", response);

                    // Intentar parsear la respuesta si no es un objeto
                    if (typeof response !== 'object') {
                        try {
                            response = JSON.parse(response);
                            console.log("Respuesta parseada:", response);
                        } catch (error) {
                            console.error("Error al parsear la respuesta:", error);
                            alert("Ocurrió un error al procesar la respuesta del servidor.");
                            return;
                        }
                    }

                    const tbody = $('#aulasTableBody');
                    console.log('TBody seleccionado:', tbody);

                    tbody.empty();

                    if (response.success && response.data.length > 0) {
                        response.data.forEach((asistencia, index) => {
                            console.log(`Procesando fila ${index + 1}:`, asistencia);
                            tbody.append(`
                        <tr>
                            <td>${asistencia.grado || 'N/A'}</td>
                            <td>${asistencia.aula || 'N/A'}</td>
                            <td>${asistencia.NumeroDeAsistencias || 0}</td>
                        </tr>
                    `);
                        });

                        console.log('HTML final del tbody:', tbody.html());
                    } else {
                        console.warn("No se encontraron datos:", response.message || 'Respuesta vacía.');
                        tbody.append(`
                    <tr>
                        <td colspan="3">${response.message || 'No hay datos disponibles.'}</td>
                    </tr>
                `);
                    }
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud AJAX:", status, error);
                    console.error("Detalles del error:", xhr.responseText);
                    alert("Ocurrió un error al consultar las asistencias.");
                }
            });
        }
        cargarNiveles();

        $('#buscarAsistencia').on('click', buscarAsistencias);
    });
</script>