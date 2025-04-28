<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../../index.php");
    exit;
}

require_once '../../models/Asignacion.php';
require_once '../../models/Inscripcion.php';
require_once '../../models/Nota.php';

$asignModel = new Asignacion();
$insModel   = new Inscripcion();
$notaModel  = new Nota();
$id_usuario = $_SESSION['usuario']['id'];

// Traer cursos asignados por admin
$adminCursos = $asignModel->cursosAsignados($id_usuario);
// Traer inscripciones hechas por el propio estudiante
$selfIns = $insModel->listarPorUsuario($id_usuario);

// Consolidar y deduplicar
$courses = [];
foreach ($adminCursos as $c) {
    $courses[$c['id']] = [
        'id'     => $c['id'],
        'nombre' => $c['nombre'],
        'source' => 'admin'
    ];
}
foreach ($selfIns as $i) {
    // Solo agregar si no existe todavía
    if (!isset($courses[$i['id_curso']])) {
        $courses[$i['id_curso']] = [
            'id'     => $i['id_curso'],
            'nombre' => $i['nombre'],
            'source' => 'self'
        ];
    }
}

$pageTitle = 'Mis Cursos';
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
                <div class="container-fluid mis-cursos-section my-5">
                    <?php if (empty($courses)): ?>
                        <div class="alert alert-info text-center">No tienes cursos asignados aún.</div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover text-center align-middle">
                                <thead>
                                    <tr>
                                        <th>ID Curso</th>
                                        <th>Nombre del Curso</th>
                                        <th>Nota Actual</th>
                                        <th>Acción</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $c): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($c['id']) ?></td>
                                            <td><?= htmlspecialchars($c['nombre']) ?></td>
                                            <td>
                                                <?php
                                                $nota = $notaModel->obtenerNota($id_usuario, $c['id']);
                                                echo ($nota !== null) ? number_format($nota, 2) : '<span class="text-muted">Sin nota</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <!-- Ver Modal trigger -->
                                                <button
                                                    class="btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#viewModal<?= $c['id'] ?>">
                                                    Ver
                                                </button>

                                                <!-- Anular -->
                                                <form
                                                    action="../../controller/InscripcionController.php"
                                                    method="POST"
                                                    class="d-inline">
                                                    <input type="hidden" name="anular" value="1">
                                                    <input type="hidden" name="id_curso" value="<?= $c['id'] ?>">
                                                    <button class="btn btn-sm btn-outline-danger">
                                                        Anular
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <?php include '../partials/footer.php'; ?>
    </div>

    <!-- View Modal(s) -->
    <?php foreach ($courses as $c): ?>
        <div class="modal fade" id="viewModal<?= $c['id'] ?>" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Detalles del Curso</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>ID del Curso:</strong> <?= htmlspecialchars($c['id']) ?></p>
                        <p><strong>Nombre del Curso:</strong> <?= htmlspecialchars($c['nombre']) ?></p>
                        <p>
                            <strong>Asignado por:</strong>
                            <?= $c['source'] === 'admin' ? 'Administrador' : 'Auto-inscripción' ?>
                        </p>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>