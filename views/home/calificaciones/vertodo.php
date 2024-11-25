<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
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
                            <!-- Botón que dispara el modal -->
                            <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg">
                                <span class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i></span>Agregar
                            </button>

                            <!-- Modal -->
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Ingrese link del excel</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form class="needs-validation" novalidate method="POST" action="/">
                                            <div class="modal-body">
                                                <div class="form-validation">
                                                    <!-- primero -->
                                                    <div class="row">
                                                        <!-- Selector de Aula -->
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="aulaSelect">Bimestre</label>
                                                                <select id="aulaSelect" class="form-select" name="bimestre[idaula]" aria-label="Seleccionar el bimestre">
                                                                    <option value="">Todo</option>

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <!-- Selector de Curso -->
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="cursoSelect">Profesor</label>
                                                                <select id="cursoSelect" class="form-select" name="profesor[idprofesor]" aria-label="Seleccionar profesor" disabled>
                                                                    <option value="">Todo</option>
                                                                </select>
                                                            </div>
                                                        </div>


                                                    </div>
                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="cursoSelect">Aula</label>
                                                                <select id="cursoSelect" class="form-select" name="aula[idaula]" aria-label="Seleccionar aula" disabled>
                                                                    <option value="">Todo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="cursoSelect">Curso</label>
                                                                <select id="cursoSelect" class="form-select" name="aula[idaula]" aria-label="Seleccionar aula" disabled>
                                                                    <option value="">Todo</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="url">URL</label>
                                                                <input type="text" class="form-control" id="url" name="videoconferencia[url]" placeholder="URL de la videoconferencia" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xl-6">
                                                            <div class="mb-3">
                                                                <label for="descripcion">Descripción</label>
                                                                <textarea class="form-control" id="descripcion" name="videoconferencia[descripcion]" placeholder="Descripción de la videoconferencia" required></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- <input type="hidden" name="videoconferencia[idprofesor]" value="
                                                    <?php
                                                    // echo $_SESSION['id_profesor']; 
                                                    ?>"> -->
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
                                                    <th>Profesor</th>
                                                    <th>Bimestre</th>
                                                    
                                                    <th>Aula</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td><img class="rounded-circle" width="35" src="assets/images/profile/small/pic1.jpg" alt=""></td>
                                                    <td>1</td>

                                                    <td><a href="javascript:void(0);"><strong>enrique luis german alarcon tapia</strong></a></td>
                                                    <td>
                                                        <select>
                                                            <option value="Bimestre 1">Bimestre 1</option>
                                                            <option value="Bimestre 2">Bimestre 2</option>
                                                            <option value="Bimestre 3">Bimestre 3</option>
                                                            <option value="Bimestre 4">Bimestre 4</option>
                                                        </select>
                                                    </td>

                                                    

                                                    <!-- Botón para Excel -->
                                                    <td>
                                                        <button class="btn btn-success" onclick="window.location.href='ruta_a_pagina_excel.html'">
                                                            Ver Aula
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex">
                                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                            <a href="#" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                                        </div>
                                                    </td>
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
