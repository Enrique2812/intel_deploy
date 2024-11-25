<div class="content-body">
    <div class="container-fluid">
        <!-- Row -->
        <div class="row">
            <div class="col-xl-6 col-sm-3">
                <?php if ($_SESSION['rol'] === '1') : ?>
                    <div class="text-start">
                        <a href="/aristoteles/profesor" class="btn btn-primary d-inline-flex align-items-center">
                            <span class="nav-text">Regresar</span> <!-- El texto -->
                        </a>
                    </div>
                <?php endif; ?>
                <?php if ($_SESSION['rol'] === '5') : ?>
                    <div class="text-start">
                        <a href="/aristoteles/profesor" class="btn btn-primary d-inline-flex align-items-center">
                            <span class="nav-text">Regresar</span> <!-- El texto -->
                        </a>
                    </div>
                <?php endif; ?>
                <?php if ($_SESSION['rol'] === '4') : ?>
                    <div class="text-start">
                        <a href="/aristoteles/alumno" class="btn btn-primary d-inline-flex align-items-center">
                            <span class="nav-text">Regresar</span> <!-- El texto -->
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="row">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <center>
                        <br>
                        <br>
                        <br>
                        <iframe src="<?php echo $aristoteles->urlVideo ?>" height="720" width="1280" name="demo" allowfullscreen>
                        </iframe>
                    </center>

                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</div>