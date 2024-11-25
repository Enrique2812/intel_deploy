<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Aristóteles</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Alumno</a></li>
            </ol>
        </div>

        <div class="filter cm-content-box box-primary">
            <div class="cm-content-body  form excerpt">
                <div class="card-body">
                    <div class="row">

                        <div class="col-xl-12 col-sm-6 mb-3 mb-sm-0">
                            <div class="text-end">
                                <?php if ($aristoteles->id_tarea ) : ?>

                                    <a href="/Tareas/contenido?id=<?php echo $aristoteles->id_tarea ?>&A=<?php echo 2?>" class="btn btn-primary"><span
                                            class="nav-text">
                                            <i class="fa-solid fa-book me-2"></i>
                                        </span>Ver Tarea</button>

                                    </a>
                                <?php endif; ?>
                                <?php if (!$aristoteles->id_tarea && $_SESSION['rol'] === '5') : ?>

                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><span
                                            class="nav-text">
                                            <i class="fa-solid fa-book me-2"></i>
                                        </span>Crear Tarea</button>

                                    <!-- Modal -->
                                    <div class="modal fade text-start" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Tarea</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <form action="/aristoteles/crearTarea" method="POST" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="form-validation">
                                                            <div class="row ">
                                                                <div class="row">
                                                                    <input value="<?php echo $_SESSION['id_profesor'] ?>" type="hidden" class="form-control input-default" id="titulo" name="tarea[id_profesor]" placeholder="Escribe el título">
                                                                    <!-- Primera columna del formulario -->
                                                                    <div class="col-md-6">
                                                                        <!-- Campos de título y descripción -->
                                                                        <input class="form-control" value="<?php echo $aristoteles->id ?>" name="id_aristoteles" type="hidden" id="formFile2">
                                                                        <input class="form-control" value="<?php echo $aristoteles->id_curso ?>" name="tarea[id_curso]" type="hidden" id="formFile2">
                                                                        <input class="form-control" value="<?php echo $aristoteles->id_aula ?>" name="tarea[id_aula]" type="hidden" id="formFile2">
                                                                        <div class="mb-3">
                                                                            <label for="titulo">Título:</label>
                                                                            <input type="text" class="form-control input-default" id="titulo" name="tarea[titulo]" placeholder="Escribe el título" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="descripcion">Descripción:</label>
                                                                            <textarea class="form-control input-default" id="descripcion" name="tarea[descripcion]" rows="10" placeholder="Escribe la descripción" required></textarea>
                                                                        </div>
                                                                    </div>
                                                                    <!-- Segunda columna del formulario -->
                                                                    <div class="col-md-6">
                                                                        <div class="mb-3">
                                                                            <p class="mb-1">Fecha de inicio:</p>
                                                                            <!-- <input  class="datepicker-default form-control" id="datepicker" name="tarea[fechaInicio]"> -->
                                                                            <!-- <label for="fechaInicio">Fecha de inicio:</label> -->
                                                                            <input type="date" class="form-control " name="tarea[fecha_inicio]" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <p class="mb-1">Fecha de fin:</p>
                                                                            <!-- <input  class="datepicker-default form-control" id="datepicker" name="tarea[fechaFin]"> -->
                                                                            <!-- <label for="fechaFin">Fecha de fin:</label> -->
                                                                            <input type="date" class="form-control " name="tarea[fecha_fin]" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="tarea">Tarea:</label>
                                                                            <input type="file" class="form-control input-default" id="tarea" name="tarea[archivo]" required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="tarea">Tipo de evaluación:</label>
                                                                            <select id="sexo" name="tarea[tipo_evaluacion]" class="nice-select form-control default-select dashboard-select-2 h-auto wide" required>
                                                                                <option value="" disabled selected>Seleccione...</option>
                                                                                <?php foreach ($tipos_evaluacion as $tipos) : ?>
                                                                                    <option value="<?php echo $tipos->id ?>"><?php echo $tipos->nombre ?></option>
                                                                                <?php endforeach; ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Botón de submit -->
                                                                <div class="submit-btn-container text-end mt-4">
                                                                    <button type="submit" class="btn btn-primary">Subir</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($aristoteles->urlVideo) : ?>
                                    <a href="/aristoteles/video?id=<?php echo $aristoteles->id ?>" class="btn btn-primary d-inline-flex align-items-center">
                                        <i class="fa-solid fa-play me-2"></i>
                                        <span class="nav-text"> Video</span> <!-- El texto -->
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 ">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <?php if ($aristoteles->pd_teoria) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="teoria" href="../archivos/<?php echo $aristoteles->pd_teoria  ?>">
                                        <div class="card">
                                            <!-- ruta para imagen /assets/images/profile/.. -->
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/teoria.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Teoría</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($aristoteles->pd_practica) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="practica" href="../archivos/<?php echo $aristoteles->pd_practica  ?>">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/practica2.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Práctica</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($aristoteles->pd_problemas_resueltos) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="resueltos" href="../archivos/<?php echo $aristoteles->pd_problemas_resueltos  ?>">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/ejercicios_resueltos.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Problemas Resueltos</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($aristoteles->pd_esquemas) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="esquemas" href="../archivos/<?php echo $aristoteles->pd_esquemas  ?>">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/esquema.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Esquemas</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($aristoteles->pd_tiempo) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="tiempo" href="../archivos/<?php echo $aristoteles->pd_tiempo  ?>">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/liena_de_tiempo.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Linea de Tiempo</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($aristoteles->pd_lectura) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="lectura" href="../archivos/<?php echo $aristoteles->pd_lectura  ?>">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/lectura.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Lectura</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($aristoteles->pd_retroalimentacion) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="retroalimentacion" href="../archivos/<?php echo $aristoteles->pd_retroalimentacion  ?>">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/retroalimentación.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Retroalimentación</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($aristoteles->pd_material_apoyo) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="material_apoyo" href="../archivos/<?php echo $aristoteles->pd_material_apoyo  ?>">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/repaso.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Material de apoyo</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($aristoteles->pd_apendice) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="apendice" href="../archivos/<?php echo $aristoteles->pd_apendice  ?>">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/apendice.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Apéndice</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php if ($aristoteles->pd_otros) : ?>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                                    <a download="otros" href="../archivos/<?php echo $aristoteles->pd_otros  ?>">
                                        <div class="card">
                                            <img class="card-img-top img-fluid" src="/assets/images/profile/otros.png" alt="Card image cap">
                                            <div class="card-header">
                                                <h5 class="card-title">Otros</h5>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>