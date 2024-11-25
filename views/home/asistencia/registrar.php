<div class="content-body">
    <div class="container-fluid">
        <!-- Breadcrumb -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Aristoteles</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Alumno</a></li>
                    </ol>
                </div>
           

       
                <div class="filter cm-content-box box-primary">
                    <div class="cm-content-body form excerpt">
                        <div class="card-body">

                            

                            <!-- ComboBox de Aulas -->
                            <div class="row">
                                <div class="col-lg-6">
                                    <form method="GET" action="">
                                        <label for="aulaSelect">Selecciona un Aula:</label>
                                        <select id="aulaSelect" name="aula_id" class="nice-select form-control default-select dashboard-select-2 h-auto wide" onchange="cargarAlumnos(this.value)">
                                            <option value="todos" selected>Todos</option>
                                            <?php foreach ($aulas as $aula): ?>
                                                <option value="<?= htmlspecialchars($aula->id) ?>">
                                                    <?= htmlspecialchars($aula->nombre) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </div>
                            </div>
                            

                            <!-- Filtros de Ingreso y Salida -->
                            <div class="row mt-4">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <input type="text" id="dniInput" placeholder="DNI Estudiante" class="form-control" style="width: 200px;" required>
                                                <label>
                                                    <input type="checkbox" id="ingresoCheckbox"> Ingreso
                                                </label>
                                                <label class="ms-3">
                                                    <input type="checkbox" id="salidaCheckbox"> Salida
                                                </label>
                                                <button type="button" onclick="registrarAsistencia()" class="btn btn-primary">Registrar Asistencia</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="table-responsive mt-4">
                                <table id="example3" class="table table-striped">
                                    <thead>
                                        <tr>
                                        <th>DNI</th>
                                                        <th>Alumno (Nombre y Apellido)</th>
                                                        <th>Fecha</th>
                                                        <th>Ingreso</th>
                                                        <th>Tardanza</th>
                                                        <th>Salida</th>
                                        </tr>
                                    </thead>
                                    <tbody id="alumnosTableBody">
                                        <!-- Contenido dinámico -->
                                    </tbody>
                                </table>
                            </div>

                            

                            <!-- Tabla de Alumnos -->

                            


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
        $('#cambiarEstadoBtn').on('click', function(e) {
            e.preventDefault();

            let $btn = $(this);
            let currentState = $btn.data('estado');
            let newState = currentState === 'Sí' ? 'No' : 'Sí';

            console.log('Nuevo estado enviado:', newState); // Debugging line

            $btn.text('Cambiando estado a ' + newState).prop('disabled', true);

            $.ajax({
                url: '/asistencia/cambiarEstado',
                method: 'POST',
                data: {
                    nuevoEstado: newState
                },
                success: function(response) {
                    console.log('Respuesta del servidor:', response); // Debugging line
                    $btn.data('estado', newState).text('Cambiar estado a ' + (newState === 'Sí' ? 'No' : 'Sí'));
                },
                error: function() {
                    alert('Hubo un error al cambiar el estado.');
                },
                complete: function() {
                    $btn.prop('disabled', false);
                }
            });
        });
    });


    function cargarAlumnos(aulaId) {
        if (!aulaId) {
            $('#alumnosTableBody').html('<tr><td>Selecciona un aula para ver los alumnos asignados.</td></tr>');
            return;
        }

        $.ajax({
            url: '/asistencia/cargarAlumnos',
            method: 'GET',
            data: {
                aula_id: aulaId
            },
            success: function(response) {
                const alumnos = JSON.parse(response);
                $('#alumnosTableBody').empty();

                if (alumnos.length > 0) {
                    alumnos.forEach(function(alumno) {
                        const horaIngreso = alumno.hora_ingreso ? alumno.hora_ingreso.slice(0, 8) : '';
                        const horaSalida = alumno.hora_salida ? alumno.hora_salida.slice(0, 8) : '';
                        const Tardanza = alumno.tardanza ? alumno.tardanza.slice(0, 8) : '';

                        const row = `<tr>
                        <td>${alumno.dni}</td>
                        <td>${alumno.nombre}</td>
                        <td>${alumno.fecha}</td>
                        <td>${horaIngreso}</td>
                        <td>${Tardanza} min</td>
                        <td>${horaSalida}</td>
                    </tr>`;
                        $('#alumnosTableBody').append(row);
                    });
                } else {
                    $('#alumnosTableBody').html('<tr><td>No hay alumnos asignados a esta aula.</td></tr>');
                }
            },
            error: function() {
                alert('Hubo un error al cargar la información de los alumnos.');
            }
        });
    }

    $(document).ready(function() {
        cargarAlumnos("todos");
    });
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function registrarAsistencia() {
        let dni = $('#dniInput').val();
        let ingreso = $('#ingresoCheckbox').is(':checked');
        let salida = $('#salidaCheckbox').is(':checked');

        if (!dni) {
            return;
        }

        if (!ingreso && !salida) {
            return;
        }

        let url = '';
        if (ingreso) {
            url = '/asistencia/registrar-ingreso';
        } else if (salida) {
            url = '/asistencia/registrar-salida';
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                dni: dni
            },
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    let aulaId = $('#aulaSelect').val(); // Obtiene el ID del aula seleccionada
                    cargarAlumnos(aulaId);
                }
            },
            error: function() {}
        });
    }
</script>