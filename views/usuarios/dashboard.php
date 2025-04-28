<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}
include '../partials/head.php';
include '../partials/navbar.php';
?>

<div class="dashboard-section container my-5">
    <div class="text-center mb-5">
        <h2 class="dashboard-title">Hola <?= $_SESSION['usuario']['nombre'] ?> 👋</h2>
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
        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card h-100">
                <h5><i class="fas fa-book me-2"></i>Mis Cursos</h5>
                <p class="small">Aquí se listarán los cursos en los que estás inscrito.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card h-100">
                <h5><i class="fas fa-user me-2"></i>Perfil</h5>
                <p class="small">Información personal del estudiante.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card h-100">
                <h5><i class="fas fa-file-alt me-2"></i>Matrícula</h5>
                <p class="small">Estado de la matrícula y opción para inscribirse en nuevos cursos.</p>
            </div>
        </div>

        <div class="col-md-6 col-lg-3">
            <div class="dashboard-card h-100">
                <h5><i class="fas fa-bell me-2"></i>Notificaciones</h5>
                <p class="small">Avisos de pago, nuevas matrículas y otros mensajes.</p>
            </div>
        </div>
    </div>
</div>


<?php include '../partials/footer.php'; ?>