<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}
$pageTitle = 'Dashboard';
include '../partials/head.php';
?>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary app-loaded sidebar-collapse">
    <div class="app-wrapper">
        <?php include '../partials/navbar.php'; ?>
        <?php include '../partials/sidebar.php'; ?>

        <main class="app-main"><!--begin::App Main-->
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h1 class="mb-0">Dashboard</h1>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::App Content Header-->

            <!--begin::App Content-->
            <div class="app-content">
                <div class="container-fluid dashboard-section my-5">
                    <div class="row mb-5">
                        <div class="col-12 text-center">
                            <h2 class="dashboard-title">
                                Hola <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?> 👋
                            </h2>
                            <p class="dashboard-subtitle">Bienvenido al sistema SIGECES.</p>

                            <?php if ($_SESSION['usuario']['rol'] === 'admin'): ?>
                                <a href="../asignaciones/index.php" class="btn btn-dashboard">Asignar Cursos</a>
                            <?php elseif ($_SESSION['usuario']['rol'] === 'estudiante'): ?>
                                <a href="mis_cursos.php" class="btn btn-dashboard">Ver Mis Cursos</a>
                            <?php else: ?>
                                <a href="../cursos/index.php" class="btn btn-dashboard">Ver Cursos</a>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-6 col-lg-3">
                            <div class="card dashboard-card h-100">
                                <div class="card-body text-center">
                                    <h5><i class="bi bi-book me-2"></i> Mis Cursos</h5>
                                    <p class="small">Aquí se listarán los cursos en los que estás inscrito.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card dashboard-card h-100">
                                <div class="card-body text-center">
                                    <h5><i class="bi bi-person-circle me-2"></i> Perfil</h5>
                                    <p class="small">Información personal del usuario.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card dashboard-card h-100">
                                <div class="card-body text-center">
                                    <h5><i class="bi bi-pencil-square me-2"></i> Matrícula</h5>
                                    <p class="small">Estado de la matrícula y opciones de inscripción.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-lg-3">
                            <div class="card dashboard-card h-100">
                                <div class="card-body text-center">
                                    <h5><i class="bi bi-bell-fill me-2"></i> Notificaciones</h5>
                                    <p class="small">Avisos de pago y otras alertas importantes.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::App Content-->
        </main>
        <!--end::App Main-->

        <?php include '../partials/footer.php'; ?>
    </div>
    <!--end::App Wrapper-->