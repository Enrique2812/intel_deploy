<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Asistencia</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Alumno</a></li>
                    </ol>
                </div>
                <div class="filter cm-content-box box-primary">

                    <div class="cm-content-body  form excerpt">
                        <div class="card-body">
                            <div class="row">

                                <form id="form-buscar-asistencia">
                                    <div class="row">

                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <input type="date" id="fechaIni" name="fechaInicio" class="form-control" required>
                                        </div>
                                        <div class="col-xl-3 col-sm-6 mb-3">
                                            <input type="date" id="fechaFin" name="fechaFin" class="form-control" required>
                                        </div>


                                        <!-- Botón Buscar -->
                                        <div class="col-xl-3 col-sm-6 mb-3 mb-sm-0">
                                            <button type="button" onclick="buscarGeneral()" class="btn btn-primary w-100">Buscar</button>
                                        </div>
                                    </div>
                                </form>
                               
                            </div>

                            <div class="col-12">
                                <div class="card">

                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="example3" class="display" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Fecha</th>
                                                        <th>Hora Ingreso</th>
                                                        <th>Tardanza</th>
                                                        <th>Hora Salida</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="tablaAsistencia">
                                                    <!-- Aquí se cargarán las filas con los datos desde la respuesta AJAX -->
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
    function buscarGeneral() {
    const fechaInicio = document.getElementById('fechaIni').value;
    const fechaFin = document.getElementById('fechaFin').value;

    // Validación de campos
    if (!fechaInicio || !fechaFin) {
        alert('Por favor, complete las fechas para realizar la búsqueda.');
        return;
    }

    // Datos para la búsqueda
    const datosBusqueda = { fechaInicio, fechaFin };

    // Envío de datos mediante AJAX
    $.ajax({
        url: '/asistencia/buscarPorCorreoYRangoFechas',
        type: 'POST',
        data: datosBusqueda,
        success: function(response) {
            try {
                // Limpiar el contenido actual
                const tbody = document.querySelector('#tablaAsistencia');
                tbody.innerHTML = '';

                // Agregar la respuesta completa al cuerpo de la tabla
                tbody.innerHTML = response;

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

<pre>
<?php
var_dump($_SESSION);
?>
</pre>