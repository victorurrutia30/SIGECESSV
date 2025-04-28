<?php
session_start();
// … validación de sesión …
require_once '../../models/Asignacion.php';
$asignacion    = new Asignacion();
$id_usuario    = $_SESSION['usuario']['id'];
$inscripciones = $asignacion->obtenerLog($id_usuario);

$pageTitle = 'Mi Historial';
include '../partials/head.php';
?>

<body class="layout-fixed sidebar-expand-lg sidebar-mini bg-body-tertiary app-loaded sidebar-collapse">
    <div class="app-wrapper">
        <?php include '../partials/navbar.php'; ?>
        <?php include '../partials/sidebar.php'; ?>

        <main class="app-main">
            <div class="app-content-header">
                <div class="container-fluid">
                    <h1 class="mb-0"><?= htmlspecialchars($pageTitle) ?></h1>
                </div>
            </div>
            <div class="app-content">
                <div class="container-fluid my-5 mis-cursos-section">
                    <?php if ($inscripciones->num_rows === 0): ?>
                        <div class="alert alert-info text-center">No hay historial de inscripciones.</div>
                    <?php else: ?>
                        <table class="table table-bordered text-center">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Acción</th>
                                    <th>Quién</th>
                                    <th>Fecha</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $inscripciones->fetch_assoc()): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($row['curso_nombre']) ?></td>
                                        <td><?= $row['accion'] === 'asignacion' ? 'Inscribió' : 'Anuló' ?></td>
                                        <td><?= htmlspecialchars($row['actor_nombre']) ?></td>
                                        <td><?= $row['fecha_asignacion'] ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <?php include '../partials/footer.php'; ?>
    </div>