<?php
session_start();
if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['rol'] !== 'estudiante') {
    header("Location: ../../index.php");
    exit;
}

require_once '../../models/Asignacion.php';
require_once '../../models/Inscripcion.php';

$asignacion = new Asignacion();
$insModel   = new Inscripcion();
$cursos     = $asignacion->obtenerCursos();
$id_usuario = $_SESSION['usuario']['id'];

// 1) Inscripciones hechas por el propio estudiante
$selfIns   = $insModel->listarPorUsuario($id_usuario);
$inscritos = [];
foreach ($selfIns as $i) {
    $inscritos[] = $i['id_curso'];
}

// 2) Cursos asignados por admin
$adminCursos = $asignacion->cursosAsignados($id_usuario);
foreach ($adminCursos as $ac) {
    $inscritos[] = $ac['id'];
}

// 3) Eliminamos duplicados
$inscritos = array_unique($inscritos);

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
                            <?= $_GET['msg'] == 'full'
                                ? 'Lo siento, el curso está lleno.'
                                : 'Inscripción exitosa.' ?>
                        </div>
                    <?php endif; ?>

                    <!-- Barra de búsqueda -->
                    <div class="mb-4">
                        <input
                            type="text"
                            id="searchInput"
                            class="form-control"
                            placeholder="Buscar curso...">
                    </div>

                    <div class="row g-4" id="coursesContainer">
                        <?php foreach ($cursos as $c):
                            $yaInscrito = in_array($c['id'], $inscritos);
                            $tieneCupo  = $insModel->cuposDisponibles($c['id']);
                        ?>
                            <div class="col-md-6 col-lg-3 course-card">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h5 class="course-name"><?= htmlspecialchars($c['nombre']) ?></h5>
                                        <?php if ($yaInscrito): ?>
                                            <span class="badge bg-success">Inscrito</span>
                                        <?php elseif (!$tieneCupo): ?>
                                            <span class="badge bg-warning">Lleno</span>
                                        <?php else: ?>
                                            <form action="../../controller/InscripcionController.php" method="POST">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const input = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.course-card');
            input.addEventListener('input', () => {
                const q = input.value.toLowerCase();
                cards.forEach(card => {
                    const name = card.querySelector('.course-name').textContent.toLowerCase();
                    card.style.display = name.includes(q) ? '' : 'none';
                });
            });
        });
    </script>