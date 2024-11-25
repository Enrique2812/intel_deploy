<div class="content-body">
    <div class="container-fluid">

        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gestion</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Cursos</a></li>
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
            <div class="col-12">
                <div class="card">

                    <div class="card-body text-start">

                        <!-- Botón que dispara el modal -->
                        <a href="/crear/aula" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target=".bd-example-modal-lg"><span
                                class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                            </span>Agregar</a>


                        <!-- Modal -->
                        <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Ingrese Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                                        </button>
                                    </div>
                                    <form class="needs-validation" novalidate method="POST" action="/crear/cursos">
                                        <div class="modal-body">

                                            <div class="form-validation">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="mb-3 row">
                                                            <label class="col-lg-4 col-form-label" for="validationCustom01">Curso
                                                                <span class="text-danger">*</span>
                                                            </label>
                                                            <div class="col-lg-6">
                                                                <input value="<?php echo $curso->descripcion ?>" type="text" class="form-control" id="validationCustom01" name="curso[descripcion]" placeholder="Introduzca el curso." required>

                                                            </div>
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
                    </div>



                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example3" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>

                                    </tr>
                                </thead>

                                <body>
                                <?php
                                foreach ($cursos as $curso):
                                ?>
                                    <tr>
                                        <td><img class="rounded-circle" width="35" src="/assets/images/profile/small/pic1.jpg" alt=""></td>
                                        <td><?php echo $curso->descripcion ?></td>
                                        <td>
                                            <div class="d-flex">
                                            <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $curso->id; ?>"><i class="fas fa-pencil-alt"></i></a>
                                            <a href="/eliminar/cursos?id=<?php echo $curso->id ?>" class="btn btn-danger shadow btn-xs sharp"><i class="fa fa-trash"></i></a>
                                            </div>
                                        </td>

                                        <!-- Modal -->
                                        <div class="modal fade bd-example-modal-lg edit" id="editModal-<?php echo $curso->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Editar</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                                </button>
                                                            </div>
                                                            <form class="needs-validation" novalidate method="POST" action="/editar/cursos">
                                                                <div class="modal-body">

                                                                    <div class="form-validation">
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="mb-3 row">
                                                                                    <label class="col-lg-4 col-form-label" for="validationCustom01">Descripcion
                                                                                        <span class="text-danger">*</span>
                                                                                    </label>
                                                                                    <div class="col-lg-6">
                                                                                        <input value="<?php echo $curso->descripcion ?>" type="text" class="form-control" id="validationCustom01" name="curso[descripcion]" placeholder="Introduzca un nombre de usuario.." required>
                                                                                        <input type="hidden" id="curso[id]" value="<?php echo $curso->id ?>" type="text" class="form-control" id="validationCustom01" name="curso[id]" placeholder="Introduzca un nombre de usuario.." required>

                                                                                    </div>
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
                                    <?php
                                    endforeach;
                                    ?>
                                </body>

                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>