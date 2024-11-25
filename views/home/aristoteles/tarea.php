<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Aristóteles</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Aula</a></li>
            </ol>
        </div>
        <!-- row -->
        <?php
        foreach ($errores as $error) : ?>
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
        <!-- row -->
        <div class="row">
            <div class="col-xl-12 ">
                <div class="card">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row ">
                                <div class="col-xl-4 col-sm-4 mb-3 mb-sm-0">
                                    <select name="id_aula" class="nice-select form-control default-select dashboard-select-2 h-auto wide" required>
                                        <option value="" disabled selected>Selecciona una Aula</option>
                                        <?php $aulasMostradas = []; ?>
                                        <?php foreach ($aulasPermitidas as $aulaP) : ?>
                                            <?php foreach ($aulas as $aula) : ?>
                                                <?php if (!in_array($aulaP->id_aula, $aulasMostradas)): ?>
                                                    <?php if ($aula->id === $aulaP->id_aula): ?>
                                                        <?php $aulasMostradas[] = $aulaP->id_aula;  ?>
                                                        <?php if ($aula->id === $id_aula): ?>
                                                            <option value="<?php echo $aula->id; ?>" selected><?php echo $aula->nombre; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $aula->id; ?>"><?php echo $aula->nombre; ?></option>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-xl-4 col-sm-4 mb-3 mb-sm-0">
                                    <select name="id_curso" class="nice-select form-control default-select dashboard-select-2 h-auto wide" required>
                                        <option value="" disabled selected>Selecciona un Curso</option>
                                        <?php $cursosMostradas = []; ?>
                                        <?php foreach ($aulasPermitidas as $cursoP) : ?>
                                            <?php foreach ($cursos as $curso) : ?>
                                                <?php if (!in_array($cursoP->id_curso, $cursosMostradas)): ?>
                                                    <?php if ($cursoP->id_curso === $curso->id): ?>
                                                        <?php $cursosMostradas[] = $cursoP->id_curso;  ?>
                                                        <?php if ($curso->id === $id_curso): ?>
                                                            <option value="<?php echo $curso->id; ?>" selected><?php echo $curso->descripcion; ?></option>
                                                        <?php else: ?>
                                                            <option value="<?php echo $curso->id; ?>"><?php echo $curso->descripcion; ?></option>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-xl-4 col-sm-4 mb-3 mb-sm-0 d-flex justify-content-evenly">
                                    <button name="buscar" type="submit" class="btn btn-primary">Seleccionar <span
                                            class="btn-icon-end"><i class="fa-solid fa-magnifying-glass"></i></span>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php if ($brusquedad): ?>
            <div class="row">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <input class="form-control" value="<?php echo $id_curso ?>" name="id_curso" type="hidden" id="formFile2">
                                    <input class="form-control" value="<?php echo $id_aula ?>" name="id_aula" type="hidden" id="formFile2">
                                    <input class="form-control" value="<?php echo null ?>" name="id_tarea" type="hidden" id="formFile2">

                                    <div class="col-xl-6 col-sm-6 mb-4">
                                        <label for="formFile1" class="form-label">Temas</label>
                                        <input type="text" name="titulo" class="form-control">
                                    </div>

                                    <div class="col-xl-6 col-sm-6 mb-4">
                                        <label for="formFile1" class="form-label">Imagen</label>
                                        <input class="form-control" type="file" id="formFile2" name="imagen" accept="image/png , image/jpeg">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile1" class="form-label">Teoría</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_teoria">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile2" class="form-label">Práctica</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_practica" id="formFile2">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile3" class="form-label">Problemas Resueltos</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_problemas_resueltos" id="formFile3">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile4" class="form-label">Esquemas</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_esquemas" id="formFile4">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile5" class="form-label">Linea de Tiempo</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_tiempo" id="formFile5">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile6" class="form-label">Lectura</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_lectura" id="formFile6">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile7" class="form-label">Retroalimentación</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_retroalimentacion" id="formFile7">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile8" class="form-label">Material de apoyo</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_material_apoyo" id="formFile8">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile6" class="form-label">Apéndice</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_apendice" id="formFile6">
                                    </div>

                                    <div class="col-xl-4 col-sm-6 mb-4">
                                        <label for="formFile7" class="form-label">Otros</label>
                                        <input class="form-control" type="file"  accept=".pdf"  name="pd_otros" id="formFile7">
                                    </div>

                                    <div class="col-xl-10 col-sm-6 mb-4">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">Url de video </span>
                                            <input type="text" class="form-control" name="urlVideo">
                                        </div>
                                    </div>
                                    <div class="col-xl-2 col-sm-6 mb-4">
                                        <div class="input-group mb-3">
                                            <button name="registrar" type="submit" class="btn btn-rounded btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif;  ?>

    </div>
</div>