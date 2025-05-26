<?php
// SIGECES/views/reportes/index.php

session_start();
// Solo usuarios autenticados
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}

$pageTitle = 'Panel de Reportes';
include '../partials/head.php';
?>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary app-loaded sidebar-collapse">
    <div class="app-wrapper">
        <?php include __DIR__ . '/../partials/navbar.php'; ?>
        <?php include __DIR__ . '/../partials/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <h1 class="mb-0"><?= $pageTitle ?></h1>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid my-5">
                    <div class="row g-4">
                        <!-- 1. Inscripciones por Curso (admin, docente) -->
                        <?php if (in_array($_SESSION['usuario']['rol'], ['admin', 'docente'])): ?>
                            <div class="col-sm-6 col-lg-4">
                                <a href="/SIGECES/controller/ReporteInscripcionesController.php" class="card-link" target="_blank">
                                    <div class="card report-card text-center p-3">
                                        <i class="bi bi-journal-text report-icon"></i>
                                        <h5 class="card-title mt-2">Inscripciones por Curso</h5>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- 2. Historial de Asignaciones por Estudiante (admin, docente, estudiante) -->
                        <?php if (in_array($_SESSION['usuario']['rol'], ['admin', 'docente', 'estudiante'])): ?>
                            <div class="col-sm-6 col-lg-4">
                                <a href="/SIGECES/controller/HistorialAsignacionesController.php" class="card-link" target="_blank">
                                    <div class="card report-card text-center p-3">
                                        <i class="bi bi-clock-history report-icon"></i>
                                        <h5 class="card-title mt-2">Historial de Asignaciones</h5>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- 3. Reporte General de Calificaciones (admin, docente) -->
                        <?php if (in_array($_SESSION['usuario']['rol'], ['admin', 'docente'])): ?>
                            <div class="col-sm-6 col-lg-4">
                                <a href="/SIGECES/controller/CalificacionesController.php" class="card-link" target="_blank">
                                    <div class="card report-card text-center p-3">
                                        <i class="bi bi-bar-chart report-icon"></i>
                                        <h5 class="card-title mt-2">General de Calificaciones</h5>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- 4. Constancia de Estudio (estudiante) -->
                        <?php if ($_SESSION['usuario']['rol'] === 'estudiante'): ?>
                            <div class="col-sm-6 col-lg-4">
                                <a href="/SIGECES/controller/ConstanciaController.php" class="card-link" target="_blank">
                                    <div class="card report-card text-center p-3">
                                        <i class="bi bi-file-earmark-check report-icon"></i>
                                        <h5 class="card-title mt-2">Constancia de Estudio</h5>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- 5. Reporte de Usuarios por Rol (admin) -->
                        <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                            <div class="col-sm-6 col-lg-4">
                                <a href="/SIGECES/controller/UsuariosRolController.php" class="card-link" target="_blank">
                                    <div class="card report-card text-center p-3">
                                        <i class="bi bi-people report-icon"></i>
                                        <h5 class="card-title mt-2">Usuarios por Rol</h5>
                                    </div>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <?php include __DIR__ . '/../partials/footer.php'; ?>