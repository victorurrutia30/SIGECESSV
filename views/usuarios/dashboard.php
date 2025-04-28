<?php
if (!isset($_SESSION)) session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}
$pageTitle = 'Dashboard';
include __DIR__ . '/../partials/head.php';
?>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary app-loaded sidebar-collapse">
    <div class="app-wrapper">
        <?php include __DIR__ . '/../partials/navbar.php'; ?>
        <?php include __DIR__ . '/../partials/sidebar.php'; ?>

        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">Dashboard</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::App Content Header-->

            <div class="app-content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Usuarios -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-primary">
                                <div class="inner">
                                    <h3><?= $data['usuarios'] ?? 0 ?></h3>
                                    <p>Total de Usuarios</p>
                                </div>
                                <i class="bi bi-people small-box-icon"></i>
                                <a href="#" class="small-box-footer">
                                    Más info <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Docentes -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-success">
                                <div class="inner">
                                    <h3><?= $data['docentes'] ?? 0 ?></h3>
                                    <p>Total de Docentes</p>
                                </div>
                                <i class="bi bi-person-badge small-box-icon"></i>
                                <a href="#" class="small-box-footer">
                                    Más info <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Cursos -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-warning">
                                <div class="inner">
                                    <h3><?= $data['cursos'] ?? 0 ?></h3>
                                    <p>Total de Cursos</p>
                                </div>
                                <i class="bi bi-journal-text small-box-icon"></i>
                                <a href="#" class="small-box-footer">
                                    Más info <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Inscripciones -->
                        <div class="col-lg-3 col-6">
                            <div class="small-box text-bg-danger">
                                <div class="inner">
                                    <h3><?= $data['inscripciones'] ?? 0 ?></h3>
                                    <p>Total de Inscripciones</p>
                                </div>
                                <i class="bi bi-pencil-square small-box-icon"></i>
                                <a href="#" class="small-box-footer">
                                    Más info <i class="bi bi-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include __DIR__ . '/../partials/footer.php'; ?>
    </div>