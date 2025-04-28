<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'estudiante') {
    header("Location: ../../index.php");
    exit;
}

require_once '../../models/Inscripcion.php';
$ins = new Inscripcion();
$id_usuario = $_SESSION['usuario']['id'];
$inscripciones = $ins->listarPorUsuario($id_usuario);

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
                        <div class="alert alert-info text-center">No tienes inscripciones aún.</div>
                    <?php else: ?>
                        <table class="table table-bordered table-mis-cursos text-center">
                            <thead>
                                <tr>
                                    <th>Curso</th>
                                    <th>Fecha</th>
                                    <th>Anular</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($inscripciones as $i): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($i['nombre']) ?></td>
                                        <td><?= $i['fecha_inscripcion'] ?></td>
                                        <td>
                                            <form action="../../controller/InscripcionController.php" method="POST">
                                                <input type="hidden" name="anular" value="1">
                                                <input type="hidden" name="id_curso" value="<?= $i['id_curso'] ?>">
                                                <button class="btn btn-sm btn-outline-danger">Anular</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </main>

        <?php include '../partials/footer.php'; ?>
    </div>
</body>

</html>