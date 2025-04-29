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
            <!-- Cabecera -->
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

            <div class="app-content">
                <div class="container-fluid">

                    <?php if ($_SESSION['usuario']['rol'] !== 'estudiante'): ?>
                        <!-- FILA DE SMALL BOXES -->
                        <div class="row">
                            <!-- Usuarios -->
                            <div class="col-lg-3 col-6">
                                <div class="small-box text-bg-primary">
                                    <div class="inner">
                                        <h3><?= $data['usuarios'] ?? 0 ?></h3>
                                        <p>Total de Usuarios</p>
                                    </div>
                                    <i class="bi bi-people small-box-icon"></i>
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
                                </div>
                            </div>
                        </div>

                        <!-- FILA DE PROMEDIO DE NOTAS -->
                        <div class="row mt-3">
                            <div class="col-lg-3 col-6">
                                <div class="small-box text-bg-info">
                                    <div class="inner">
                                        <h3><?= $data['promedioNotas'] ?? '0.00' ?></h3>
                                        <p>Promedio de Notas</p>
                                    </div>
                                    <i class="bi bi-star small-box-icon"></i>
                                </div>
                            </div>
                        </div>

                        <!-- FILA DEL GRÁFICO Y LA TABLA -->
                        <div class="row mt-4">
                            <!-- Inscripciones por curso (Gráfico) -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Inscripciones por curso</h5>
                                    </div>
                                    <div class="card-body">
                                        <canvas id="inscripcionesChart"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- Asignaciones recientes (Tabla) -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Asignaciones recientes</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <table class="table table-sm mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Fecha</th>
                                                    <th>Estudiante</th>
                                                    <th>Curso</th>
                                                    <th>Acción</th>
                                                    <th>Quién</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($data['asignacionesRecientes'] as $a): ?>
                                                    <tr>
                                                        <td><?= $a['fecha_asignacion'] ?></td>
                                                        <td><?= htmlspecialchars($a['estudiante']) ?></td>
                                                        <td><?= htmlspecialchars($a['curso']) ?></td>
                                                        <td><?= ucfirst($a['accion']) ?></td>
                                                        <td><?= htmlspecialchars($a['actor']) ?></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Chart.js -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script>
                            // Usamos el array de asignacionesPorCurso para el gráfico
                            const raw = <?= json_encode($data['asignacionesPorCurso'], JSON_HEX_TAG) ?>;
                            const labels = raw.map(r => r.curso);
                            const values = raw.map(r => r.total);

                            new Chart(
                                document.getElementById('inscripcionesChart'), {
                                    type: 'bar',
                                    data: {
                                        labels,
                                        datasets: [{
                                            label: 'Asignados',
                                            data: values
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true
                                            }
                                        }
                                    }
                                }
                            );
                        </script>

                    <?php else: ?>
                        <!-- VISTA ESTUDIANTE: SOLO MENSAJE DE BIENVENIDA -->
                        <div class="row">
                            <div class="col-12 text-center py-5">
                                <h2 class="fw-light">
                                    ¡Bienvenido, <?= htmlspecialchars($_SESSION['usuario']['nombre']) ?>!
                                </h2>
                                <p class="text-muted">
                                    Accede al menú lateral para ver tus cursos e inscripciones.
                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </main>

        <?php include __DIR__ . '/../partials/footer.php'; ?>
    </div>