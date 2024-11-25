<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Aristoteles</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Profesor</a></li>
                    </ol>
                </div>
                <?php if ($_SESSION['rol'] === '5') : ?>
                    <div class="filter cm-content-box box-primary">
                        <div class="cm-content-body  form excerpt">
                            <div class="card-body">
                                <div class="row d-flex align-items-center">

                                    <!-- Selector de Aulas -->
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="aulaSelect" class="form-select" aria-label="Default select example">
                                            <option value="AL">Todo</option>
                                            <?php $aulasMostradas = []; ?>
                                            <?php foreach ($aulasPermitidas as $aulaP) : ?>
                                                <?php foreach ($aulas as $aula) : ?>
                                                    <?php if (!in_array($aulaP->id_aula, $aulasMostradas)): ?>
                                                        <?php if ($aula->id === $aulaP->id_aula): ?>
                                                            <?php $aulasMostradas[] = $aulaP->id_aula;  ?>
                                                            <option value="<?php echo $aula->id; ?>"><?php echo $aula->nombre; ?></option>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Selector de Cursos -->
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="cursoSelect" class="form-select">
                                            <option value="AL">Todo</option>
                                            <?php foreach ($cursos as $curso): ?>
                                                <option value="<?php echo $curso->id ?>"><?php echo $curso->descripcion ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <!-- Botón Agregar -->
                                    <div class="col-xl-4 mb-3">
                                        <a href="/aristoteles/tarea" class="btn btn-primary d-inline-flex align-items-center">
                                            <i class="fa-solid fa-plus me-2"></i>
                                            <span class="nav-text">Agregar</span>
                                        </a>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($_SESSION['rol'] === '1') : ?>
                    <div class="filter cm-content-box box-primary">
                        <div class="cm-content-body  form excerpt">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="nivelSelect" class="form-select" aria-label="Seleccionar nivel">
                                            <option value="AL">Todo</option>
                                            <?php foreach ($niveles as $nivel): ?>
                                                <option value="<?php echo $nivel->id ?>"><?php echo $nivel->descripcion ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="gradoSelect" class="form-select" aria-label="Seleccionar grado">
                                            <option value="AL">Todo</option>
                                        </select>
                                    </div>

                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="seccionSelect" class="form-select" aria-label="Seleccionar sección">
                                            <option value="AL">Todo</option>
                                            <?php foreach ($secciones as $seccion): ?>
                                                <option value="<?php echo $seccion->id ?>"><?php echo $seccion->descripcion ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="cursoSelect" class="form-select" aria-label="Seleccionar curso">
                                            <option value="AL">Todo</option>
                                            <?php foreach ($cursos as $curso): ?>
                                                <option value="<?php echo $curso->id ?>"><?php echo $curso->descripcion ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <div class="row">
            <?php if ($_SESSION['rol'] === '5' && $_SESSION['tutor'] === '0') : ?>
                <?php foreach ($aristoteles as $aristotele) : ?>
                    <?php $repetidos = []; ?>
                    <?php foreach ($aulasPermitidas as $aulaP): ?>
                        <?php if ($aristotele->id_aula === $aulaP->id_aula  && $aristotele->estado === '0' && !in_array($aristotele->id, $repetidos)): ?>
                            <?php $repetidos[] = $aristotele->id;  ?>
                            <?php foreach ($aulas as $aula): ?>
                                <?php if ($aula->id === $aristotele->id_aula): ?>
                                    <?php $buscaAula = $aula; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($niveles as $nivel): ?>
                                <?php if ($nivel->id === $buscaAula->id_nivel): ?>
                                    <?php $buscaNivel = $nivel; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($grados as $grado): ?>
                                <?php if ($grado->id === $buscaAula->id_grado): ?>
                                    <?php $buscaGrado = $grado; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($cursos as $curso): ?>
                                <?php if ($curso->id === $aristotele->id_curso): ?>
                                    <?php $buscaCurso = $curso; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php $nivel = $buscaNivel ?>
                            <?php $grado = $buscaGrado ?>
                            <?php $curso = $buscaCurso ?>
                            <div class="col-xl-2 card-container" data-aula="<?php echo $buscaAula->id ?>" data-curso="<?php echo $curso->id ?>">
                                <div class="card">
                                    <img src="../imagenes/<?php echo $aristotele->imagen ?>" class="card-img-top" alt="...">
                                    <div class="card-body text-center">
                                        <h4 class="card-title"><?php echo $aristotele->titulo . ' - ' . $curso->descripcion ?></h4>
                                        <p class="card-text mb-2"><strong>Aula: </strong><?php echo $buscaAula->nombre ?></p>
                                        <p class="card-text mb-2"><strong>Nivel: </strong><?php echo $nivel->descripcion ?></p>
                                        <p class="card-text mb-2"><strong>Grado: </strong><?php echo $grado->descripcion ?></p>
                                        <a href="/aristoteles/contenido?id=<?php echo $aristotele->id ?>" class="btn btn-primary w-100" style="padding: 5px 0;">Abrir</a>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($_SESSION['rol'] === '5' &&  $_SESSION['tutor'] === '1') : ?>
                <?php foreach ($aristoteles as $aristotele) : ?>
                    <?php $aulaRepetido = false; ?>
                    <?php if ($_SESSION['id_aula'] === $aristotele->id_aula) : ?>
                        <?php $aulaRepetido = true; ?>
                        <?php foreach ($aulas as $aula): ?>
                            <?php if ($aula->id === $aristotele->id_aula): ?>
                                <?php $buscaAula = $aula; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach ($niveles as $nivel): ?>
                            <?php if ($nivel->id === $buscaAula->id_nivel): ?>
                                <?php $buscaNivel = $nivel; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach ($grados as $grado): ?>
                            <?php if ($grado->id === $buscaAula->id_grado): ?>
                                <?php $buscaGrado = $grado; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach ($cursos as $curso): ?>
                            <?php if ($curso->id === $aristotele->id_curso): ?>
                                <?php $buscaCurso = $curso; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php $aulaPersona = $buscaAula ?>
                        <?php $nivel = $buscaNivel ?>
                        <?php $grado = $buscaGrado ?>
                        <?php $curso = $buscaCurso ?>

                        <div class="col-xl-2 card-container" data-aula="<?php echo $aulaPersona->id ?>" data-curso="<?php echo $curso->id ?>">
                            <div class="card">
                                <img src="../imagenes/<?php echo $aristotele->imagen ?>" class="card-img-top" alt="...">
                                <div class="card-body text-center"> <!-- Centramos el contenido -->
                                    <h3 class="card-title"><?php echo $aristotele->titulo . ' - ' . $curso->descripcion ?></h3>
                                    <p class="card-text mb-2"><strong>Aula: </strong><?php echo $aulaPersona->nombre ?></p>
                                    <p class="card-text mb-2"><strong>Nivel: </strong><?php echo $nivel->descripcion ?></p> <!-- Usamos card-text para consistencia -->
                                    <p class="card-text mb-2"><strong>Grado: </strong><?php echo $grado->descripcion ?></p>
                                    <!-- Ajustamos márgenes -->
                                    <a href="/aristoteles/contenido?id=<?php echo $aristotele->id ?>" class="btn btn-primary w-100" style="padding: 5px 0;">Abrir</a> <!-- Botón a 100% -->
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php foreach ($aulasPermitidas as $aula): ?>
                        <?php if ($aula->id_aula === $aristotele->id_aula && $aulaRepetido != true): ?>
                            <?php foreach ($aulas as $aula): ?>
                                <?php if ($aula->id === $aristotele->id_aula): ?>
                                    <?php $buscaAula = $aula; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($niveles as $nivel): ?>
                                <?php if ($nivel->id === $buscaAula->id_nivel): ?>
                                    <?php $buscaNivel = $nivel; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($grados as $grado): ?>
                                <?php if ($grado->id === $buscaAula->id_grado): ?>
                                    <?php $buscaGrado = $grado; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php foreach ($cursos as $curso): ?>
                                <?php if ($curso->id === $aristotele->id_curso): ?>
                                    <?php $buscaCurso = $curso; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                            <?php $nivel = $buscaNivel ?>
                            <?php $grado = $buscaGrado ?>
                            <?php $curso = $buscaCurso ?>
                            <?php $curso = $buscaAula ?>
                            <div class="col-xl-2 card-container" data-aula="<?php echo $aulaPersona->id ?>" data-curso="<?php echo $curso->id ?>">
                                <div class="card">
                                    <img src="../imagenes/<?php echo $aristotele->imagen ?>" class="card-img-top" alt="...">
                                    <div class="card-body text-center"> <!-- Centramos el contenido -->
                                        <h3 class="card-title"><?php echo $aristotele->titulo . ' - ' . $curso->descripcion ?></h3>
                                        <p class="card-text mb-2"><strong>Aula: </strong><?php echo $aulaPersona->nombre ?></p>
                                        <p class="card-text mb-2"><strong>Nivel: </strong><?php echo $nivel->descripcion ?></p> <!-- Usamos card-text para consistencia -->
                                        <p class="card-text mb-2"><strong>Grado: </strong><?php echo $grado->descripcion ?></p>
                                        <p class="card-text mb-3"><strong>Sección: </strong><?php echo $seccion->descripcion ?></p>
                                        <!-- Ajustamos márgenes -->
                                        <a href="/aristoteles/contenido?id=<?php echo $aristotele->id ?>" class="btn btn-primary w-100" style="padding: 5px 0;">Abrir</a> <!-- Botón a 100% -->
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endif; ?>
            <?php if ($_SESSION['rol'] === '1') : ?>
                <div class="row card-container"> <!-- Asegúrate de que todas las tarjetas están dentro de un contenedor -->
                    <?php foreach ($aristoteles as $aristotele) : ?>
                        <?php $repetidos[] = $aristotele->id;  ?>
                        <?php foreach ($aulas as $aula): ?>
                            <?php if ($aula->id === $aristotele->id_aula): ?>
                                <?php $buscaAula = $aula; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach ($niveles as $nivel): ?>
                            <?php if ($nivel->id === $buscaAula->id_nivel): ?>
                                <?php $buscaNivel = $nivel; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach ($grados as $grado): ?>
                            <?php if ($grado->id === $buscaAula->id_grado): ?>
                                <?php $buscaGrado = $grado; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php foreach ($cursos as $curso): ?>
                            <?php if ($curso->id === $aristotele->id_curso): ?>
                                <?php $buscaCurso = $curso; ?>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php $aula = $buscaAula ?>
                        <?php $nivel = $buscaNivel ?>
                        <?php $grado = $buscaGrado ?>
                        <?php $curso = $buscaCurso ?>
                        <div class="col-xl-2 card-item"
                            data-nivel="<?php echo $nivel->id ?>"
                            data-grado="<?php echo $grado->id ?>"
                            data-seccion="<?php echo $seccion->id ?>"
                            data-curso="<?php echo $curso->id ?>">
                            <div class="card position-relative shadow-sm">
                                <img src="../imagenes/<?php echo $aristotele->imagen ?>" class="card-img-top" alt="...">
                                <div class="card-body text-center" style="padding: 10px 0;">
                                    <h5 class="card-title"><?php echo $aristotele->titulo . ' - ' . $curso->descripcion ?></h5>
                                    <p class="card-text mb-2"><strong>Aula: </strong><?php echo $aula->nombre ?></p>
                                    <p class="card-text mb-2"><strong>Nivel: </strong><?php echo $nivel->descripcion ?></p>
                                    <p class="card-text mb-2"><strong>Grado: </strong><?php echo $grado->descripcion ?></p>
                                    <p class="card-text mb-3"><strong>Sección: </strong><?php echo $seccion->descripcion ?></p>
                                    <?php if ($aristotele->estado === '0') : ?>
                                        <i class="fa-solid fa-eye position-absolute" style="top: 10px; right: 10px; font-size: 24px; color: green;"></i>
                                    <?php else : ?>
                                        <i class="fa-solid fa-eye-slash position-absolute" style="top: 10px; right: 10px; font-size: 24px; color: red;"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer bg-light">
                                    <div class="d-flex justify-content-between">
                                        <a href="/aristoteles/contenido?id=<?php echo $aristotele->id ?>" class="btn btn-primary btn-sm">
                                            <i class="fas fa-folder-open"></i> Abrir
                                        </a>
                                        <?php if ($aristotele->estado === '0') : ?>
                                            <a href="/aristoteles/estado?id=<?php echo $aristotele->id ?>" class="btn btn-danger btn-sm">
                                                <i class="fas fa-eye-slash"></i> Ocultar
                                            </a>
                                        <?php else : ?>
                                            <a href="/aristoteles/estado?id=<?php echo $aristotele->id ?>" class="btn btn-warning btn-sm">
                                                <i class="fa-solid fa-eye"></i> Visualizar
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>


        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const aulaSelect = document.getElementById('aulaSelect');
        const cursoSelect = document.getElementById('cursoSelect');
        const cards = document.querySelectorAll('.card-container'); // Seleccionamos todas las tarjetas

        // Función para filtrar tarjetas
        function filtrarTarjetas() {
            const aulaSeleccionada = aulaSelect.value;
            const cursoSeleccionado = cursoSelect.value;

            cards.forEach(card => {
                const aulaCard = card.getAttribute('data-aula');
                const cursoCard = card.getAttribute('data-curso');

                // Condición para mostrar u ocultar la tarjeta
                const mostrarPorAula = (aulaSeleccionada === 'AL' || aulaCard === aulaSeleccionada);
                const mostrarPorCurso = (cursoSeleccionado === 'AL' || cursoCard === cursoSeleccionado);

                // Mostrar solo si cumple ambas condiciones
                if (mostrarPorAula && mostrarPorCurso) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Escuchar cambios en los selectores
        aulaSelect.addEventListener('change', filtrarTarjetas);
        cursoSelect.addEventListener('change', filtrarTarjetas);
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const nivelSelect = document.getElementById('nivelSelect');
        const gradoSelect = document.getElementById('gradoSelect');
        const seccionSelect = document.getElementById('seccionSelect');
        const cursoSelect = document.getElementById('cursoSelect');
        const cards = document.querySelectorAll('.card-item');

        // Datos de grados dinámicos
        const gradosPrimaria = [
            <?php foreach ($grados as $grado): ?>
                <?php if ($grado->id_nivel === '2'): ?> {
                        id: "<?php echo $grado->id ?>",
                        descripcion: "<?php echo $grado->descripcion ?>"
                    },
                <?php endif; ?>
            <?php endforeach; ?>
        ];

        const gradosSecundaria = [
            <?php foreach ($grados as $grado): ?>
                <?php if ($grado->id_nivel === '3'): ?> {
                        id: "<?php echo $grado->id ?>",
                        descripcion: "<?php echo $grado->descripcion ?>"
                    },
                <?php endif; ?>
            <?php endforeach; ?>
        ];

        // Función para actualizar el select de grados según el nivel
        function actualizarGrados() {
            const selectedNivel = nivelSelect.value;
            gradoSelect.innerHTML = '<option value="AL">Todo</option>';

            let grados = [];
            if (selectedNivel === '2') {
                grados = gradosPrimaria;
            } else if (selectedNivel === '3') {
                grados = gradosSecundaria;
            }

            grados.forEach(grado => {
                const option = document.createElement('option');
                option.value = grado.id;
                option.text = grado.descripcion;
                gradoSelect.appendChild(option);
            });
        }

        // Función para filtrar las tarjetas
        function filtrarTarjetas() {
            const nivelSeleccionado = nivelSelect.value;
            const gradoSeleccionado = gradoSelect.value;
            const seccionSeleccionada = seccionSelect.value;
            const cursoSeleccionado = cursoSelect.value;

            cards.forEach(card => {
                const nivelCard = card.getAttribute('data-nivel');
                const gradoCard = card.getAttribute('data-grado');
                const seccionCard = card.getAttribute('data-seccion');
                const cursoCard = card.getAttribute('data-curso');

                const mostrarPorNivel = (nivelSeleccionado === 'AL' || nivelCard === nivelSeleccionado);
                const mostrarPorGrado = (gradoSeleccionado === 'AL' || gradoCard === gradoSeleccionado);
                const mostrarPorSeccion = (seccionSeleccionada === 'AL' || seccionCard === seccionSeleccionada);
                const mostrarPorCurso = (cursoSeleccionado === 'AL' || cursoCard === cursoSeleccionado);

                if (mostrarPorNivel && mostrarPorGrado && mostrarPorSeccion && mostrarPorCurso) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Escuchar cambios en los selectores
        nivelSelect.addEventListener('change', () => {
            actualizarGrados(); // Actualizar grados al cambiar el nivel
            filtrarTarjetas(); // Filtrar tarjetas al cambiar el nivel
        });

        gradoSelect.addEventListener('change', filtrarTarjetas);
        seccionSelect.addEventListener('change', filtrarTarjetas);
        cursoSelect.addEventListener('change', filtrarTarjetas);
    });
</script>