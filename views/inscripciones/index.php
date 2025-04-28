<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'estudiante') {
    header("Location: ../../index.php");
    exit;
}

require_once '../../models/Curso.php';
require_once '../../models/Inscripcion.php';

$curso = new Curso();
$cursos = $curso->obtenerCursos();
$pageTitle = 'Inscripciones';
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
                <div class="container-fluid my-5">
                    <?php if (isset($_GET['msg'])): ?>
                        <div class="alert alert-<?= ($_GET['msg'] == 'full' ? 'warning' : 'success') ?>" role="alert">
                            <?php
                            if ($_GET['msg'] == 'ok')    echo "Inscripción exitosa.";
                            if ($_GET['msg'] == 'full')  echo "Lo siento, el curso está lleno.";
                            ?>
                        </div>
                    <?php endif; ?>

                    <div class="row g-4">
                        <?php foreach ($cursos as $c): ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5><?= htmlspecialchars($c['nombre']) ?></h5>
                                        <form action="../../controller/InscripcionController.php" method="POST">
                                            <input type="hidden" name="inscribir" value="1">
                                            <input type="hidden" name="id_curso" value="<?= $c['id'] ?>">
                                            <button class="btn btn-dashboard w-100">Inscribirse</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </main>

        <?php include '../partials/footer.php'; ?>
    </div>
</body>

</html>