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
                            <h3 class="mb-0">Home</h3>
                        </div>

                    </div>
                </div>
            </div>

            <div class="app-content">
                <div class="container-fluid">

                    <?php if ($_SESSION['usuario']['rol'] !== 'estudiante'): ?>
                        <!-- FILA DE CARDS -->
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
                            <!-- Total de Estudiantes -->
                            <div class="col-lg-3 col-6">
                                <div class="small-box text-bg-secondary">
                                    <div class="inner">
                                        <h3><?= $data['estudiantes'] ?? 0 ?></h3>
                                        <p>Total de Estudiantes</p>
                                    </div>
                                    <i class="bi bi-mortarboard small-box-icon"></i>
                                </div>
                            </div>
                            <!-- Usuarios Activos Última Semana -->
                            <div class="col-lg-3 col-6">
                                <div class="small-box text-bg-dark">
                                    <div class="inner">
                                        <h3><?= $data['activosUltimaSemana'] ?? 0 ?></h3>
                                        <p>Usuarios Activos Última Semana</p>
                                    </div>
                                    <i class="bi bi-clock-history small-box-icon"></i>
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
                            <!-- FILA DE PROMEDIO DE NOTAS -->

                            <div class="col-lg-3 col-6">
                                <div class="small-box text-bg-info">
                                    <div class="inner">
                                        <h3><?= $data['promedioNotas'] ?? '0.00' ?></h3>
                                        <p>Promedio de Notas</p>
                                    </div>
                                    <i class="bi bi-star small-box-icon"></i>
                                </div>
                            </div>
                            <!-- Inscripciones Pendientes de Calificación -->
                            <div class="col-lg-3 col-6">
                                <div class="small-box text-bg-warning">
                                    <div class="inner">
                                        <h3><?= $data['pendientesCalificar'] ?? 0 ?></h3>
                                        <p>Usuarios Pendientes de Calificación</p>
                                    </div>
                                    <i class="bi bi-hourglass-split small-box-icon"></i>
                                </div>
                            </div>

                        </div>

                        <!-- GRID 2×2: 2 columnas en todas las resoluciones -->
                        <div class="row row-cols-1 row-cols-sm-2 g-4 mt-4 dashboard-grid">
                            <!-- Inscripciones por curso -->
                            <div class="col">
                                <div class="card dashboard-card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Inscripciones por curso</h5>
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <canvas id="inscripcionesChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Asignaciones recientes -->
                            <div class="col">
                                <div class="card dashboard-card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Asignaciones recientes</h5>
                                    </div>
                                    <div class="card-body p-0 d-flex flex-column">
                                        <div class="table-responsive flex-fill">
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

                            <!-- Distribución de Roles -->
                            <div class="col">
                                <div class="card dashboard-card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Distribución de Roles</h5>
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <canvas id="rolesChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>

                            <!-- Tendencia de Inscripciones -->
                            <div class="col">
                                <div class="card dashboard-card">
                                    <div class="card-header">
                                        <h5 class="card-title mb-0">Tendencia (Últimos 30 días)</h5>
                                    </div>
                                    <div class="card-body d-flex align-items-center justify-content-center">
                                        <canvas id="inscripcionesTrendChart" width="400" height="300"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- Chart.js -->
                        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

                        <script>
                            // Escalar canvas en pantallas retina o zoom
                            function resizeCanvas(canvas) {
                                const dpr = window.devicePixelRatio || 1;
                                const rect = canvas.getBoundingClientRect();
                                canvas.width = rect.width * dpr;
                                canvas.height = rect.height * dpr;
                                const ctx = canvas.getContext('2d');
                                ctx.scale(dpr, dpr);
                            }

                            Chart.defaults.font.family = '"Source Sans 3", sans-serif';
                            Chart.defaults.font.size = 12;
                            Chart.defaults.color = '#4F5153';

                            const SIGECES_COLORS = [
                                '#570926',
                                '#FDBA4D',
                                '#4F5153',
                                '#16A34A',
                                '#0EA5E9',
                                '#DC2626',
                            ];

                            // ————————————————————————————————————
                            // 1) Inscripciones por curso (Barras)
                            // ————————————————————————————————————
                            const canvasBar = document.getElementById('inscripcionesChart');
                            resizeCanvas(canvasBar);
                            const rawBar = <?= json_encode($data['asignacionesPorCurso'], JSON_HEX_TAG) ?>;
                            const labelsBar = rawBar.map(r => r.curso);
                            const valuesBar = rawBar.map(r => r.total);
                            new Chart(canvasBar, {
                                type: 'bar',
                                data: {
                                    labels: labelsBar,
                                    datasets: [{
                                        label: 'Asignaciones',
                                        data: valuesBar,
                                        backgroundColor: SIGECES_COLORS.slice(0, valuesBar.length),
                                        borderColor: '#ffffff',
                                        borderWidth: 2,
                                    }]
                                },
                                options: {
                                    layout: {
                                        padding: 16
                                    },
                                    scales: {
                                        x: {
                                            grid: {
                                                display: false
                                            },
                                            ticks: {
                                                maxRotation: 0,
                                                autoSkip: true
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            ticks: {
                                                stepSize: 1
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        title: {
                                            display: true,
                                            text: 'Asignaciones por Curso',
                                            padding: {
                                                bottom: 10
                                            }
                                        },
                                        tooltip: {
                                            padding: 8,
                                            titleFont: {
                                                weight: '600'
                                            }
                                        }
                                    }
                                }
                            });

                            // ————————————————————————————————————
                            // 2) Distribución de Roles (Doughnut)
                            // ————————————————————————————————————
                            const canvasPie = document.getElementById('rolesChart');
                            resizeCanvas(canvasPie);
                            const rawPie = <?= json_encode($data['rolesDist'], JSON_HEX_TAG) ?>;
                            const labelsPie = rawPie.map(r => r.rol.charAt(0).toUpperCase() + r.rol.slice(1));
                            const valuesPie = rawPie.map(r => r.total);
                            new Chart(canvasPie, {
                                type: 'doughnut',
                                data: {
                                    labels: labelsPie,
                                    datasets: [{
                                        data: valuesPie,
                                        backgroundColor: SIGECES_COLORS,
                                        borderColor: '#ffffff',
                                        borderWidth: 2
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: true,
                                    cutout: '50%',
                                    plugins: {
                                        legend: {
                                            position: 'bottom',
                                            labels: {
                                                padding: 16
                                            }
                                        },
                                        title: {
                                            display: true,
                                            text: 'Distribución de Roles',
                                            padding: {
                                                bottom: 10
                                            }
                                        }
                                    }
                                }
                            });

                            // ————————————————————————————————————
                            // 3) Tendencia de Inscripciones (Línea)
                            // ————————————————————————————————————
                            const canvasLine = document.getElementById('inscripcionesTrendChart');
                            resizeCanvas(canvasLine);
                            const ctxLine = canvasLine.getContext('2d');
                            const gradient = ctxLine.createLinearGradient(0, 0, 0, 300);
                            gradient.addColorStop(0, 'rgba(253,186,77,0.5)');
                            gradient.addColorStop(1, 'rgba(253,186,77,0)');
                            const rawLine = <?= json_encode($data['inscripcionesTrend'], JSON_HEX_TAG) ?>;
                            const labelsLine = rawLine.map(r => r.fecha);
                            const valuesLine = rawLine.map(r => r.total);

                            new Chart(ctxLine, {
                                type: 'line',
                                data: {
                                    labels: labelsLine,
                                    datasets: [{
                                        label: 'Inscripciones diarias',
                                        data: valuesLine,
                                        fill: true,
                                        backgroundColor: gradient,
                                        borderColor: '#FDBA4D',
                                        borderWidth: 3,
                                        tension: 0.4,
                                        pointRadius: 3
                                    }]
                                },
                                options: {
                                    scales: {
                                        x: {
                                            type: 'time',
                                            time: {
                                                unit: 'day',
                                                displayFormats: {
                                                    day: 'MMM d'
                                                }
                                            },
                                            grid: {
                                                color: '#e0e0e0'
                                            }
                                        },
                                        y: {
                                            beginAtZero: true,
                                            grid: {
                                                color: '#e0e0e0'
                                            }
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: false
                                        },
                                        title: {
                                            display: true,
                                            text: 'Tendencia (últimos 30 días)',
                                            padding: {
                                                bottom: 10
                                            }
                                        },
                                        tooltip: {
                                            mode: 'index',
                                            intersect: false
                                        }
                                    },
                                    interaction: {
                                        mode: 'nearest',
                                        intersect: false
                                    }
                                }
                            });
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