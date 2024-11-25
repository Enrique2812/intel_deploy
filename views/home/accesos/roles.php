<?php

use Model\Pagina;
?>
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Accesos</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Roles</a></li>
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
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-body text-start">

                        <!-- Botón que dispara el modal -->
                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><span
                                class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                            </span>Agregar</button>


                        <?php
                        $paginas = [
                            (object)['id' => 1, 'nombre' => 'Usuarios', 'modulo' => 1],
                            (object)['id' => 2, 'nombre' => 'Roles', 'modulo' => 1],
                            (object)['id' => 3, 'nombre' => 'Alumnos en Aulas', 'modulo' => 2],
                            (object)['id' => 4, 'nombre' => 'Profesor en Aula', 'modulo' => 2],
                            (object)['id' => 5, 'nombre' => 'Alumnos', 'modulo' => 2],
                            (object)['id' => 6, 'nombre' => 'Aulas', 'modulo' => 2],
                            (object)['id' => 7, 'nombre' => 'Cursos', 'modulo' => 2],

                            (object)['id' => 9, 'nombre' => 'Profesores', 'modulo' => 2],

                            (object)['id' => 11, 'nombre' => 'Alumno', 'modulo' => 3],
                            (object)['id' => 12, 'nombre' => 'Profesor', 'modulo' => 3],
                            (object)['id' => 13, 'nombre' => 'Alumno', 'modulo' => 4],
                            (object)['id' => 14, 'nombre' => 'Profesor', 'modulo' => 4],
                            (object)['id' => 15, 'nombre' => 'Año Escolar', 'modulo' => 5],
                            (object)['id' => 16, 'nombre' => 'Tipo Evaluacion', 'modulo' => 5],
                            (object)['id' => 17, 'nombre' => 'Calificaciones', 'modulo' => 6],
                            (object)['id' => 18, 'nombre' => 'Ver Todo', 'modulo' => 6],
                            (object)['id' => 19, 'nombre' => 'Mis Calificaciones', 'modulo' => 6],
                            (object)['id' => 20, 'nombre' => 'horario', 'modulo' => 7],
                            (object)['id' => 21, 'nombre' => 'Registrar', 'modulo' => 7],
                            (object)['id' => 22, 'nombre' => 'General', 'modulo' => 7],
                            (object)['id' => 23, 'nombre' => 'Alumno', 'modulo' => 7],
                            (object)['id' => 24, 'nombre' => 'Calendario', 'modulo' => 7],
                            (object)['id' => 25, 'nombre' => 'Diario Total', 'modulo' => 7],
                            (object)['id' => 26, 'nombre' => 'Clases en vivo', 'modulo' => 8],
                            (object)['id' => 27, 'nombre' => 'Pagos', 'modulo' => 9],
                            (object)['id' => 28, 'nombre' => 'Contabilidad', 'modulo' => 10]
                        ];
                        ?>

                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <form class="modal-content" action="/editar/roles" method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Registro de Roles</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body" style="height: 60vh; overflow-y: auto;">
                                        <div class="mb-3">
                                            <input value="<?php echo $rol->nombre ?>" name="rol[nombre]" type="text" class="form-control input-default" placeholder="Escriba aquí">
                                        </div>

                                        <style>
                                            .list-group-item {
                                                border: 0;
                                            }
                                        </style>

                                        <h5>Accesos</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 1) : ?>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="form-check custom-checkbox checkbox-info me-2">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>





                                        <h5>Gestión</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 2) : ?>
                                                    <li class="list-group-item">
                                                        <div class="form-check custom-checkbox checkbox-info">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>


                                        <h5>Tareas</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 3) : ?>
                                                    <li class="list-group-item">
                                                        <div class="form-check custom-checkbox checkbox-info">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>


                                        <h5>Aristoteles</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 4) : ?>
                                                    <li class="list-group-item">
                                                        <div class="form-check custom-checkbox checkbox-info">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>


                                        <h5>Configuración</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 5) : ?>
                                                    <li class="list-group-item">
                                                        <div class="form-check custom-checkbox checkbox-info">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>


                                        <h5>Clasificación</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 6) : ?>
                                                    <li class="list-group-item">
                                                        <div class="form-check custom-checkbox checkbox-info">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>


                                        <h5>Asistencia</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 7) : ?>
                                                    <li class="list-group-item">
                                                        <div class="form-check custom-checkbox checkbox-info">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>


                                        <h5>Clases en Vivo</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 8) : ?>
                                                    <li class="list-group-item">
                                                        <div class="form-check custom-checkbox checkbox-info">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>


                                        <h5>Pagos</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 9) : ?>
                                                    <li class="list-group-item">
                                                        <div class="form-check custom-checkbox checkbox-info">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>


                                        <h5>Contabilidad</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 10) : ?>
                                                    <li class="list-group-item">
                                                        <div class="form-check custom-checkbox checkbox-info">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>">
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>


                                    </div>

                                    <div class="modal-footer d-flex justify-content-between">
                                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Registrar</button>
                                    </div>
                                </form>
                            </div>
                        </div>




                        <div class="card-header">
                            <h4 class="card-title">Lista de Roles</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="example3" class="display" style="min-width: 845px">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th class="small-column">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <style>
                                        .small-column {
                                            width: 50px;
                                            /* Ajusta el valor del ancho según lo que necesites */
                                            text-align: center;
                                            /* Opcional: centra el contenido */
                                        }
                                    </style>

                                    <tbody>
                                        <!--mostrar los resultados -->
                                        <?php foreach ($roles as $rol): ?>
                                            <tr>
                                                <td><img class="rounded-circle" width="35" src="/assets/images/profile/small/pic1.jpg" alt=""></td>
                                                <td><?php echo $rol->nombre ?></td>
                                                <td><?php echo "descripción" ?></td>
                                                <td>
                                                    <div class="d-flex">
                                                        <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $rol->id; ?>"><i class="fas fa-pencil-alt"></i></a>
                                                        <a href="#" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo $rol->id; ?>">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    </div>
                                                </td>

                                                <!-- Modal de Confirmación de Eliminación -->
                                                <div class="modal fade bd-example-modal-lg delete" id="deleteModal-<?php echo $rol->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <!-- Contenido del modal -->
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Confirmar Eliminación</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <p>¿Estás seguro de que deseas eliminar al alumno <strong><?php echo $rol->nombre; ?></strong>?</p>
                                                            </div>
                                                            <div class="modal-footer d-flex justify-content-between">
                                                                <!-- Botón para cerrar el modal sin eliminar -->
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <!-- Botón para confirmar la eliminación -->
                                                                <a href="/eliminar/roles?id=<?php echo $rol->id ?>" class="btn btn-danger">Eliminar</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <!-- Modal -->
