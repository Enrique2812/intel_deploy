<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Aristoteles</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Alumno</a></li>
                    </ol>
                </div>
                <?php if ($_SESSION['rol'] === '4') : ?>
                    <div class="filter cm-content-box box-primary">
                        <div class="cm-content-body  form excerpt">
                            <div class="card-body">
                                <div class="row d-flex align-items-center">
                                    <!-- Selector de Cursos -->
                                    <div class="col-xl-3 col-sm-6 mb-3">
                                        <select id="cursoSelect" class="form-select">
                                            <option value="AL">Todo</option>
                                            <?php foreach ($aulaAlumno as $curso): ?>
                                                <?php $cursoAula = $buscaCurso->find($curso->id_curso); ?>
                                                <option value="<?php echo $cursoAula->id ?>"><?php echo $cursoAula->descripcion ?></option>
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
        <?php if ($_SESSION['rol'] === '4' && $_SESSION['matricula'] === '1') : ?>
            <div class="row">
                <?php foreach ($aristoteles as $aristotele) : ?>
                    <?php if ($_SESSION['id_aula'] === $aristotele->id_aula) : ?>
                        <?php $aulaPersona = $buscaAula->find($aristotele->id_aula) ?>
                        <?php $nivel = $buscaNivel->find($aulaPersona->id_nivel) ?>
                        <?php $grado = $buscaGrado->find($aulaPersona->id_grado) ?>
                        <?php $seccion = $buscaSeccion->find($aulaPersona->id_seccion) ?>
                        <?php $curso = $buscaCurso->find($aristotele->id_curso) ?>
                        <div class="col-xl-2 card-container" data-curso="<?php echo $curso->id ?>">
                            <div class="card">
                                <img src="../imagenes/<?php echo $aristotele->imagen ?>" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h3 class="card-title"><?php echo $aristotele->titulo . ' - ' . $curso->descripcion ?></h3>
                                    <a href="/aristoteles/contenido?id=<?php echo $aristotele->id ?>" class="btn btn-primary">Abrir</a>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cursoSelect = document.getElementById('cursoSelect');
        const cards = document.querySelectorAll('.card-container'); // Seleccionamos todas las tarjetas

        // Función para filtrar tarjetas
        function filtrarTarjetas() {
            const cursoSeleccionado = cursoSelect.value;

            cards.forEach(card => {
                const cursoCard = card.getAttribute('data-curso');

                // Condición para mostrar u ocultar la tarjeta
                const mostrarPorCurso = (cursoSeleccionado === 'AL' || cursoCard === cursoSeleccionado);

                // Mostrar solo si cumple ambas condiciones
                if (mostrarPorCurso) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        // Escuchar cambios en los selectores
        cursoSelect.addEventListener('change', filtrarTarjetas);
    });
</script>