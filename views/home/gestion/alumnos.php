<div class="content-body">
    <div class="container-fluid">

        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Gestion</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0)">Alumnos</a></li>
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

                        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter"><span
                                class="btn-icon-start text-info"><i class="fa fa-plus color-info"></i>
                            </span>Agregar</button>

                        <!-- Botón que dispara el modal -->


                        <!-- Modal -->
                        <div class="modal fade text-start" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalCenterTitle">Agregar Alumno</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form class="needs-validation" novalidate method="POST" action="/crear/alumnos">
                                        <div class="modal-body">
                                            <div class="form-validation">
                                                <div class="row">
                                                    <div class="col-xl-6">

                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="dni">DNI <span class="text-danger">*</span></label>
                                                            <input value="<?php echo $usuario->dni ?>" type="number" class="form-control" id="dni" name="usuario[dni]" placeholder="Introduzca el DNI" maxlength="8" pattern="\d{8}" required>
                                                            <div class="invalid-feedback">
                                                                El DNI debe contener exactamente 8 caracteres.
                                                            </div>
                                                        </div>

                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', (event) => {
                                                                const dniInput = document.getElementById('dni');
                                                                const form = dniInput.closest('form');

                                                                dniInput.addEventListener('input', () => {
                                                                    if (dniInput.value.length > 8) {
                                                                        dniInput.value = dniInput.value.slice(0, 8); // Trunca el valor a 8 caracteres
                                                                    }
                                                                });

                                                                form.addEventListener('submit', (e) => {
                                                                    if (dniInput.value.length !== 8) {
                                                                        dniInput.setCustomValidity('El DNI debe contener  8 numeros.');
                                                                        dniInput.classList.add('is-invalid');
                                                                        e.preventDefault();
                                                                    } else {
                                                                        dniInput.setCustomValidity('');
                                                                        dniInput.classList.remove('is-invalid');
                                                                    }
                                                                });
                                                            });
                                                        </script>
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="nombre">Nombres <span class="text-danger">*</span></label>
                                                            <input value="<?php echo $usuario->nombre ?>" type="text" class="form-control" id="nombre" name="usuario[nombre]" placeholder="Introduzca un nombre de usuario.." required>
                                                            <div class="invalid-feedback">
                                                                Debes llenar el campo de nombre.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="apellidos">Apellidos <span class="text-danger">*</span></label>
                                                            <input value="<?php echo $usuario->apellidos ?>" type="text" class="form-control" id="apellidos" name="usuario[apellidos]" placeholder="Introduzca un apellido.." required>
                                                            <div class="invalid-feedback">
                                                                Debes llenar el campo de apellidos.
                                                            </div>
                                                        </div>

                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', (event) => {
                                                                const nombreInput = document.getElementById('nombre');
                                                                const apellidosInput = document.getElementById('apellidos');
                                                                const form = nombreInput.closest('form');

                                                                function validateInput(input) {
                                                                    const pattern = /^[A-Za-z\s]+$/;

                                                                    input.addEventListener('input', () => {
                                                                        input.value = input.value.replace(/[^A-Za-z\s]/g, ''); // Eliminar caracteres no permitidos
                                                                        input.classList.remove('is-invalid');
                                                                        input.setCustomValidity('');
                                                                    });

                                                                    form.addEventListener('submit', (e) => {
                                                                        if (input.value.trim() === '') {
                                                                            input.setCustomValidity(`Debes llenar el campo de ${input.name.split('[')[1].replace(']', '')}.`);
                                                                            input.classList.add('is-invalid');
                                                                            e.preventDefault();
                                                                        } else if (!pattern.test(input.value)) {
                                                                            input.setCustomValidity('Solo se permiten letras y espacios.');
                                                                            input.classList.add('is-invalid');
                                                                            e.preventDefault();
                                                                        } else {
                                                                            input.setCustomValidity('');
                                                                            input.classList.remove('is-invalid');
                                                                        }
                                                                    });
                                                                }

                                                                validateInput(nombreInput);
                                                                validateInput(apellidosInput);
                                                            });
                                                        </script>
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="telefono">Teléfono <span class="text-danger">*</span></label>
                                                            <input value="<?php echo $usuario->telefono ?>" type="text" class="form-control" id="telefono" name="usuario[telefono]" placeholder="Introduzca un número telefónico.." pattern="\d{9}" maxlength="9" minlength="9" required>
                                                            <div class="invalid-feedback">
                                                                El teléfono debe contener exactamente 9 dígitos.
                                                            </div>
                                                        </div>

                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', (event) => {
                                                                const telefonoInput = document.getElementById('telefono');
                                                                const form = telefonoInput.closest('form');

                                                                telefonoInput.addEventListener('input', () => {
                                                                    telefonoInput.value = telefonoInput.value.replace(/[^0-9]/g, ''); // Eliminar caracteres no permitidos
                                                                    telefonoInput.classList.remove('is-invalid');
                                                                    telefonoInput.setCustomValidity('');
                                                                });

                                                                form.addEventListener('submit', (e) => {
                                                                    if (telefonoInput.value.length !== 9) {
                                                                        telefonoInput.setCustomValidity('El teléfono debe contener 9 dígitos.');
                                                                        telefonoInput.classList.add('is-invalid');
                                                                        e.preventDefault();
                                                                    } else {
                                                                        telefonoInput.setCustomValidity('');
                                                                        telefonoInput.classList.remove('is-invalid');
                                                                    }
                                                                });
                                                            });
                                                        </script>


                                                    </div>
                                                    <div class="col-xl-6">
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="sexo">Sexo <span class="text-danger">*</span></label>
                                                            <div class="col-xl-12 mb-3">
                                                                <select id="sexo" name="usuario[sexo]" class="nice-select form-control default-select dashboard-select-2 h-auto wide" required>
                                                                    <option value="" disabled selected>Seleccione...</option>
                                                                    <option value="masculino">Masculino</option>
                                                                    <option value="femenino">Femenino</option>
                                                                </select>
                                                                <div class="invalid-feedback">
                                                                    Debes seleccionar una opción.
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', (event) => {
                                                                const sexoSelect = document.getElementById('sexo');
                                                                const form = sexoSelect.closest('form');

                                                                form.addEventListener('submit', (e) => {
                                                                    if (sexoSelect.value === "") {
                                                                        sexoSelect.setCustomValidity('Debes seleccionar una opción.');
                                                                        sexoSelect.classList.add('is-invalid');
                                                                        e.preventDefault();
                                                                    } else {
                                                                        sexoSelect.setCustomValidity('');
                                                                        sexoSelect.classList.remove('is-invalid');
                                                                    }
                                                                });
                                                            });
                                                        </script>

                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="email">Email <span class="text-danger">*</span></label>
                                                            <input value="<?php echo $usuario->email ?>" type="email" class="form-control" id="email" name="usuario[email]" placeholder="Introduzca un email" required>
                                                            <div class="invalid-feedback">
                                                                Debes introducir una dirección de correo válida.
                                                            </div>
                                                        </div>


                                                        <script>
                                                            document.addEventListener('DOMContentLoaded', (event) => {
                                                                const emailInput = document.getElementById('email');
                                                                const form = emailInput.closest('form');

                                                                form.addEventListener('submit', (e) => {
                                                                    if (!emailInput.validity.valid) {
                                                                        emailInput.setCustomValidity('Debes introducir una dirección de correo válida.');
                                                                        emailInput.classList.add('is-invalid');
                                                                        e.preventDefault();
                                                                    } else {
                                                                        emailInput.setCustomValidity('');
                                                                        emailInput.classList.remove('is-invalid');
                                                                    }
                                                                });

                                                                emailInput.addEventListener('input', () => {
                                                                    emailInput.setCustomValidity('');
                                                                    emailInput.classList.remove('is-invalid');
                                                                });
                                                            });
                                                        </script>

                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="email_opcional">Email Opcional</label>
                                                            <input value="<?php echo $usuario->email_opcional ?>" type="text" class="form-control" id="email_opcional" name="usuario[email_opcional]">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="email_dam">Email DAM</label>
                                                            <input value="<?php echo $usuario->email_dam ?>" type="text" class="form-control" id="email_dam" name="usuario[email_dam]">
                                                        </div>
                                                        <div class="mb-3 row">
                                                            <input value="4" type="hidden" class="form-control" id="validationCustom02" name="usuario[id_rol]" required>
                                                        </div>
                                                        <!--  <div class="mb-3">
                                                                                    <label class="col-form-label" for="tipo_usuario">Tipo de Usuario <span class="text-danger">*</span></label>
                                                                                    <select name="usuario[tipo_usuario]" class="form-select">
                                                                                        <option selected disabled>Seleccione...</option>
                                                                                        <option value="profesor">Profesor</option>
                                                                                        <option value="tutor">Tutor</option>
                                                                                    </select>
                                                                                </div> -->
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <div class="mb-3">
                                                            <label class="col-form-label" for="password">Password <span class="text-danger">*</span></label>
                                                            <div class="input-group transparent-append">
                                                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                                <input type="password" class="form-control" id="dlab-password1" name="usuario[password]" placeholder="Ingrese un contraseña" required>
                                                                <span class="input-group-text show-pass border-left-end" id="toggle-password1">
                                                                    <i class="fa fa-eye-slash"></i>
                                                                    <i class="fa fa-eye"></i>
                                                                </span>
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
                                        <th>Apellido y Nombre</th>
                                        <th>Email</th>
                                        <th>DNI</th>
                                        <th>Teléfono</th>
                                        <th>Domicilio</th>
                                        <th>Sexo</th>
                                        <th>Fecha</th>
                                        <th></th>

                                    </tr>
                                </thead>
                                <tbody><!--mostrar los resultados -->
                                    <?php
                                    $index = 0;
                                    foreach ($usuarios as $usuario):
                                    ?>
                                        <tr>
                                            <td><img class="rounded-circle" width="35" src="/assets/images/profile/small/pic1.jpg" alt=""></td>
                                            <td><?php echo $usuario->nombre . " " . $usuario->apellidos ?></td>
                                            <td><?php echo $usuario->email ?></td>
                                            <td><?php echo $usuario->dni ?></td>
                                            <td><?php echo $usuario->telefono ?></td>
                                            <td><?php echo $usuario->domicilio ?></td>
                                            <td><?php echo $usuario->sexo ?></td>
                                            <td><?php echo "2024" ?></td>
                                            <td>

                                                <div class="d-flex">
                                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1" data-bs-toggle="modal" data-bs-target="#editModal-<?php echo $usuario->id; ?>"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp" data-bs-toggle="modal" data-bs-target="#deleteModal-<?php echo $usuario->id; ?>">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                            <!-- Modal de Confirmación de Eliminación -->
                                            <div class="modal fade bd-example-modal-lg delete" id="deleteModal-<?php echo $usuario->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <!-- Contenido del modal -->
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Confirmar Eliminación</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>¿Estás seguro de que deseas eliminar al alumno <strong><?php echo $usuario->nombre; ?></strong>?</p>
                                                        </div>
                                                        <div class="modal-footer d-flex justify-content-between">
                                                            <!-- Botón para cerrar el modal sin eliminar -->
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                            <!-- Botón para confirmar la eliminación -->
                                                            <a href="/eliminar/alumnos?id=<?php echo $usuario->id ?>" class="btn btn-danger">Eliminar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Modal -->
                                            <div class="modal fade bd-example-modal-lg edit" id="editModal-<?php echo $usuario->id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Editar</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal">
                                                            </button>
                                                        </div>
                                                        <form class="needs-validation" novalidate method="POST" action="/editar/alumnos">
                                                            <div class="modal-body">
                                                                <div class="form-validation">
                                                                    <div class="row">
                                                                        <div class="col-xl-6">

                                                                            <div class="mb-3">
                                                                                <label class="col-form-label" for="dni">DNI</label>
                                                                                <input value="<?php echo $usuario->dni ?>" type="text" class="form-control" id="dni" name="usuario[dni]" placeholder="Introduzca el DNI" required>
                                                                            </div>
                                                                            <input value="<?php echo $usuario->id ?>" type="hidden" class="form-control" name="usuario[id]" placeholder="Introduzca un nombre de usuario.." required>

                                                                            <div class="mb-3">
                                                                                <label class="col-form-label" for="nombre">Nombres <span class="text-danger">*</span></label>
                                                                                <input value="<?php echo $usuario->nombre ?>" type="text" class="form-control" name="usuario[nombre]" placeholder="Introduzca un nombre de usuario.." required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="col-form-label" for="nombre">Apellidos <span class="text-danger">*</span></label>
                                                                                <input value="<?php echo $usuario->apellidos ?>" type="text" class="form-control" name="usuario[apellidos]" placeholder="Introduzca un nombre de usuario.." required>
                                                                            </div>
                                                                            <div class="mb-3">
                                                                                <label class="col-form-label" for="nombre">Teléfono <span class="text-danger">*</span></label>
                                                                                <input value="<?php echo $usuario->telefono ?>" type="text" class="form-control" name="usuario[telefono]" placeholder="Introduzca un nombre de usuario.." required>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-xl-6">
                                                                            <div class="mb-3">
                                                                                <label class="col-form-label" for="sexo">Sexo <span class="text-danger">*</span></label>
                                                                                <div class="col-xl-12 mb-3">
                                                                                    <select name="usuario[sexo]" id="sexo" class="nice-select form-control default-select dashboard-select-2 h-auto wide" required>
                                                                                        <?php if ($usuario->sexo === 'femenino') : ?>
                                                                                            <option value="<?php echo $usuario->sexo ?>" selected><?php echo "Femenino" ?></option>
                                                                                            <option value="masculino">Masculino</option>
                                                                                        <?php elseif ($usuario->sexo === 'masculino') : ?>
                                                                                            <option value="<?php echo $usuario->sexo ?>" selected><?php echo "Masculino" ?></option>
                                                                                            <option value="femenino">Femenino</option>
                                                                                        <?php else : ?>
                                                                                            <option selected disabled>Seleccione...</option>
                                                                                            <option value="masculino">Masculino</option>
                                                                                            <option value="femenino">Femenino</option>
                                                                                        <?php endif; ?>
                                                                                    </select>
                                                                                    <div class="invalid-feedback">
                                                                                        Debes seleccionar una opción.

                                                                                        <div class="mb-3">
                                                                                            <label class="col-form-label" for="email">Email <span class="text-danger">*</span></label>
                                                                                            <input value="<?php echo $usuario->email ?>" type="text" class="form-control" id="email" name="usuario[email]" placeholder="Introduzca un email" required>
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label class="col-form-label" for="email_opcional">Email Opcional</label>
                                                                                            <input value="<?php echo $usuario->email_opcional ?>" type="text" class="form-control" id="email_opcional" name="usuario[email_opcional]">
                                                                                        </div>
                                                                                        <div class="mb-3">
                                                                                            <label class="col-form-label" for="email_dam">Email DAM</label>
                                                                                            <input value="<?php echo $usuario->email_dam ?>" type="text" class="form-control" id="email_dam" name="usuario[email_dam]">
                                                                                        </div>
                                                                                        <div class="mb-3 row">
                                                                                            <input value="5" type="hidden" class="form-control" id="validationCustom02" name="usuario[id_rol]" required>
                                                                                        </div>
                                                                                        <!--  <div class="mb-3">
                                                                                    <label class="col-form-label" for="tipo_usuario">Tipo de Usuario <span class="text-danger">*</span></label>
                                                                                    <select name="usuario[tipo_usuario]" class="form-select">
                                                                                        <option selected disabled>Seleccione...</option>
                                                                                        <option value="profesor">Profesor</option>
                                                                                        <option value="tutor">Tutor</option>
                                                                                    </select>
                                                                                </div> -->
                                                                                    </div>
                                                                                </div>
                                                                                <div class="row">
                                                                                    <div class="col-xl-12">
                                                                                        <div class="mb-3">
                                                                                            <label class="col-form-label" for="password<?= $index ?>">Password <span class="text-danger">*</span></label>
                                                                                            <div class="input-group">
                                                                                                <span class="input-group-text"><i class="fa fa-lock"></i></span>
                                                                                                <input type="password" class="form-control" id="dlab-password<?= $index ?>" name="usuario[password]" data-index="<?= $index ?>" placeholder="Introduzca una contraseña" required>
                                                                                                <span class="input-group-text show-pass" id="toggle-password<?= $index ?>">
                                                                                                    <i class="fa fa-eye-slash"></i>
                                                                                                    <i class="fa fa-eye" style="display:none;"></i>
                                                                                                </span>
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
                                </tbody>
                            </table>
                            <script>
                                document.addEventListener('DOMContentLoaded', function() {
                                    document.querySelectorAll('.show-pass').forEach(togglePassword => {
                                        togglePassword.addEventListener('click', function() {
                                            const passwordInput = this.previousElementSibling;
                                            const isPassword = passwordInput.getAttribute('type') === 'password';
                                            passwordInput.setAttribute('type', isPassword ? 'text' : 'password');

                                            const eyeSlash = this.querySelector('.fa-eye-slash');
                                            const eye = this.querySelector('.fa-eye');
                                            eyeSlash.style.display = isPassword ? 'none' : 'inline';
                                            eye.style.display = isPassword ? 'inline' : 'none';
                                        });
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>