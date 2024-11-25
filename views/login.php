<?php
// debuguear($CurrentPage);
include 'elements/dz.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- PAGE TITLE HERE -->
    <title><?php echo $DexignZoneSettings['site_level']['site_title'] ?></title>
    <?php include  'elements/meta.php'; ?>
    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="<?php echo $DexignZoneSettings['site_level']['favicon'] ?>">

    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.6.0/css/all.css">
    <?php include  'elements/page-css.php'; ?>
</head>

<body class="vh-100" style="background-image:none">
    <div class="authincation h-100">
        <div class="container-fluid h-100" style="padding-right:0">
            <div class="row h-100">
                <div class="col-lg-6 col-md-12 col-sm-12 mx-auto align-self-center">
                    <div class="login-form">
                        <div class="text-center">
                            <h3 class="title">Iniciar Sesión</h3>
                            <p>Inicie sesión en su cuenta para comenzar a utilizar Intel Web</p>
                        </div>

                        <?php foreach ($errores as $error) : ?>
                            <div class="alert alert-danger solid alert-dismissible fade show">
                                <svg viewBox="0 0 24 24" width="24 " height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="me-2">
                                    <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 2"></polygon>
                                    <line x1="15" y1="9" x2="9" y2="15"></line>
                                    <line x1="9" y1="9" x2="15" y2="15"></line>
                                </svg>
                                <strong>!Error! </strong> <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="btn-close"></button>
                            </div>
                        <?php endforeach; ?>
                        <form action="index.php" method="POST">
                            <div class="mb-4">
                                <label class="mb-1 text-dark">Ingrese su Usuario :</label>
                                <input name="email" type="email" class="form-control form-control" value="<?php echo $usuario->email ?>">
                            </div>
                            <div class="mb-4 position-relative">
                                <label class="mb-1 text-dark">Ingrese su Password :</label>
                                <input name="password" type="password" id="dlab-password" class="form-control form-control" value="<?php echo $usuario->password ?>">
                                <span class="show-pass eye">
                                    <i class="fa fa-eye-slash"></i>
                                    <i class="fa fa-eye"></i>
                                </span>
                            </div>
                            <div class="text-center mb-4">
                                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                            </div>
                            <!-- <h6 class="login-title"><span>O continuar con</span></h6> -->
                            <p class="text-center">Olvido su contraseña?
                                <a class="btn-link text-primary" href="page-register.php">Presiona Aqui</a>
                            </p>
                        </form>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 h-100">
                    <div class="pages-left h-100">
                        <div class=" text-center h-100">
                            <img src="/assets/images/login-personal.jpg" alt="" class="img-fluid h-100 w-100" style="object-fit: cover;">
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="/assets/vendor/global/global.min.js"></script>
    <script src="/assets/js/custom.min.js"></script>
    <script src="/assets/js/dlabnav-init.js"></script>

</body>

</html>