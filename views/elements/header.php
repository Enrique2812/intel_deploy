<?php
session_start();

$currentYear = date('Y');

if (!isset($_SESSION['selectedYear'])) {
    $_SESSION['selectedYear'] = $currentYear;
}

$selectedYear = $_SESSION['selectedYear'];

if (isset($_GET['newYear'])) {
    if ($_GET['newYear'] !== $_SESSION['selectedYear']) {
        $_SESSION['selectedYear'] = $_GET['newYear'];
    }
}

use Controllers\AñoController;

$años = AñoController::obtenerAños();

?>

<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">

                    </div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item dropdown notification_dropdown">
                        <a class="nav-link bell dz-theme-mode p-0" href="javascript:void(0);">
                            <i id="icon-light" class="fas fa-sun"></i>
                            <i id="icon-dark" class="fas fa-moon"></i>
                        </a>
                    </li>

                    <?php if ($_SESSION['rol'] == '1'): ?>
                        <div class="card-body">
                            <div class="btn-group" role="group">
                                <!-- Botón dropdown para mostrar los años desde la base de datos -->
                                <button class="btn btn-primary dropdown-toggle" id="selectedYearButton" data-bs-toggle="dropdown" aria-expanded="false">
                                    <?php echo $selectedYear; ?>
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="selectedYearButton">
                                    <!-- Cargar los años directamente desde la base de datos -->
                                    <?php foreach ($años as $año): ?>
                                        <li>
                                            <a href="javascript:void(0);" class="dropdown-item"
                                                onclick="updateYear('<?php echo $año->numero; ?>')">
                                                <?php echo $año->numero; ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </ul>
            </div>
        </nav>
    </div>
</div>

<script>
    function updateYear(year) {
        const url = new URL(window.location);
        url.searchParams.set('newYear', year);
        window.history.pushState({}, '', url);

        fetch(`?newYear=${year}`)
            .then(response => {
                if (response.ok) {
                    location.reload();
                }
            });
    }
</script>