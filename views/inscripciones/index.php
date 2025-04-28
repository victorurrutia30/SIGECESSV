<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'estudiante') {
    header("Location: ../../index.php");
    exit;
}

require_once '../../models/Asignacion.php';
$asignacion = new Asignacion();
$cursos     = $asignacion->obtenerCursos();

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
                        <div class="alert alert-<?= ($_GET['msg'] == 'full' ? 'warning' : 'success') ?>">
                            <?= $_GET['msg'] == 'full' ? 'Lo siento, el curso está lleno.' : 'Inscripción exitosa.' ?>
                        </div>
                    <?php endif; ?>

                    <div class="row g-4">
                        <?php foreach ($cursos as $c):
                            $count = $asignacion->contarAsignacionesPorCurso($c['id']);
                            $cupoMax = 30;
                            $inscrito = false;
                            // comprobar si ya está inscrito:
                            $mis = $asignacion->cursosAsignados($_SESSION['usuario']['id']);
                            foreach ($mis as $m) {
                                if ($m['id'] == $c['id']) {
                                    $inscrito = true;
                                    break;
                                }
                            }
                        ?>
                            <div class="col-md-6 col-lg-3">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h5><?= htmlspecialchars($c['nombre']) ?></h5>
                                        <?php if ($inscrito): ?>
                                            <span class="badge bg-success">Inscrito</span>
                                        <?php elseif ($count >= $cupoMax): ?>
                                            <span class="badge bg-warning">Lleno</span>
                                        <?php else: ?>
                                            <form action="../../controller/AsignacionController.php" method="POST">
                                                <input type="hidden" name="inscribir" value="1">
                                                <input type="hidden" name="id_curso" value="<?= $c['id'] ?>">
                                                <button class="btn btn-dashboard w-100">Inscribirme</button>
                                            </form>
                                        <?php endif; ?>
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