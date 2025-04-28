<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}
include '../partials/head.php';
?>

<body class="hold-transition sidebar-mini sidebar-collapse">
    <div class="app-wrapper">
        <?php include '../partials/navbar.php'; ?>
        <?php include '../partials/sidebar.php'; ?>

        <main class="app-main content-wrapper">
            <section class="app-content-header">
                <div class="container-fluid">
                    <h1>Dashboard</h1>
                </div>
            </section>
            <section class="app-content">
                <div class="container-fluid dashboard-section my-5">
                    <div class="text-center mb-5">
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

                    <div class="row g-4">
                        <!-- Tus tarjetas aquí -->
                    </div>
                </div>
            </section>
        </main>

        <?php include '../partials/footer.php'; ?>
    </div>
</body>