<div class="modal fade bd-example-modal-lg edit" id="editModal-<?php echo $rol->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form class="modal-content" action="/editar/roles" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Editar Rol - <?php echo $rol->nombre; ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <input value="<?php echo $rol->id ?>" name="rol[id]" type="hidden" class="form-control input-default" placeholder="Nombre del rol">
                        <input value="<?php echo $rol->nombre ?>" name="rol[nombre]" type="text" class="form-control input-default" placeholder="Nombre del rol">
                    </div>
                    <div class="col-lg-12">
                        <div class="card border-0 pb-0">
                            <div class="card-body p-0">
                                <div id="DZ_W_Todo4" class="widget-media dlab-scroll px-4 my-4" style="height:370px;">
                                    <ul class="timeline">
                                        <?php
                                        // Obtener las páginas asignadas para este rol
                                        $paginasAsignadas = Pagina::obtenerPaginasPorRol($rol->id);

                                        // Crear un array con los IDs de las páginas asignadas
                                        $paginasAsignadasIds = array_map(function ($pagina) {
                                            return $pagina->id;
                                        }, $paginasAsignadas);
                                        ?>

                                        <h5>Accesos</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 1) : ?>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="form-check custom-checkbox checkbox-info me-2">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>

                                        <h5>Gestión</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 2) : ?>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="form-check custom-checkbox checkbox-info me-2">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>

                                        <h5>Tareas</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 3) : ?>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="form-check custom-checkbox checkbox-info me-2">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>

                                        <h5>Aristoteles</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 4) : ?>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="form-check custom-checkbox checkbox-info me-2">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>

                                        <h5>Configuración</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 5) : ?>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="form-check custom-checkbox checkbox-info me-2">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>

                                        <h5>Calificaciones</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 6) : ?>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="form-check custom-checkbox checkbox-info me-2">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>

                                        <h5>Asistencia</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 7) : ?>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="form-check custom-checkbox checkbox-info me-2">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </ul>

                                        <h5>Clases en vivo</h5>
                                        <ul class="list-group list-group-flush mb-3">
                                            <?php foreach ($paginas as $pagina) : ?>
                                                <?php if ($pagina->modulo == 8) : ?>
                                                    <li class="list-group-item d-flex align-items-center">
                                                        <div class="form-check custom-checkbox checkbox-info me-2">
                                                            <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                            <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                        </div>
                                                    </li>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                                </ul>
            
                                                <h5>Pagos</h5>
                                                <ul class="list-group list-group-flush mb-3">
                                                    <?php foreach ($paginas as $pagina) : ?>
                                                        <?php if ($pagina->modulo == 9) : ?>
                                                            <li class="list-group-item d-flex align-items-center">
                                                                <div class="form-check custom-checkbox checkbox-info me-2">
                                                                    <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                                    <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                                </div>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
            
                                                <h5>Contabilidad</h5>
                                                <ul class="list-group list-group-flush mb-3">
                                                    <?php foreach ($paginas as $pagina) : ?>
                                                        <?php if ($pagina->modulo == 10) : ?>
                                                            <li class="list-group-item d-flex align-items-center">
                                                                <div class="form-check custom-checkbox checkbox-info me-2">
                                                                    <input type="checkbox" value="<?php echo $pagina->id; ?>" name="paginas[]" class="form-check-input" id="customCheckBox<?php echo $pagina->id; ?>" <?php echo in_array($pagina->id, $paginasAsignadasIds) ? 'checked' : ''; ?>>
                                                                    <label class="form-check-label" for="customCheckBox<?php echo $pagina->id; ?>"><?php echo $pagina->nombre; ?></label>
                                                                </div>
                                                            </li>
                                                        <?php endif; ?>
                                                    <?php endforeach; ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
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
                                        <?php endforeach; ?>

                                        </body>

                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>